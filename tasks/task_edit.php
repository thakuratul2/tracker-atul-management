<?php
include_once '../connection/common/db_helper.php';
include_once ('../connection/db.php');

user_not_login();
?>
<!DOCTYPE html>
<html lang="en">
  
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include '../partials/title.php'; ?>
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
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
                  <h4 class="card-title">Task > Edit Task</h4>
                  <form class="forms-sample" id="userForm">
                    <?php
                    if(isset($_GET['t_id'])) {
                        $t_id = $_GET['t_id'];
                        $query = "SELECT * FROM tasks WHERE t_id = $t_id";
                        $result = mysqli_query($conn, $query);
                        $row = mysqli_fetch_assoc($result);
                       
                        $name = $row['title'];
                        $start_time = $row['start_time'];
                        $task_used_time = $row['task_used_time'];
                        $project_type = $row['project_type'];
                        $task_type = $row['task_type'];
                        $status = 0;
                    }
                    ?>
                    <div class="form-group">
                      <label for="exampleInputUsername1">Name</label>
                      <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Name" value="<?php echo $name; ?>" name="title" required>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputTask">Task Time</label>
                      <input type="text" class="form-control" id="TaskTime" placeholder="Task Time" name="start_time" value="<?php echo $start_time ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputConsumed">Consumed Time</label>
                      <input type="text" class="form-control" id="exampleInputConsumed" placeholder="Consumed Time" name="task_used_time" value="<?php echo $task_used_time ?>" readonly>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputProject">Project</label>
                      <input type="text" class="form-control" id="exampleInputProject" placeholder="Project Name" name="project_type" value="<?php echo $project_type ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputConsumed">Task Type</label>
                      <input type="text" class="form-control" id="exampleInputConsumed" placeholder="Task Type" name="task_type" value="<?php echo $task_type ?>" readonly>
                    </div>

                    <div class="form-group">
                      <label for="exampleInputStatus">Status</label>
                      <select class="form-control" id="exampleInputStatus" name="status" required onchange="toggleUserRoleDropdown(this.value)">
                        <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>Pending</option>
                        <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>Client Approval</option>
                        <option value="2" <?php echo ($status == 2) ? 'selected' : ''; ?>>Internal Approval</option>
                        <option value="3" <?php echo ($status == 3) ? 'selected' : ''; ?>>Completed</option>
                        <option value="4" <?php echo ($status == 4) ? 'selected' : ''; ?>>Incomplete</option>
                        <option value="5" <?php echo ($status == 5 || !isset($status)) ? 'selected' : ''; ?>>In Progress</option>
                      </select>
                    </div>

                    <div class="form-group" id="userRoleDropdown" style="display: none;">
                      <label for="exampleInputStatus">Approval User</label>
                      <select class="form-control" id="exampleInputRole" name="approval_person">
                        <?php
                          $userRoles = fetch_users($conn);
                         
                          foreach ($userRoles as $row) {
                           
                            echo '<option value="' . htmlspecialchars($row['name']) . '">' . htmlspecialchars($row['name']) . '</option>';
                          }
                        ?>
                      </select>
                    </div>

                    <button type="submit" class="btn btn-primary me-2">Update Task</button>
                    <button type="reset" class="btn btn-light">Reset</button>
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
    function toggleUserRoleDropdown(status) {
        var userRoleDropdown = document.getElementById('userRoleDropdown');
        if (status == 2) {  // "Internal Approval" has value 2
            userRoleDropdown.style.display = 'block';
        } else {
            userRoleDropdown.style.display = 'none';
        }
    }

    // Ensure the dropdown is visible if "Internal Approval" was previously selected
    document.addEventListener("DOMContentLoaded", function() {
        toggleUserRoleDropdown(document.getElementById('exampleInputStatus').value);
    });

    $(document).ready(function() {
        $('#userForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '../method/task_update.php?t_id=<?php echo $t_id; ?>',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response == 'Success') {
                        $('#responseMessage').text('Task Updated Successfully').css('color', 'green');
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
