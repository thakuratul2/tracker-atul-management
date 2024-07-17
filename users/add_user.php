<?php

include_once '../connection/common/db_helper.php';

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
                    <h4 class="card-title">Users > Add Users</h4>
                    <form class="forms-sample" id="userForm">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Username</label>
                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputAddress">Address</label>
                            <input type="text" class="form-control" id="exampleInputAddress" placeholder="Address" name="address" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputSalary">Monthly Salary</label>
                            <input type="number" class="form-control" id="exampleInputSalary" placeholder="Monthly Salary" name="salary" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputStatus">Status</label>
                            <select class="form-control" id="exampleInputStatus" name="status" required>
                                <option value="0">Enable</option>
                                <option value="1">Disable</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary me-2">Add User</button>
                        <button type="reset" class="btn btn-light">Cancel</button>
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
            url: '../method/user_method.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response == 'Success') {
                    console.log(response);

                    $('#responseMessage').text('User Added Successfully').css('color', 'green');
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