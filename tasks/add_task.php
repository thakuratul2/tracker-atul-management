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
   <?php include '../partials/title.php';
   ?>
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
                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Task Title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Start Task</label>
                            <input type="date" class="form-control datepicker" id="exampleInputDate1" placeholder="Date" name="task_start" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputTime1">Start Time</label>
                            <input type="time" class="form-control" id="exampleInputTime1" placeholder="Time" name="start_time" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">End Task</label>
                            <input type="date" class="form-control datepicker" id="exampleInputDate1" placeholder="Date" name="task_end" required>
                        </div>
                       
                        <div class="form-group">
                            <label for="exampleInputTime2">End Time</label>
                            <input type="time" class="form-control" id="exampleInputTime2" placeholder="Time" name="end_time" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputDescription">Description</label>
                            <textarea class="form-control" id="exampleInputDescription" placeholder="Description" name="description" required></textarea>
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
      <!-- page-body-wrapper ends -->
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
    $(document).ready(function() {
    $('#userForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: '../method/task_method.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response == 'Success') {
                    console.log(response);

                    $('#responseMessage').text('Task Added Successfully').css('color', 'green');
                } else {
                    $('#responseMessage').text('An error occurred: ' + response).css('color', 'red');
                }
            },
            error: function(xhr, status, error) {
                $('#responseMessage').text('An error occurred: ' + xhr.responseText).css('color', 'red');
            }
        });
    });
});

                    </script>
  </body>
</html>