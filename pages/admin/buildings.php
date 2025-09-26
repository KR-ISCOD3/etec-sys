<section>
    <h3 class="mb-0">Building Management</h3>
    <p class="text-secondary mb-3">Manage the Building at your school</p>

    <!-- Top toolbar -->
    <div class="p-0 border-bottom pb-2">
        <div class="d-flex justify-content-between align-items-center">
            <!-- form search -->
            <div class="col-3 pb-3">
                <form class="d-flex border rounded bg-white">
                    <input type="text" placeholder="Search Course..." class="form-control shadow-none border-0 bg-transparent">
                    <button class="btn">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <!-- btn add course -->
            <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#addBuildingModal">
                <i class="bi bi-plus-lg me-1"></i> Add Building
            </button>
        </div>
    </div>

    <!-- Success Alert -->
    <div id="successAlert" class="alert alert-success alert-dismissible fade show mt-3" style="display:none;" role="alert">
        <span id="successMessage"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>


    <div class="mt-4">

        <!-- Building Card -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0 text-secondary">Building A</h5>
            </div>

            <!-- Floors Accordion -->
            <div id="buildingA" >
                <div class="card-body">

                    <!-- Floor 1 -->
                    <div class="pb-2 border-bottom">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="mb-0 text-etec-color">Floor 1</h6>
                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#floor1Rooms">
                                View Rooms
                            </button>
                        </div>

                        <!-- Rooms Grid -->
                        <div id="floor1Rooms" class="collapse mt-2">
                            <div class="row g-2">
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <h6 class="mb-1">Room 101</h6>
                                    <span class="badge bg-success">Available</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <h6 class="mb-1">Room 102</h6>
                                    <span class="badge bg-danger">Occupied</span>
                                </div>
                            </div>
                            <!-- Add more rooms -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>


    <!-- Add Building Modal -->
    <div class="modal fade" id="addBuildingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="addBuildingForm">
                    <div class="modal-header">
                    <h5 class="modal-title">Add Building</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Building Name -->
                        <div class="mb-3">
                            <label class="form-label">Building Name</label>
                            <input type="text" id="buildingName" class="form-control shadow-none border" placeholder="Enter building name" required>
                        </div>

                        <!-- Floors Container -->
                        <div id="floorsContainer"></div>

                        <!-- Add Floor Button -->
                        <button type="button" id="addFloorBtn" class="btn btn-secondary mb-3">+ Add Floor</button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Building</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Update Building Modal -->
    <div class="modal fade" id="updateBuilding" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="updateBuildingForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Building</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                    <!-- Building Name -->
                    <div class="mb-3">
                        <label class="form-label">Building Name</label>
                        <!-- keep all your existing attributes here -->
                        <input id="updateBuildingName" class="form-control shadow-none border">
                    </div>

                    <!-- Floors Container -->
                    <div id="updateFloorsContainer"></div>

                    <!-- Add Floor Button -->
                    <button type="button" id="updateAddFloorBtn" class="btn btn-secondary mb-3">
                        + Add Floor
                    </button>
                    </div>

                    <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Building</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Delete Course Modal -->
    <div class="modal fade" id="deleteBuildingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Delete Course</h6>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form id="deleteCourseForm">
                    <div class="modal-body">
                        <p class="mb-0">Are you sure you want to delete this course?</p>
                        <input type="hidden" id="deleteCourseId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</section>
<script>
    $(document).ready(function() {


        // Show alert
        function showAlert(message) {
            $('#successMessage').text(message);
            $('#successAlert').stop(true, true).fadeIn();
            setTimeout(function() {
                $('#successAlert').fadeOut('slow');
            }, 3000);
        }

        // Fetch all buildings from API
        function fetchBuildings() {
            $.ajax({
                url: 'api.php?endpoint=building_fetch_all',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (!res.status) {
                        console.error(res.message);
                        return;
                    }
                    // Call render function with data
                    renderBuildings(res.data);
                },
                error: function() {
                    console.error('Failed to load buildings');
                }
            });
        }

        // Render buildings into the container
        function renderBuildings(buildings) {
            const container = $('.container.mt-4');
            container.empty();

            if (!buildings || buildings.length === 0) {
                container.append(`
                    <div class="text-center py-5">
                        <i class="bi bi-building fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No buildings created yet</h5>
                        <p class="text-muted">Start by creating a new building to see it here.</p>
                    </div>
                `);
                return;
            }

            buildings.forEach(building => {
                let floorsHTML = '';

                building.floors.forEach(floor => {
                    let roomsHTML = floor.rooms.map(r => `
                        <div class="col-md-3 mb-2">
                            <div class="card p-3 shadow-sm rounded-3 hover-shadow">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-door-open fs-4 text-primary me-2"></i>
                                    <h6 class="mb-0">Room : ${r.room_name}</h6>
                                </div>
                            </div>
                        </div>
                    `).join('');

                    floorsHTML += `
                        <div class="py-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-building fs-5 text-etec-color"></i>
                                    <span class="mb-0 text-etec-color fs-5">${floor.floor_name}</span>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#floor${floor.floor_id}Rooms">
                                    <i class="bi bi-chevron-down"></i> View Rooms
                                </button>
                            </div>
                            <div id="floor${floor.floor_id}Rooms" class="collapse mt-2">
                                <div class="row g-3">${roomsHTML}</div>
                            </div>
                        </div>
                    `;
                });

                const buildingCard = `
                    <div class="card mb-4 shadow-sm hover-shadow" data-building='${JSON.stringify(building)}'>
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <h5 class="mb-0 text-secondary">
                                <i class="bi bi-house-door-fill me-2"></i>${building.building_name}
                            </h5>
                            <div>
                                <button class="btn btn-sm btn-primary me-1 btn-edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-delete" data-bs-toggle="modal" data-bs-target="#deleteBuildingModal" data-id="${building.building_id}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">${floorsHTML}</div>
                    </div>
                `;

                container.append(buildingCard);
            });
        }


        // Call it on page load
        fetchBuildings();


        // Add Floor
        $('#addFloorBtn').click(function() {
            const floorTemplate = `
            <div class="floorCard border p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <input type="text" class="form-control shadow-none border floorName me-2" placeholder="Floor name" required>
                    <button type="button" class="btn btn-danger removeFloorBtn">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>

                
                <div class="d-flex mb-2">
                    <input type="text" class="form-control shadow-none border roomInput me-2" placeholder="Enter room name">
                    <button type="button" class="btn btn-primary addRoomBtn">
                        <i class="bi bi-plus-square"></i>
                    </button>
                </div>
                <div class="roomsContainer mb-2 border p-2" style="height: 50px; overflow-x: auto; white-space: nowrap;">
                    <!-- room badges here -->
                </div>

            </div>`;
            $('#floorsContainer').append(floorTemplate);
        });

        // Remove Floor
        $(document).on('click', '.removeFloorBtn', function() {
            $(this).closest('.floorCard').remove();
        });

        // Add Room to a floor
        $(document).on('click', '.addRoomBtn', function() {
            const input = $(this).siblings('.roomInput');
            const roomName = input.val().trim();
            if (!roomName) return;
            
            // Create badge
            const badge = $(`
                <span class="badge bg-secondary me-1 d-inline-flex align-items-center">
                    ${roomName}
                    <button type="button" class="btn-close btn-close-white ms-1 shadow-none" style="font-size:0.6rem;"></button>
                </span>
            `);

            // Remove room badge
            badge.find('.btn-close').click(function() {
                badge.remove();
            });

            $(this).closest('.floorCard').find('.roomsContainer').append(badge);
            input.val('');
        });

        // Btn edit
        $(document).on('click', '.btn-edit', function () {
            const card = $(this).closest('.card');
            const building = JSON.parse(card.attr('data-building'));

            // Fill building name
            $('#updateBuildingName').val(building.building_name);

            // Clear previous floors
            $('#updateFloorsContainer').empty();

            // Populate floors and rooms like in rendering
            building.floors.forEach((floor, floorIndex) => {
                const floorDiv = $(`
                    <div class="floorCard border p-3 mb-3" data-floor-index="${floorIndex}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <input type="text" class="form-control shadow-none border floorName me-2" value="${floor.floor_name}" placeholder="Floor name" required>
                            <button type="button" class="btn btn-danger removeFloorBtn">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <div class="d-flex mb-2">
                            <input type="text" class="form-control shadow-none border roomInput me-2" placeholder="Enter room name">
                            <button type="button" class="btn btn-primary addRoomBtn">
                                <i class="bi bi-plus-square"></i>
                            </button>
                        </div>

                        <div class="roomsContainer mb-2 border p-2" style="height: 50px; overflow-x: auto; white-space: nowrap;">
                        </div>
                    </div>
                `);

                // Populate rooms as badges
                floor.rooms.forEach(room => {
                    const badge = $(`
                        <span class="badge bg-secondary me-1 d-inline-flex align-items-center">
                            ${room.room_name}
                            <button type="button" class="btn-close btn-close-white ms-1 shadow-none" style="font-size:0.6rem;"></button>
                        </span>
                    `);

                    // Remove badge
                    badge.find('.btn-close').click(function() {
                        badge.remove();
                    });

                    floorDiv.find('.roomsContainer').append(badge);
                });

                $('#updateFloorsContainer').append(floorDiv);
            });

            // Store building id for update
            $('#updateBuildingForm').data('edit-id', building.building_id);

            // Show modal
            $('#updateBuilding').modal('show');
        });

        // Open modal and set building id
        $(document).on('click', '.btn-delete', function () {
            const buildingId = $(this).data('id');
            $('#deleteCourseId').val(buildingId);
        });

        // Add new floor input
        $('#updateAddFloorBtn').on('click', function () {

            const floorTemplate = `
                <div class="floorCard border p-3 mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <input type="text" class="form-control shadow-none border floorName me-2" placeholder="Floor name" required>
                        <button type="button" class="btn btn-danger removeFloorBtn">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                    <div class="d-flex mb-2">
                        <input type="text" class="form-control shadow-none border roomInput me-2" placeholder="Enter room name">
                        <button type="button" class="btn btn-primary addRoomBtn">
                            <i class="bi bi-plus-square"></i>
                        </button>
                    </div>

                    <div class="roomsContainer mb-2 border p-2" style="height: 50px; overflow-x: auto; white-space: nowrap;"></div>
                </div>
            `;

            $('#updateFloorsContainer').append(floorTemplate);
        });


        // Submit form
        $('#addBuildingForm').submit(function(e) {
            e.preventDefault();

            const buildingName = $('#buildingName').val().trim();
            if (!buildingName) return alert('Please enter building name.');

            const floors = [];

            $('.floorCard').each(function() {
                const floorName = $(this).find('.floorName').val().trim();
                if (!floorName) return; // skip empty floor

                const rooms = [];
                $(this).find('.roomsContainer .badge').each(function() {
                    rooms.push($(this).text().trim());
                });

                floors.push({ floor_name: floorName, rooms });
            });

            if (floors.length === 0) return alert('Add at least one floor with rooms.');

            $.ajax({
                url: 'api.php?endpoint=building_create',
                method: 'POST',
                data: {
                    building_name: buildingName,
                    floors: JSON.stringify(floors)
                },
                success: function(data) {
                    if (data.status) {
                        $('#addBuildingModal').modal('hide');
                        $('#addBuildingForm')[0].reset();
                        $('#floorsContainer').empty();
                        fetchBuildings()
                        showAlert(data.message); // fixed
                    } else {
                        alert(data.message || 'Failed to create building');
                    }
                },
                error: function() {
                    alert('Request failed');
                }
            });
        });


        $('#updateBuildingForm').submit(function (e) {
            e.preventDefault();

            const buildingId = $(this).data('edit-id');
            const buildingName = $('#updateBuildingName').val().trim();
            if (!buildingName) return alert('Please enter building name.');

            const floors = [];

            $('#updateFloorsContainer .floorCard').each(function () {
                const floorName = $(this).find('.floorName').val().trim();
                if (!floorName) return; // skip empty floor

                const rooms = [];

                // Existing badges
                $(this).find('.roomsContainer .badge').each(function () {
                    rooms.push($(this).text().trim());
                });

                // New room input fields
                $(this).find('.roomInput').each(function () {
                    const val = $(this).val().trim();
                    if (val) rooms.push(val);
                });

                floors.push({ floor_name: floorName, rooms });
            });

            $.ajax({
                url: 'api.php?endpoint=building_update',
                method: 'POST',
                dataType: 'json', // <— important to tell jQuery we expect JSON
                data: {
                    building_id: buildingId,
                    building_name: buildingName,
                    floors: JSON.stringify(floors)
                },
                success: function (data) {
                    if (data.status) {
                        $('#updateBuilding').modal('hide');
                        $('#updateFloorsContainer').empty();
                        showAlert(data.message);
                        fetchBuildings();
                    } else {
                        alert(data.message || 'Failed to update building');
                    }
                },
                error: function (xhr, textStatus, errThrown) {
                    console.error('AJAX Error:', textStatus, errThrown, xhr.responseText);
                    alert('Request failed');
                }
            });
        });

        // Handle form submit
        $('#deleteCourseForm').submit(function (e) {
            e.preventDefault();
            const id = $('#deleteCourseId').val();

            $.ajax({
                url: 'api.php?endpoint=building_delete', 
                method: 'POST',
                data: { building_id: id },
                dataType: 'json',
                success: function (res) {
                    console.log(res);
                    $('#deleteCourseModal').modal('hide');
                    if (res.status) {
                        showAlert(res.message);
                        fetchBuildings(); // 👈 refresh your course list function
                    } else {
                        alert(res.message);
                    }
                },
                error: function () {
                    $('#deleteCourseModal').modal('hide');
                    alert('Failed to delete course.');
                }
            });
        });


    });


</script>