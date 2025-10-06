<div class="p-0 border-bottom pb-3">
  <div class="row g-4">

    <!-- Total Class -->
    <div class="col-md-3">
      <div class="card border rounded h-100">
        <div class="card-body d-flex align-items-center justify-content-between px-4">
          <div>
            <h6 class="text-muted mb-1">Total Class</h6>
            <h3 id="totalClass" class="fw-medium mb-0">0</h3>
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
            <h3 id="totalStudent" class="fw-medium mb-0">0</h3>
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
            <h3 id="totalMale" class="fw-medium mb-0">0</h3>
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
            <h3 id="totalFemale" class="fw-medium mb-0">0</h3>
          </div>
          <div class="me-3 text-danger fs-1 border-start ps-3">
            <i class="bi bi-gender-female"></i>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<script>
$(document).ready(function () {
  const instructorId = 5; // Example: replace with logged-in instructor ID

  $.ajax({
    url: "api.php?endpoint=get_totals_by_instructor",
    type: "POST",
    data: { instructor_id: instructorId },
    dataType: "json",
    success: function (response) {
      if (response.status) {
        $("#totalClass").text(response.data.total_class);
        $("#totalStudent").text(response.data.total_student);
        $("#totalMale").text(response.data.total_male);
        $("#totalFemale").text(response.data.total_female);
      } else {
        console.error("Error:", response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", error);
    }
  });
});
</script>
