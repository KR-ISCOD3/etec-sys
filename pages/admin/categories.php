<!-- Category section -->
<section>
    <h3 class="mb-0">Manage Course Category </h3>
    <p class="text-secondary mb-3">You can create category of your course</p>

    <div class="container p-0 border-bottom pb-3">
        <div class="d-flex justify-content-between align-items-center">                 
            <!-- form search -->
            <div class="col-3 pb-3">
                <form action="" class="d-flex border rounded bg-white">
                    <input type="text" placeholder="Search Category..." class="form-control shadow-none border-0 bg-transparent">
                    <button class="btn ">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- btn add category -->
            <button class="btn btn-light border" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                Add Category +
            </button>         
        </div>
                    
    </div>

    <div class="container p-0 mt-3">
        <div class="table-responsive rounded">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <td scope="col" class="text-secondary">#</td>
                        <td scope="col" class="text-secondary">Name</td>
                        <td scope="col" class="text-secondary">Created By</td>
                        <td scope="col" class="text-secondary">Created At</td>
                        <td scope="col" class="text-center text-secondary">Action</td>
                    </tr>
                </thead>
                <tbody id="categoryTableBody">
                    <tr>
                        <td>1</td>
                        <td>Category One</td>
                        <td><span class="text-primary bg-primary-subtle px-2 rounded">Admin</span></td>
                        <td><span class="text-secondary bg-secondary-subtle px-2 rounded">2025-09-12</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#updateCategoryModal">
                                <i class="bi bi-pencil"></i>
                            </button> 
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form id="addCategory">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input required id="categoryName" type="text" class="form-control shadow-none border" placeholder="Enter category name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Category Modal -->
    <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Category</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form id="updateCategory">
                    <div class="modal-body">
                        <input type="hidden" id="updateCategoryId">
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input required type="text" class="form-control shadow-none border" id="updateCategoryName" placeholder="Enter category name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Category Modal -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Delete Category</h6>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <p class="mb-0">Are you sure you want to delete this category?</p>
                        <input type="hidden" id="deleteCategoryId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</section>
<!-- Category section -->
<script>
    $(document).ready(function(){

        function loadCategories() {
            $.ajax({
                url: 'api.php?endpoint=category_get_all',
                method: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        let tbody = '';
                        res.data.forEach(function(category) {
                            tbody += `
                                <tr>
                                    <td>${category.id}</td>
                                    <td>${category.category}</td>
                                    <td><span class="text-primary bg-primary-subtle px-2 rounded">${category.created_by}</span></td>
                                    <td><span class="text-secondary bg-secondary-subtle px-2 rounded">${category.created_at}</span></td>
                                    <td class="text-center">
                                        <button 
                                            class="btn btn-sm btn-primary me-1 editCategoryBtn"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#updateCategoryModal"
                                            data-id="${category.id}"
                                            data-name="${category.category}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button 
                                            class="btn btn-sm btn-danger deleteCategoryBtn"
                                            data-id="${category.id}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteCategoryModal">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#categoryTableBody').html(tbody);
                    } else {
                        alert('Failed to load categories: ' + res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Something went wrong while loading categories.');
                }
            });
        }

        loadCategories();


        $('#addCategory').on('submit',function(e){
            e.preventDefault();

            let category = $('#categoryName').val().trim();

            $.ajax({
                url: 'api.php?endpoint=category_create', // use your endpoint
                method: 'POST',
                data: { 
                    category: category 
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        alert('Category added successfully');
                        $('#addCategoryModal').modal('hide');
                        $('#categoryName').val('');
                        // Optional: refresh your category list here
                    } else {
                        alert('Error: ' + res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Something went wrong!');
                }
            });

        })

        $(document).on('click','.editCategoryBtn',function(){
            $('#updateCategoryName').val($(this).data('name'))
            $('#updateCategoryId').val($(this).data('id'))
        })

        $('#updateCategory').on('submit',function(e){
            
        })

    })
</script>