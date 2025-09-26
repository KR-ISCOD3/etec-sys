<div>
    <h3 class="mb-0">Attendence System</h3>
    <p class="text-secondary mb-3">Manage your class like manage your oun heart</p>

    <div class="p-0 border-bottom pb-3">
        <div class="row g-4">

        <!-- Total Class -->
        <div class="col-md-3">
            <div class="card border rounded h-100">
            <div class="card-body d-flex align-items-center justify-content-between px-4">
                <div>
                <h6 class="text-muted mb-1">Total Class</h6>
                <h3 class="fw-medium mb-0">20</h3>
                </div>
                <div class="me-3 text-primary fs-1 border-start ps-3">
                <i class="bi bi-easel2-fill"></i>
                </div>
            </div>
            </div>
        </div>

        <!-- Total Student -->
        <div class="col-md-3">
            <div class="card border rounded h-100">
                <div class="card-body d-flex align-items-center justify-content-between px-4">
                    <div>
                    <h6 class="text-muted mb-1">Total Student</h6>
                    <h3 class="fw-medium mb-0">150</h3>
                    </div>
                    <div class="me-3 text-success fs-1 border-start ps-3">
                    <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Male Student -->
        <div class="col-md-3">
            <div class="card border rounded h-100">
                <div class="card-body d-flex align-items-center justify-content-between px-4">
                    <div>
                    <h6 class="text-muted mb-1">Male Student</h6>
                    <h3 class="fw-medium mb-0">80</h3>
                    </div>
                    <div class="me-3 text-info fs-1 border-start ps-3">
                    <i class="bi bi-gender-male"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Female Student -->
        <div class="col-md-3">
            <div class="card border rounded h-100">
                <div class="card-body d-flex align-items-center justify-content-between px-4">
                    <div>
                    <h6 class="text-muted mb-1">Female Student</h6>
                    <h3 class="fw-medium mb-0">70</h3>
                    </div>
                    <div class="me-3 text-danger fs-1 border-start ps-3">
                    <i class="bi bi-gender-female"></i>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>

    <div class="p-0 mt-3">
        <div class="d-flex justify-content-between align-items-center">
            
            <div class="col-3 pb-3">
                <form action="" class="d-flex border rounded bg-white">
                    <input type="text" placeholder="Search Class..." class="form-control shadow-none border-0 bg-transparent">
                    <button class="btn ">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <button class="btn rounded btn-light border" data-bs-toggle="modal" data-bs-target="#addClassModal">Add Class +</button>                 
        </div>

        <div class="row g-4">

            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card shadow-sm border rounded h-100">

                    <div class="card-body p-3">
                        <!-- Header -->
                        <div class="d-flex align-items-center mb-2 justify-content-between">
                            <div class="me-3 d-flex align-items-center fs-2">
                                <i class="bi bi-house-fill text-etec-color me-2"></i>
                                <h5 class="mb-0 fw-bold">C and C++/OOP/Algorithsm</h5>
                            </div>

                            <!-- Dropdown -->
                            <div class="dropdown">
                                <button class="btn btn-sm border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm py-0 overflow-hidden">
                                    <li class="">
                                        <button class="btn border-0 py-2 rounded-0 w-100 text-start" data-bs-toggle="modal" data-bs-target="#updateClassModal">
                                            Update
                                        </button>                        
                                    </li>
                                    <li class="">
                                        <button class="btn border-0 py-2 rounded-0 w-100 text-start">
                                            Add Student
                                        </button>                        
                                    </li>
                                    <li class="">
                                        <button class="btn btn-secondary border-0 py-2 rounded-0 w-100 text-start">
                                            Pre-End
                                        </button>                        
                                    </li>
                                    <li class="">
                                        <button class="btn btn-danger border-0 py-2 rounded-0 w-100 text-start">
                                            End
                                        </button>                        
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <div class="col-4">
                                <p class="m-0">
                                    <strong>Class Lessons:</strong>
                                </p>
                            </div>
                            <div class="col-8">
                                <span class="px-2 bg-secondary-subtle text-dark rounded">Introduction</span>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <div class="col-4">
                                <p class="m-0">
                                    <strong>Located: </strong>
                                </p>
                            </div>
                            <div class="col-8">
                                <p class="m-0">
                                    ETEC2, FLOOR2 - <span class="text-etec-color fw-medium">(Room 1)</span>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <div class="col-4">
                                <p class="m-0">
                                    <strong>Status:</strong>
                                </p>
                            </div>
                            <div class="col-8">
                                <p class="m-0">
                                    <span class="text-etec-color fw-medium">Physical</span>
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <div class="col-4">
                                <p class="m-0">
                                    <strong>Term: </strong>
                                </p>
                            </div>
                            <div class="col-8">
                                <p class="m-0">
                                    Mon - Thu
                                </p>
                            </div>
                        </div>


                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <div class="col-4">
                                <p class="m-0">
                                    <strong>Time: </strong>
                                </p>
                            </div>
                            <div class="col-8">
                                <p class="m-0 fw-medium text-success">
                                    9:00 am - 10:30 am
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <div class="col-4">
                                <p class="m-0">
                                    <strong>Total Stu: </strong>
                                </p>
                            </div>
                            <div class="col-8">
                                <p class="m-0">
                                    12
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                            <div class="col-4">
                                <p class="m-0">
                                    <strong>Class Status: </strong>
                                </p>
                            </div>
                            <div class="col-8">
                                <span class="badge bg-primary fw-medium">Progress</span>
                            </div>
                        </div>
    
                        <!-- Footer -->
                        <a href="#" class="btn btn-light border w-100 mt-3 text-etec-color">
                            View Class
                        </a>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Add Class Modal -->
    <div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="addClassModalLabel">Add New Class</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex mb-3 border-bottom pb-3">
                        <div class="col-4 pe-2">
                            <label class="form-label text-etec-color">Course</label>
                            <select name="" id="courseSelect" class="form-select shadow-none border" >
                                <option value="" selected disabled>Select Course</option>
                            </select>
                        </div>               
                        <div class="col-4 pe-2">
                            <label class="form-label text-etec-color">Lessons</label>
                            <select name="" id="lessonSelect" class="form-select shadow-none border" >
                                <option value="" selected disabled>Select Lesson</option>
                            </select>
                        </div>
                        <div class="col-4 ">
                            <label class="form-label text-etec-color">Status</label>
                            <select name="" id="statusSelect" class="form-select shadow-none border" >
                                <option value="" selected disabled>Select Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="col-4 pe-2">
                            <label class="form-label text-etec-color">Building</label>
                            <select name="" id="buildingSelect" class="form-select shadow-none border" >
                                <option value="" selected disabled>Select Building</option>
                            </select>
                        </div>
                        <div class="col-4 pe-2">
                            <label class="form-label text-etec-color">Floor</label>
                            <select name="" id="floorSelect" class="form-select shadow-none border" >
                                <option value="" selected disabled>Select Floor</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-etec-color">Room</label>
                            <select name="" id="roomSelect" class="form-select shadow-none border" >
                                <option value="" selected disabled>Select Room</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="col-6 pe-2">
                            <label class="form-label text-etec-color">Term</label>
                            <select name="" id="termSelect" class="form-select shadow-none border" >
                                <option value="" selected disabled>Select Term</option>
                            </select>
                        </div>
                        <div class="col-6 ">
                            <label class="form-label text-etec-color">Time</label>
                            <select name="" id="timeSelect" class="form-select shadow-none border" >
                                <option value="" selected disabled>Select Time</option>
                            </select>
                        </div>
                    </div>
                    <p class="text-secondary">Please fill all the form before submit</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Class</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Update Class Modal -->
    <div class="modal fade" id="updateClassModal" tabindex="-1" aria-labelledby="updateClassModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateClassModalLabel">Update Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex mb-3 border-bottom pb-3">
                            <div class="col-4 pe-2">
                                <label class="form-label text-etec-color">Class Name</label>
                                <select class="form-select shadow-none border">
                                    <option selected>C and C++/OOP/Algorithm</option>
                                </select>
                            </div>
                            <div class="col-4 pe-2">
                                <label class="form-label text-etec-color">Status</label>
                                <select class="form-select shadow-none border">
                                    <option selected>Physical</option>
                                    <option>Online</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-etec-color">Lessons</label>
                                <select class="form-select shadow-none border">
                                    <option selected>Introduction</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="col-4 pe-2">
                                <label class="form-label text-etec-color">Building</label>
                                <select class="form-select shadow-none border">
                                    <option selected>ETEC2</option>
                                </select>
                            </div>
                            <div class="col-4 pe-2">
                                <label class="form-label text-etec-color">Floor</label>
                                <select class="form-select shadow-none border">
                                    <option selected>Floor 2</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-etec-color">Room</label>
                                <select class="form-select shadow-none border">
                                    <option selected>Room 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="col-6 pe-2">
                                <label class="form-label text-etec-color">Term</label>
                                <select class="form-select shadow-none border">
                                    <option selected>Mon - Thu</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-etec-color">Time</label>
                                <select class="form-select shadow-none border">
                                    <option selected>9:00 am - 10:30 am</option>
                                </select>
                            </div>
                        </div>
                        <p class="text-secondary">Update the details as needed before saving.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        let courses = [];
        let roadmaps = [];
        let buildings = [];
        let schedules = [];

        // --- Fetch Courses ---
        function getCourses(){
            let $select = $("#courseSelect");
            $select.prop('disabled', true).html('<option disabled selected>Loading courses...</option>');

            $.ajax({
                url: 'api.php?endpoint=course_getall',
                method: 'GET',
                dataType: 'json',
                success: function(res){
                    if(res.data){
                        courses = res.data;

                        $select.empty().append('<option value="" disabled selected>Select Course</option>');
                        $.each(courses, function(index, c){
                            $select.append(`<option value="${c.id}">${c.course}</option>`);
                        });

                        $select.prop('disabled', false); // enable after loading
                    } else {
                        $select.html('<option disabled selected>No courses found</option>');
                    }
                },
                error: function () {
                    $select.html('<option disabled selected>Failed to load courses</option>');
                }
            });
        }

        // --- Fetch Roadmaps (lessons) ---
        function getRoadmaps() {
            $.ajax({
                url: 'api.php?endpoint=roadmap_getall',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    if(res.data && res.data.length > 0){
                        roadmaps = res.data; // store for filtering
                    }
                },
                error: function(){
                    console.error('Failed to load roadmaps');
                }
            });
        }

        // --- Filter Lessons by Course ---
        function filterLessonsByCourse(courseId) {
            let $select = $("#lessonSelect");

            // Reset first
            $select.prop('disabled', true);
            $select.empty().append('<option value="" disabled selected>Select Lesson</option>');

            if(!courseId) return;

            const filteredRoadmaps = roadmaps.filter(r => r.course_id == courseId);
            let hasLessons = false;

            if(filteredRoadmaps.length > 0){
                $.each(filteredRoadmaps, function(index, roadmap){
                    let lessons = roadmap.lessons;

                    if(typeof lessons === 'string'){
                        try { lessons = JSON.parse(lessons); } 
                        catch(e) { lessons = []; }
                    }

                    if(Array.isArray(lessons) && lessons.length > 0){
                        hasLessons = true;
                        $.each(lessons, function(i, lesson){
                            $select.append(`<option value="${lesson}">${lesson}</option>`);
                        });
                    }
                });
            }

            // Disable if no lessons
            if(!hasLessons){
                $select.prop('disabled', true);
                $select.html('<option disabled selected>No lessons for this course</option>');
            } else {
                $select.prop('disabled', false);
            }
        }

        // --- Event: Course select change ---
        $("#courseSelect").on("change", function(){
            const selectedCourseId = $(this).val();
            filterLessonsByCourse(selectedCourseId);
        });


        // --- Fetch Buildings ---
        function getBuildings(){
            let $buildingSelect = $("#buildingSelect");
            let $floorSelect = $("#floorSelect");
            let $roomSelect = $("#roomSelect");

            // Disable all selects initially
            $buildingSelect.prop('disabled', true).html('<option disabled selected>Loading buildings...</option>');
            $floorSelect.prop('disabled', true).html('<option disabled selected>Select Floor</option>');
            $roomSelect.prop('disabled', true).html('<option disabled selected>Select Room</option>');

            $.ajax({
                url: 'api.php?endpoint=building_fetch_all',
                method: 'GET',
                dataType: 'json',
                success: function(res){
                    if(res.data && res.data.length > 0){
                        buildings = res.data;

                        $buildingSelect.empty().append('<option value="" disabled selected>Select Building</option>');

                        $.each(buildings, function(index, building){
                            $buildingSelect.append(`<option value="${building.building_id}">${building.building_name}</option>`);
                        });

                        $buildingSelect.prop('disabled', false);
                    } else {
                        $buildingSelect.html('<option disabled selected>No buildings found</option>');
                    }
                },
                error: function(){
                    $buildingSelect.html('<option disabled selected>Failed to load buildings</option>');
                }
            });
        }

        // --- When Building Changes ---
        $("#buildingSelect").on("change", function(){
            const buildingId = $(this).val();
            const $floorSelect = $("#floorSelect");
            const $roomSelect = $("#roomSelect");

            $floorSelect.prop('disabled', true).empty().append('<option disabled selected>Select Floor</option>');
            $roomSelect.prop('disabled', true).empty().append('<option disabled selected>Select Room</option>');

            if(!buildingId) return;

            const building = buildings.find(b => b.building_id == buildingId);
            if(building && building.floors.length > 0){
                $.each(building.floors, function(index, floor){
                    $floorSelect.append(`<option value="${floor.floor_id}">${floor.floor_name}</option>`);
                });
                $floorSelect.prop('disabled', false);
            } else {
                $floorSelect.html('<option disabled selected>No floors found</option>');
            }
        });

        // --- When Floor Changes ---
        $("#floorSelect").on("change", function(){
            const floorId = $(this).val();
            const buildingId = $("#buildingSelect").val();
            const $roomSelect = $("#roomSelect");

            $roomSelect.prop('disabled', true).empty().append('<option disabled selected>Select Room</option>');

            if(!floorId || !buildingId) return;

            const building = buildings.find(b => b.building_id == buildingId);
            const floor = building.floors.find(f => f.floor_id == floorId);

            if(floor && floor.rooms.length > 0){
                $.each(floor.rooms, function(index, room){
                    $roomSelect.append(`<option value="${room.room_id}">${room.room_name}</option>`);
                });
                $roomSelect.prop('disabled', false);
            } else {
                $roomSelect.html('<option disabled selected>No rooms found</option>');
            }
        });

        // --- Fetch schedules ---
        function getSchedules(){
            let $statusSelect = $("#statusSelect");
            let $termSelect = $("#termSelect");
            let $timeSelect = $("#timeSelect");

            // disable all at start
            $statusSelect.prop('disabled', true).html('<option disabled selected>Loading status...</option>');
            $termSelect.prop('disabled', true).html('<option disabled selected>Select Term</option>');
            $timeSelect.prop('disabled', true).html('<option disabled selected>Select Time</option>');

            $.ajax({
                url: 'api.php?endpoint=schedule_getall',
                method: 'GET',
                dataType: 'json',
                success: function(res){
                    if(res.data && res.data.length > 0){
                        schedules = res.data;
                        // console.table(schedules)

                        // Populate status first
                        let uniqueStatuses = [...new Map(schedules.map(s => [s.class_type_id, s])).values()];

                        $statusSelect.empty().append('<option value="" disabled selected>Select Status</option>');

                        $.each(uniqueStatuses, function(i, s){
                            $statusSelect.append(`<option value="${s.class_type_id}">${s.class_type_name}</option>`);
                        });

                        $statusSelect.prop('disabled', false);
                    } else {
                        $statusSelect.html('<option disabled selected>No schedules found</option>');
                    }
                },
                error: function(){
                    $statusSelect.html('<option disabled selected>Failed to load schedules</option>');
                }
            });
        }

        // --- When Status changes ---
        $("#statusSelect").on("change", function(){
            const statusId = $(this).val();
            let $termSelect = $("#termSelect");
            let $timeSelect = $("#timeSelect");

            $termSelect.prop('disabled', true).empty().append('<option disabled selected>Select Term</option>');
            $timeSelect.prop('disabled', true).empty().append('<option disabled selected>Select Time</option>');

            if(!statusId) return;

            // Filter schedules by selected status
            const filtered = schedules.filter(s => s.class_type_id == statusId);

            if(filtered.length > 0){
                let uniqueTerms = [...new Map(filtered.map(f => [f.term_id, f])).values()];

                $.each(uniqueTerms, function(i, t){
                    $termSelect.append(`<option value="${t.term_id}">${t.term_name}</option>`);
                });

                $termSelect.prop('disabled', false);
            } else {
                $termSelect.html('<option disabled selected>No terms found</option>');
            }
        });

        // --- When Term changes ---
        $("#termSelect").on("change", function(){
            const termId = $(this).val();
            const statusId = $("#statusSelect").val();
            let $timeSelect = $("#timeSelect");

            $timeSelect.prop('disabled', true).empty().append('<option disabled selected>Select Time</option>');

            if(!termId || !statusId) return;

            // Filter schedules by both status + term
            const filtered = schedules.filter(s => s.class_type_id == statusId && s.term_id == termId);

            if(filtered.length > 0){
                // Collect all time slots (split by comma)
                let times = [];
                filtered.forEach(f => {
                    if(f.time_slots){
                        times = times.concat(f.time_slots.split(", ").map(t => t.trim()));
                    }
                });

                // Unique times
                let uniqueTimes = [...new Set(times)];

                $.each(uniqueTimes, function(i, time){
                    $timeSelect.append(`<option value="${time}">${time}</option>`);
                });

                $timeSelect.prop('disabled', false);
            } else {
                $timeSelect.html('<option disabled selected>No times found</option>');
            }
        });

        // --- Initial load ---
        $("#termSelect, #timeSelect").prop('disabled', true);
        getSchedules();

        // --- Initial Load ---
        $("#floorSelect, #roomSelect").prop('disabled', true)
            .html('<option disabled selected>Select</option>');

        getBuildings();
        // --- Initial Load ---
        $("#lessonSelect").prop('disabled', true).html('<option disabled selected>Select Lesson</option>');
        getCourses();
        getRoadmaps(); // fetch roadmaps for filtering


        // --- Handle Add Class Form Submit ---
       $("#addClassModal form").on("submit", function(e) {
            e.preventDefault();

            // Collect form values
            const lesson = $("#lessonSelect").val();
            const class_status = "progress";
            const course_id = parseInt($("#courseSelect").val());
            const instructor_id = 0; // optional, if you don't have instructor yet
            const building_id = parseInt($("#buildingSelect").val());
            const floor_id = parseInt($("#floorSelect").val());
            const room_id = parseInt($("#roomSelect").val());
            const class_type_id = parseInt($("#statusSelect").val()); // assuming statusSelect stores class_type_id
            const time_id = parseInt($("#timeSelect").val());
            const term_id = parseInt($("#termSelect").val());

            // Validation
            if (!lesson || !class_status || !course_id || !building_id || !floor_id || !room_id || !class_type_id || !time_id || !term_id) {
                alert("Please fill all required fields!");
                return;
            }

            // Send AJAX request
            $.ajax({
                url: 'api.php?endpoint=class_create',
                method: 'POST',
                dataType: 'json',
                data: {
                    lesson,
                    class_status,
                    course_id,
                    instructor_id,
                    building_id,
                    floor_id,
                    room_id,
                    class_type_id,
                    time_id,
                    term_id
                },
                success: function(res) {
                    if(res.status){
                        alert("Class created successfully!");
                        $("#addClassModal").modal('hide');
                        $("#addClassModal form")[0].reset();
                    } else {
                        alert("Failed to create class: " + res.message);
                    }
                },
                error: function(err) {
                    console.error(err);
                    alert("An error occurred while creating the class.");
                }
            });

        });


    });
</script>


