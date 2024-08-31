<?php

include_once '../connection/common/db_helper.php';
include_once '../connection/db.php';

user_not_login();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <?php include '../partials/title.php'; ?>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">

  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="../assets/vendors/select2/select2.min.css">
  <link rel="stylesheet" href="../assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <!-- endinject -->
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../partials/_navbar.html -->
    <?php include '../partials/aside.php'; ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <div class="row">
          <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Task > Add Task</h4>
                <form class="forms-sample" id="userForm">
                  <div class="form-group">
                    <label for="exampleInputUsername1">Task Title</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Task Title"
                      name="title" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputDate1">Task Date</label>
                    <input type="date" class="form-control datepicker" id="exampleInputDate1" placeholder="Date"
                      name="task_start" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputTime1">Task Time</label>
                    <input type="text" class="form-control" id="exampleInputTime1" placeholder="Time (HH:MM)"
                      name="start_time" required pattern="^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$"
                      title="Please enter time in HH:MM format">
                  </div>

                  <div class="form-group">
                    <label for="projectType">Project</label>
                    <select class="form-control" id="projectType" name="project_type" required>
                      <option value="">Select Project Type</option>
                      <?php
                      $projectTypesResult = fetch_project_type($conn);
                      if (is_array($projectTypesResult)) {
                        foreach ($projectTypesResult as $row) {
                          echo '<option value="' . htmlspecialchars($row['project_type']) . '">' . htmlspecialchars($row['project_type']) . '</option>';
                        }
                      } else {
                        echo '<option value="">No projects available</option>';
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="taskType">Task Type</label>
                    <select class="form-control" id="taskType" name="task_type" required>
                      <option value="">Select Task Type</option>
                      <option value="Feature">Feature</option>
                      <option value="Bug Fix">Bug Fix</option>
                      <option value="Documentation">Documentation</option>
                      <option value="Meeting">Meeting</option>
                      <option value="Development">Development</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-success me-2">Add Task</button>
                  <button type="reset" class="btn btn-danger">Cancel</button>
                </form>
                <div id="responseMessage" style="margin-top: 10px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
      <!-- partial:../partials/_footer.html -->
      <?php include_once '../partials/footer.php'; ?>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
  <script src="../assets/vendors/select2/select2.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../assets/js/off-canvas.js"></script>
  <script src="../assets/js/template.js"></script>
  <script src="../assets/js/settings.js"></script>
  <script src="../assets/js/hoverable-collapse.js"></script>
  <script src="../assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../assets/js/file-upload.js"></script>
  <script src="../assets/js/typeahead.js"></script>
  <script src="../assets/js/select2.js"></script>
  <!-- End custom js for this page-->
  <script>
    $(document).ready(function () {
      $('#userForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
          url: '../method/task_method.php',
          type: 'POST',
          data: formData,
          success: function (response) {
            if (response == 'Success') {
              $('#responseMessage').text('Task Added Successfully').css('color', 'green');
            } else {
              $('#responseMessage').text('An error occurred: ' + response).css('color', 'red');
            }
          },
          error: function (xhr, status, error) {
            $('#responseMessage').text('An error occurred: ' + xhr.responseText).css('color', 'red');
          }
        });
      });
    });
  </script>
</body>

</html>