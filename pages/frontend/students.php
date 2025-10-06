<?php
// Get class_id from URL
$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;
?>

<!-- Hidden input for class ID -->
<input type="hidden" name="class_id" id="class_id" value="<?= $class_id ?>" readonly>

<section>
    <a href="pages/frontend/classes.php" class="nav-link-ajax mb-3 text-secondary text-decoration-none">Back to Class </a>

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="mb-0">Track Attendence</h3>
            <p class="text-secondary mb-0">Tack your student attendence</p>
        </div>
        <div>
            <button class="btn btn-success" id="saveAllScoresBtn">
                Save Score
            </button>
            <button id="trackAttendanceBtn" class="btn btn-primary"> 
                Track Attendence
            </button> 
        </div>               
    </div>

    <!-- Success Alert -->
    <div id="successAlert" class="alert alert-success alert-dismissible fade show mt-3" style="display:none;" role="alert">
        <span id="successMessage"></span>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="container-fluid my-4 p-0">
        <div class="card p-0">
            <div class="card-header bg-etec-color text-white text-center">
                <h5 class="mb-0">Student Attendance & Score</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Tel</th>
                                <th style="width: 13%;">Attendance</th>
                                <th colspan="3">Score</th>
                                <th class="text-center">Action</th>
                            </tr>
                            <tr>
                                <th colspan="5"></th>
                                <th class="col-1">Attendance Score</th>
                                <th class="col-1">Activity Score</th>
                                <th class="col-1">Exam Score</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="students-tbody">
                            <?php require __DIR__.'../../../utils/tablestu_skelaton.php' ?>
                        </tbody>
                            
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Modal -->
    <div class="modal fade" id="attModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="attModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-etec-color text-white">
                    <h5 class="modal-title" id="attModalLabel">Track Attendance</h5>
                    <button type="button" style="filter: invert(1) grayscale(100%) brightness(200%);" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Attendance</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody id="modal-students-tbody">
                            
                        </tbody>
                    </table>
                    <p id="date" class="mt-2"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="saveAttendance">
                        Save Attendance
                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Student Modal -->
    <div class="modal fade" id="modalUpdateStudent" tabindex="-1" aria-labelledby="modalUpdateStudentLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-etec-color text-white">
                    <h5 class="modal-title" id="modalUpdateStudentLabel">Update Student</h5>
                    <button type="button" style="filter: invert(1) grayscale(100%) brightness(200%);"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateStudentForm">
                        <input type="hidden" id="update-stu-id" name="stu_id">

                        <div class="mb-3">
                            <label for="update-full-name" class="form-label">Full Name</label>
                            <input type="text" class="form-control shadow-none" id="update-full-name" name="full_name" placeholder="Enter full name" required>
                        </div>

                        <div class="mb-3">
                            <label for="update-gender" class="form-label">Gender</label>
                            <select class="form-select shadow-none" id="update-gender" name="gender" required>
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="update-tel" class="form-label">Phone Number</label>
                            <input type="text" class="form-control shadow-none" id="update-tel" name="tel" placeholder="Enter phone number">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button id="saveUpdateStudent" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
                   
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="modalDeleteStudent" tabindex="-1" aria-labelledby="modalDeleteStudentLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalDeleteStudentLabel">Confirm Delete</h5>
                    <button type="button" style="filter: invert(1) grayscale(100%) brightness(200%);" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-1 mb-3"></i>
                    <p class="fw-bold">Are you sure you want to delete this student?</p>
                    <p class="text-secondary mb-0" id="delete-student-name"></p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteStudent" class="btn btn-danger">
                        Delete
                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>


</section>



<script>
    $(document).ready(function(){
        
        const class_id = $("#class_id").val();

        function toggleSpinner(button, show) {
            const $btn = $(button);
            const $spinner = $btn.find(".spinner-border");
            if(show){
                $spinner.removeClass("d-none");
                $btn.prop("disabled", true);
            } else {
                $spinner.addClass("d-none");
                $btn.prop("disabled", false);
            }
        }

        function showAlert(message){
            $('#successMessage').text(message);
            $('#successAlert').stop(true,true).fadeIn();
            setTimeout(() => $('#successAlert').fadeOut('slow'), 3000);
        }

        if(!class_id || class_id <= 0){
            console.error("Invalid Class ID");
            return;
        }

        function loadStudents(classId) {
            // Save current input values to restore after refresh
            const values = {};
            $("#students-tbody tr").each(function () {
                const $row = $(this);
                const stuId = $row.data("stu-id");
                values[stuId] = {
                    att: $row.find('input[placeholder="Attendance Score"]').val(),
                    act: $row.find('input[placeholder="Activity Score"]').val(),
                    exam: $row.find('input[placeholder="Exam Score"]').val()
                };
            });

            // Fade skeletons (if present) to indicate loading
            $("#students-tbody tr").fadeTo(200, 0.6);

            $.ajax({
                url: 'api.php?endpoint=get_students_by_class&class_id=' + classId,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.status) {
                        $('#students-tbody').empty(); // Clear skeletons

                        if (res.data.length > 0) {
                            res.data.forEach((student, index) => {
                                const attScore = values[student.stu_id]?.att ?? student.att_score;
                                const actScore = values[student.stu_id]?.act ?? student.act_score;
                                const examScore = values[student.stu_id]?.exam ?? student.exam_score;

                                const rowContent = `
                                    <tr data-stu-id="${student.stu_id}" style="display:none;">
                                        <td>${index + 1}</td>
                                        <td>${student.full_name}</td>
                                        <td>${student.gender}</td>
                                        <td>${student.tel}</td>
                                        <td class="text-start attendance-summary">
                                            <div class="p-2 bg-success rounded text-white">
                                                <p class="mb-1"><strong>Present:</strong> 0</p>
                                                <p class="mb-1"><strong>Permission:</strong> 0</p>
                                                <p class="mb-1"><strong>Absent:</strong> 0</p>
                                            </div>
                                        </td>
                                        <td><input type="number" disabled value="${attScore}" class="form-control shadow-none border" placeholder="Attendance Score"></td>
                                        <td><input type="number" min="0" max="30" value="${actScore}" class="form-control shadow-none border" placeholder="Activity Score"></td>
                                        <td><input type="number" min="0" max="30" value="${examScore}" class="form-control shadow-none border" placeholder="Exam Score"></td>
                                        <td class="text-center">
                                            <button class="btn"><i class="bi bi-eye-fill"></i></button>
                                            <button class="btn"><i class="bi bi-arrow-left-right"></i></button>
                                            <button class="btn btn-light shadow-none border edit-student-btn"
                                                data-stu_id="${student.stu_id}" 
                                                data-name="${student.full_name}"
                                                data-gender="${student.gender}"
                                                data-tel="${student.tel}"
                                                data-bs-target="#modalUpdateStudent" 
                                                data-bs-toggle="modal">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button class="btn btn-danger delete-student-btn" data-stu_id="${student.stu_id}" data-bs-target="#modalDeleteStudent" data-bs-toggle="modal">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;

                                const $tr = $(rowContent);
                                $('#students-tbody').append($tr);
                                $tr.fadeIn(400); // Smooth fade-in
                            });

                            // Refresh attendance after rows are added
                            refreshAttendance();
                        } else {
                            $('#students-tbody').html(`
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" 
                                            alt="No students" 
                                            style="width:70px; opacity:0.5;" 
                                            class="mb-2">
                                        <div>Student Not Yet Added..</div>
                                    </td>
                                </tr>
                            `);
                        }
                    } else {
                        alert(res.message);
                    }
                },
                error: function () {
                    $('#students-tbody').html('<tr><td colspan="9" class="text-center text-danger">Failed to load students</td></tr>');
                }
            });
        }

        // Example usage:
        loadStudents(class_id); // Pass class_id here

        // Refresh attendance with input preservation
        function refreshAttendance() {
            const stu_ids = [];
            const values = {};

            $("#students-tbody tr").each(function() {
                const $row = $(this);
                const stuId = $row.data("stu-id");
                stu_ids.push(stuId);

                values[stuId] = {
                    att: $row.find('input[placeholder="Attendance Score"]').val(),
                    act: $row.find('input[placeholder="Activity Score"]').val(),
                    exam: $row.find('input[placeholder="Exam Score"]').val()
                };
            });

            if (stu_ids.length === 0) return;

            $.ajax({
                url: 'api.php?endpoint=count_attendance_by_students',
                type: 'POST',
                data: { stu_ids: JSON.stringify(stu_ids) },
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        res.data.forEach(student => {
                            const row = $(`tr[data-stu-id='${student.stu_id}']`);
                            if (row.length) {
                                row.find('.attendance-summary').html(`
                                    <div class="p-2 bg-success rounded text-white">
                                        <p class="mb-1"><strong>Present:</strong> ${student.total_present}</p>
                                        <p class="mb-1"><strong>Permission:</strong> ${student.total_permission}</p>
                                        <p class="mb-1"><strong>Absent:</strong> ${student.total_absent}</p>
                                    </div>
                                `);

                                // Restore input values
                                row.find('input[placeholder="Attendance Score"]').val(values[student.stu_id].att);
                                row.find('input[placeholder="Activity Score"]').val(values[student.stu_id].act);
                                row.find('input[placeholder="Exam Score"]').val(values[student.stu_id].exam);
                            }
                        });
                    }
                },
                error: function() {
                    console.error("❌ Failed to refresh attendance.");
                }
            });
        }

        // Track Attendance Button
        $("#trackAttendanceBtn").click(function(){
            const date = new Date();
            const today = date.getFullYear() + '-' +
                        String(date.getMonth() + 1).padStart(2, '0') + '-' +
                        String(date.getDate()).padStart(2, '0');
            $.ajax({
                url: "api.php?endpoint=is_attendance_recorded_today",
                method: "GET",
                data: { class_id: class_id, date: today },
                dataType: "json",
                success: function(res){
                    if(res.status){
                        $("#attModal").modal("show");
                    } else {
                        Swal.fire({ icon: 'warning', title: 'Oops!', text: res.message, confirmButtonText: 'OK' });
                    }
                },
                error: function(){
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to check attendance. Please try again.' });
                }
            });
        });

        // Fill Modal
        $('#attModal').on('show.bs.modal', function(){
            const modalBody = $("#modal-students-tbody");
            modalBody.empty();

            let date = new Date();
            let timestamp = date.getFullYear()+"-"+String(date.getMonth()+1).padStart(2,'0')+"-"+String(date.getDate()).padStart(2,'0')+" "+
                            String(date.getHours()).padStart(2,'0')+":"+String(date.getMinutes()).padStart(2,'0')+":"+String(date.getSeconds()).padStart(2,'0');
            $('#date').text(timestamp);

            $.ajax({
                url: 'api.php?endpoint=get_students_by_class',
                method: 'GET',
                data: { class_id: class_id },
                dataType: 'json',
                success: function(res){
                    if(res.status && res.data.length > 0){
                        res.data.forEach(student => {
                            const row = `
                                <tr data-id="${student.stu_id}">
                                    <td>${student.full_name}</td>
                                    <td>${student.gender}</td>
                                    <td>
                                        <button class="btn btn-success present-btn">P</button>
                                        <button class="btn btn-danger absent-btn active" disabled>A</button>
                                        <button class="btn btn-warning permission-btn">PM</button>
                                    </td>
                                    <td class="col-4">
                                        <input type="text" class="form-control reason-input shadow-none border" placeholder="Reason..." disabled>
                                        <p class="text-danger d-none mb-0 small errorAlert"></p>
                                    </td>
                                </tr>
                            `;
                            modalBody.append(row);
                        });
                    } else {
                        modalBody.html(`<tr><td colspan="4" class="text-center text-danger">No students found for this class.</td></tr>`);
                    }
                }
            });
        });

        // Attendance Button Logic
        $(document).on('click', '.present-btn, .absent-btn, .permission-btn', function(){
            const $row = $(this).closest('tr');
            const $reasonInput = $row.find('.reason-input');
            const $presentBtn = $row.find('.present-btn');
            const $absentBtn = $row.find('.absent-btn');
            const $pmBtn = $row.find('.permission-btn');

            $row.find('.present-btn, .absent-btn, .permission-btn').prop('disabled', false).removeClass('active');
            $(this).prop('disabled', true).addClass('active');

            if($(this).hasClass('permission-btn')){
                $reasonInput.prop('disabled', false).focus();
            } else {
                $reasonInput.prop('disabled', true).val('');
            }
        });

        $(document).on('keyup', '.reason-input', function(){
            const $input = $(this);
            if($input.val().trim() !== '') $input.removeClass('border-danger').siblings('.errorAlert').addClass('d-none').text('');
        });

        // Save Attendance
        $("#saveAttendance").click(function(){
            let valid = true;
            let attendanceData = [];

            $("#modal-students-tbody tr").each(function(){
                const $row = $(this);
                const studentId = parseInt($row.data("id"))
                const $reasonInput = $row.find('.reason-input');
                const isPresent = $row.find('.present-btn').hasClass('active');
                const isAbsent = $row.find('.absent-btn').hasClass('active');
                const isPermission = $row.find('.permission-btn').hasClass('active');

                if(isPermission && $reasonInput.val().trim() === ''){
                    $reasonInput.addClass('border-danger').siblings('.errorAlert').removeClass('d-none').text('⚠️ Please provide the reason for permission.');
                    valid = false;
                    return false;
                } else {
                    $reasonInput.removeClass('border-danger').siblings('.errorAlert').addClass('d-none').text('');
                }

                attendanceData.push({
                    stu_id: studentId,
                    present: isPresent ? 1 : 0,
                    absent: isAbsent ? 1 : 0,
                    permission: isPermission ? 1 : 0,
                    reason: $reasonInput.val().trim(),
                });
            });

            if(!valid) return;

            toggleSpinner("#saveAttendance", true);

            $.ajax({
                url: 'api.php?endpoint=record_attendance',
                method: 'POST',
                data: {
                    students: JSON.stringify(attendanceData),
                    att_record_date: new Date().toISOString().split('T')[0],
                    class_id: class_id
                },
                dataType: 'json',
                success: function(response){
                    if(response.status){
                        showAlert(response.message);
                        $("#attModal").modal('hide');
                        loadStudents(class_id)
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                    }
                },
                error: function(){
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save attendance. Please try again.' });
                },
                complete: function(){
                    toggleSpinner("#saveAttendance", false);
                }
            });
        });

        $('#students-tbody').on('click', '.edit-student-btn', function() {
            const stuId = $(this).data('stu_id');
            const name = $(this).data('name');
            const gender = $(this).data('gender');
            const tel = $(this).data('tel');

            $('#update-stu-id').val(stuId);
            $('#update-full-name').val(name);
            $('#update-gender').val(gender);
            $('#update-tel').val(tel);
        });

        $('#updateStudentForm').on('submit', function(e) {
            e.preventDefault(); // prevent default form submission
            const $btn = $('#saveUpdateStudent'); // target the submit button

            // Show spinner in the button
            $btn.prop('disabled', true);
            $btn.html(`
                <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                Loading...
            `);
            // Collect form data
            let formData = {
                stu_id: $('#update-stu-id').val(),
                full_name: $('#update-full-name').val(),
                gender: $('#update-gender').val(),
                tel: $('#update-tel').val()
            };

            // Send AJAX request
            $.ajax({
                url: 'api.php?endpoint=update_student', // replace with your PHP API file
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    if(res.status) {
                        // alert('Student updated successfully!');
                        $('#modalUpdateStudent').modal('hide'); // hide modal
                        // Optionally reload or update your student table here
                        loadStudents(class_id)
                    } else {
                        alert('Error: ' + res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Something went wrong.');
                },
                complete: function() {
                    // Restore button text and enable it
                    $btn.prop('disabled', false);
                    $btn.html('Save Changes');
                }
            });
        })

        // 🧩 Handle Delete Button Click
        $('#students-tbody').on('click', '.delete-student-btn', function() {
            const stuId = $(this).data('stu_id');
            const name = $(this).data('name');

            // Store the student ID in the confirm button for later use
            $('#confirmDeleteStudent').data('stu_id', stuId);

            // Display student name in modal
            $('#delete-student-name').text(name);

            // Show the modal
            $('#modalDeleteStudent').modal('show');
        });

        // 🧩 Confirm Delete Student
        $('#confirmDeleteStudent').on('click', function() {
            const stuId = $(this).data('stu_id');
            const $btn = $(this);
            const $spinner = $btn.find('.spinner-border');

            // Show loading spinner
            $spinner.removeClass('d-none');
            $btn.prop('disabled', true);

            $.ajax({
                url: 'api.php?endpoint=delete_student',
                type: 'POST',
                data: { 
                    stu_id: stuId,
                    class_id:class_id 
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#modalDeleteStudent').modal('hide');
                        loadStudents(class_id); // reload table
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete student.' });
                },
                complete: function() {
                    $spinner.addClass('d-none');
                    $btn.prop('disabled', false);
                }
            });
        });

    // Save All Scores Button
        $('#saveAllScoresBtn').on('click', function() {
            let allScores = [];
            let valid = true;

            $('#students-tbody tr').each(function() {
                const $row = $(this);
                const stuId = $row.data('stu-id');
                const stuname = $row.data('stu-id');

                const $attInput = $row.find('input[placeholder="Attendance Score"]');
                const $actInput = $row.find('input[placeholder="Activity Score"]');
                const $examInput = $row.find('input[placeholder="Exam Score"]');

                const attScore = parseFloat($attInput.val());
                const actScore = parseFloat($actInput.val());
                const examScore = parseFloat($examInput.val());

                // Dispose previous popovers
               
                $actInput.popover('dispose');
                $examInput.popover('dispose');


                // Validate Activity Score (max 30)
                if(actScore > 30){
                    $actInput.popover({
                        content: `Activity score for student cannot be more than 30`,
                        placement: 'bottom',
                        trigger: 'manual'
                    }).popover('show');
                    $actInput.addClass('text-danger border-danger');
                    setTimeout(() => $actInput.popover('hide').removeClass('text-danger border-danger'), 5000);
                    valid = false;
                }

                // Validate Exam Score (max 30)
                if(examScore > 30){
                    $examInput.popover({
                        content: `Exam score for student cannot be more than 30`,
                        placement: 'bottom',
                        trigger: 'manual'
                    }).popover('show');
                    $examInput.addClass('text-danger border-danger');
                    setTimeout(() => $examInput.popover('hide').removeClass('text-danger border-danger'), 5000);
                    valid = false;
                }

                allScores.push({
                    stu_id: stuId,
                    att_score: attScore,
                    act_score: actScore,
                    exam_score: examScore
                });
            });

            if(!valid) return; // Stop if any validation failed

            // Send AJAX
            $.ajax({
                url: 'api.php?endpoint=save_scores',
                type: 'POST',
                data: { scores: allScores },
                dataType: 'json',
                success: function(res) {
                    if(res.status) {
                        $actInput.popover('hide').removeClass('text-danger border-danger')
                        $examInput.popover('hide').removeClass('text-danger border-danger')
                        showAlert(res.message);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Failed', text: res.message });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                    console.log('Raw response:', xhr.responseText);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save scores. Please try again.' });
                }
            });
        });



    });
</script>


