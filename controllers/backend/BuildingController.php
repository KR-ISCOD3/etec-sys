<?php
    class BuildingController {

        private static function response($status, $message = "", $data = []) {
            echo json_encode([
                "status" => $status,
                "message" => $message,
                "data" => $data
            ]);
            exit;
        }

        /**
         * Insert building → floors → rooms
         */
        public static function create($conn, $buildingName, $floorsJson, $createdBy) {
            $floors = json_decode($floorsJson, true);
            if (!$buildingName || empty($floors)) {
                self::response(false, "Invalid input data");
            }

            $conn->begin_transaction();
            try {
                // Insert building
                $stmt = $conn->prepare("INSERT INTO buildings (name, created_by) VALUES (?, ?)");
                $stmt->bind_param("si", $buildingName, $createdBy);
                if (!$stmt->execute()) throw new Exception($stmt->error);
                $buildingId = $stmt->insert_id;
                $stmt->close();

                // Insert floors and rooms
                foreach ($floors as $floor) {
                    $floorName = $floor['floor_name'];
                    $stmt = $conn->prepare("INSERT INTO floors (building_id, floor, created_by) VALUES (?, ?, ?)");
                    $stmt->bind_param("isi", $buildingId, $floorName, $createdBy);
                    if (!$stmt->execute()) throw new Exception($stmt->error);
                    $floorId = $stmt->insert_id;
                    $stmt->close();

                    // Insert rooms
                    $rooms = $floor['rooms'] ?? [];
                    if (!empty($rooms)) {
                        $values = [];
                        $types = '';
                        $params = [];
                        foreach ($rooms as $room) {
                            $values[] = "(?, ?, ?, ?)";
                            $types .= "iisi";
                            $params[] = $buildingId;
                            $params[] = $floorId;
                            $params[] = $room;
                            $params[] = $createdBy;
                        }
                        $sql = "INSERT INTO rooms (building_id, floor_id, room, created_by) VALUES ".implode(',', $values);
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param($types, ...$params);
                        if (!$stmt->execute()) throw new Exception($stmt->error);
                        $stmt->close();
                    }
                }

                $conn->commit();
                self::response(true, "Building, floors, and rooms created successfully");
            } catch (Exception $e) {
                $conn->rollback();
                self::response(false, "Transaction failed: ".$e->getMessage());
            }
        }

        // fetch all data
        public static function fetchAll($conn) {
            $sql = "
                SELECT 
                    b.id AS building_id, b.name AS building_name,
                    f.id AS floor_id, f.floor AS floor_name,
                    r.id AS room_id, r.room AS room_name
                FROM buildings b
                LEFT JOIN floors f ON f.building_id = b.id
                LEFT JOIN rooms r ON r.floor_id = f.id
                ORDER BY b.id, f.id, r.id
            ";

            $result = $conn->query($sql);
            if (!$result) {
                self::response(false, "Query failed: " . $conn->error);
            }

            $data = [];

            while ($row = $result->fetch_assoc()) {
                $bId = $row['building_id'];
                $fId = $row['floor_id'];
                $rId = $row['room_id'];

                if (!isset($data[$bId])) {
                    $data[$bId] = [
                        "building_id" => $bId,
                        "building_name" => $row['building_name'],
                        "floors" => []
                    ];
                }

                if ($fId && !isset($data[$bId]['floors'][$fId])) {
                    $data[$bId]['floors'][$fId] = [
                        "floor_id" => $fId,
                        "floor_name" => $row['floor_name'],
                        "rooms" => []
                    ];
                }

                if ($rId) {
                    $data[$bId]['floors'][$fId]['rooms'][] = [
                        "room_id" => $rId,
                        "room_name" => $row['room_name']
                    ];
                }
            }

            // Reset array keys (optional, for clean JSON)
            $data = array_values(array_map(function($building) {
                $building['floors'] = array_values(array_map(function($floor) {
                    $floor['rooms'] = array_values($floor['rooms']);
                    return $floor;
                }, $building['floors']));
                return $building;
            }, $data));

            self::response(true, "Fetched successfully", $data);
        }

        public static function update($conn, $building_id, $building_name, $floorsJson, $user_id)
        {
            $floors = json_decode($floorsJson, true);
            if (!is_array($floors)) {
                http_response_code(400);
                echo json_encode([
                    'status' => false,
                    'message' => 'Invalid floors data'
                ]);
                exit;
            }

            $conn->begin_transaction();

            try {
                // ✅ Use `id` instead of `building_id`
                $stmt = $conn->prepare(
                    "UPDATE buildings SET name = ?, created_by = ? WHERE id = ?"
                );
                $stmt->bind_param("sii", $building_name, $user_id, $building_id);
                if (!$stmt->execute()) throw new Exception($stmt->error);
                $stmt->close();

                // ✅ Delete old rooms first
                $stmt = $conn->prepare(
                    "DELETE FROM rooms WHERE floor_id IN (SELECT id FROM floors WHERE building_id = ?)"
                );
                $stmt->bind_param("i", $building_id);
                if (!$stmt->execute()) throw new Exception($stmt->error);
                $stmt->close();

                // ✅ Delete old floors
                $stmt = $conn->prepare("DELETE FROM floors WHERE building_id = ?");
                $stmt->bind_param("i", $building_id);
                if (!$stmt->execute()) throw new Exception($stmt->error);
                $stmt->close();

                // ✅ Re-insert new floors and rooms
                foreach ($floors as $floor) {
                    $floorName = $floor['floor_name'];

                    $stmt = $conn->prepare("INSERT INTO floors (building_id, floor, created_by) VALUES (?, ?, ?)");
                    $stmt->bind_param("isi", $building_id, $floorName, $user_id);
                    if (!$stmt->execute()) throw new Exception($stmt->error);
                    $floorId = $stmt->insert_id;
                    $stmt->close();

                    $rooms = $floor['rooms'] ?? [];
                    if (!empty($rooms)) {
                        $values = [];
                        $types = '';
                        $params = [];
                        foreach ($rooms as $room) {
                            $values[] = "(?, ?, ?, ?)";
                            $types .= "iisi";
                            $params[] = $building_id;
                            $params[] = $floorId;
                            $params[] = $room;
                            $params[] = $user_id;
                        }
                        $sql = "INSERT INTO rooms (building_id, floor_id, room, created_by) VALUES ".implode(',', $values);
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param($types, ...$params);
                        if (!$stmt->execute()) throw new Exception($stmt->error);
                        $stmt->close();
                    }
                }

                $conn->commit();
                self::response(true, "Building updated successfully");
            } catch (Exception $e) {
                $conn->rollback();
                self::response(false, "Update failed: " . $e->getMessage());
            }
        }

        public static function delete($conn, $building_id)
        {
            if (!$building_id) {
                self::response(false, "Invalid building ID");
            }

            $conn->begin_transaction();
            try {
                // Delete rooms first (because they depend on floors)
                $stmt = $conn->prepare(
                    "DELETE FROM rooms WHERE floor_id IN (SELECT id FROM floors WHERE building_id = ?)"
                );
                $stmt->bind_param("i", $building_id);
                if (!$stmt->execute()) throw new Exception($stmt->error);
                $stmt->close();

                // Delete floors
                $stmt = $conn->prepare("DELETE FROM floors WHERE building_id = ?");
                $stmt->bind_param("i", $building_id);
                if (!$stmt->execute()) throw new Exception($stmt->error);
                $stmt->close();

                // Finally delete building
                $stmt = $conn->prepare("DELETE FROM buildings WHERE id = ?");
                $stmt->bind_param("i", $building_id);
                if (!$stmt->execute()) throw new Exception($stmt->error);
                $stmt->close();

                $conn->commit();
                self::response(true, "Building deleted successfully");
            } catch (Exception $e) {
                $conn->rollback();
                self::response(false, "Delete failed: " . $e->getMessage());
            }
        }



    }
