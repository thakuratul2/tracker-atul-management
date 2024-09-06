<?php 
include_once ("../connection/common/db_helper.php");
include_once ('../connection/db.php');


if (!isset($_SESSION['reset_email']) || !isset($_SESSION['reset_token'])) {
    // Redirect if session is not set (indicating improper access)
    header('Location: ../index.php');
    exit();
}

$email = $_SESSION['reset_email'];
$token = $_SESSION['reset_token'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include_once ('../partials/title.php'); ?>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    

  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <h4 class="text-center">Hello! Let's Change Password</h4>

                <form class="pt-3" action="forgot_method.php" method="post">
                <input type="hidden" name="token" value="<?php echo $token; ?>">

                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" value="<?php echo $email; ?>" name="email" readonly>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Enter Password" name="password" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Confirm Password" name="confirm_password" required>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn" type="submit" name="submit_update_password">UPDATE NOW</button>
                  </div>
                  
                </form>

                <!-- Toast Notification -->
                
                <!-- End of Toast -->
              </div>
            </div>
      </div>
      </div>
      <!-- page-body-wrapper ends -->
          </div>
      <!-- page-body-wrapper ends -->
        </div>
      </div>
    </div>

    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

    <!-- Toast JavaScript Function -->
  
  </body>
</html>
