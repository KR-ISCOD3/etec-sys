<!-- Instructor section -->
<section>
    <div class="">
        <h3 class="mb-0">Instructor Management</h3>
        <p class="text-secondary mb-0">Manage instructors for your school</p>
    </div>
    <div class="d-flex justify-content-between mt-2 align-items-center border-bottom pb-3">       
        <div class="d-flex col-10">
            <div class="col-3">
                <form class="d-flex border rounded bg-white">
                    <input type="text" placeholder="Search Instructor..." class="form-control shadow-none border-0 bg-transparent"/>
                    <button class="btn">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
          
        </div>
    </div>

    <!-- Success Alert -->
    <div id="successAlert" class="alert alert-success alert-dismissible fade show mt-3" style="display:none;" role="alert">
        <span id="successMessage"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class=" p-0 mt-4">
        <div id="instructorList" class="row g-4">
        <!-- Instructor Card -->
       
        <!-- /Instructor Card -->
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form id="formDeleteAcc">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="" id="deleteAccId">
                        Are you sure you want to delete this item?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger" id="confirmDeleteBtn">Yes, Delete</button>
                    </div>
              </form>
            </div>
        </div>
    </div>
</section>
<!-- Instructor section -->

<script>
$(document).ready(function () {

    let users = [];

    // Show alert
    function showAlert(message) {
        $('#successMessage').text(message);
        $('#successAlert').stop(true, true).fadeIn();
        setTimeout(function() {
            $('#successAlert').fadeOut('slow');
        }, 3000);
    }

    function renderInstructors(list) {
        let html = "";
        list.forEach(inst => {
            html += `
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center position-relative">
                                <img src="${inst.image || './assets/defaultuser.png'}" alt="Instructor"
                                    class="rounded-circle border shadow-sm object-fit-cover"
                                    width="120" height="120">
                                <div class="ms-3">
                                    <h5 class="mb-1 fw-semibold">${inst.name}</h5>
                                    <p class="text-primary small mb-1">${inst.email}</p>
                                    <p class="text-muted small mb-2">pw: ${inst.pass || '********'}</p>
                                    <span class="badge bg-primary-subtle text-primary px-3 py-1">Instructor</span>
                                    <span class="badge bg-secondary">ID: ${inst.id}</span>
                                </div>

                                <!-- Dropdown button -->
                                <div class="position-absolute end-0 top-0">
                                    <div class="dropdown">
                                        <button class="btn border-0 shadow-none p-0" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="btn dropdown-item" href="#">View</a></li>
                                            <li>
                                                <a data-bs-target="#deleteConfirmModal" data-bs-toggle="modal" 
                                                class="btn dropdown-item text-danger delete-btn" 
                                                data-id="${inst.id}" href="#">
                                                    Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="border-top py-1 mb-0 text-center text-etec-color">
                            <p class="small mb-0">etec center</p>
                        </div>
                    </div>
                </div>`;
        });

        $("#instructorList").html(html || "<p class='text-muted'>No instructors found</p>");
    }

    // Fetch and render instructors
    function loadInstructors() {
        $.ajax({
            url: "api.php?endpoint=instructor_getall",
            method: "GET",
            dataType: "json",
            success: function (res) {
                if (!res.status) {
                    $("#instructorList").html("<p class='text-danger'>Failed to load instructors</p>");
                    return;
                }
                users = res.data;
                renderInstructors(users);

                $("#instructorList").html(html || "<p class='text-muted'>No instructors found</p>");
            }
        });
    }

    // Search filter
    $(document).on("keyup", "input[placeholder='Search Instructor...']", function () {
        let keyword = $(this).val().toLowerCase();
        let filtered = users.filter(inst => 
            inst.name.toLowerCase().includes(keyword) ||
            inst.email.toLowerCase().includes(keyword) ||
            String(inst.id).includes(keyword)
        );
        renderInstructors(filtered);
    });

    loadInstructors();

    // Delete Instructor
    $(document).on("click", ".delete-btn", function(e){
        let id = $(this).data("id");
        $('#deleteAccId').val(id);
    });

    $('#formDeleteAcc').on('submit',function(e){
        e.preventDefault();
        let id = $('#deleteAccId').val();
        $.ajax({
            url: "api.php?endpoint=instructor_delete",
            method: "POST",
            data: {id},
            dataType: "json",
            success: function(res){
                if (res.status) {
                    showAlert(res.message)
                    loadInstructors();
                    $('#deleteConfirmModal').modal('hide')
                } else {
                    alert(res.message);
                }
            }
        });
    })
});
</script>
