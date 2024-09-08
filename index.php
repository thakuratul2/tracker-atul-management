<?php 
include_once ("connection/common/db_helper.php");

user_login();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include_once ('partials/title.php'); ?>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- endinject -->
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <!-- <div class="brand-logo">
                  <img src="assets/images/logo.svg" alt="logo">
                </div> -->
                <h4>Hello! let's get started</h4>
                <h6 class="fw-light">Sign in to continue.</h6>
                <form id="loginForm" class="pt-3">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="email" placeholder="Enter Email" name="email">
                  </div>

                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="password" placeholder="Password" name="password">
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn" type="submit">SIGN IN</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>
                    </div>
                    <a href="forgot_password/forgot_password.php" class="auth-link text-black">Forgot password?</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <div id="toastMessage" class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="d-flex">
                    <div class="toast-body">
                      <!-- Message will be inserted here -->
                    </div>
                  </div>
                </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/todolist.js"></script>
    
    <script>
       $(document).ready(function() {
          $('#loginForm').submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var email = $('#email').val();
            var password = $('#password').val();

            $.ajax({
              url: './method/login_method.php',
              type: 'POST',
              data: {
                email: email,
                password: password
              },
              success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                  showToast('Login successful!', 'success');
                  setTimeout(function() {
                    window.location.href = 'dashboard.php'; // Redirect to dashboard or desired page
                  }, 1500);
                } else {
                  showToast(result.message || 'Login failed. Please try again.', 'error');
                }
              },
              error: function(xhr, status, error) {
                showToast('Something went wrong. Please try again later.', 'error');
              }
            });
          });
        });
        </script>
    <script>
        function showToast(message, type = 'success') {
          var toastElement = document.getElementById('toastMessage');

          // Set the toast message
          toastElement.querySelector('.toast-body').innerHTML = message;

          // Set the background color based on the type (success or error)
          if (type === 'success') {
            toastElement.classList.remove('text-bg-danger');
            toastElement.classList.add('text-bg-success');
          } else if (type === 'error') {
            toastElement.classList.remove('text-bg-success');
            toastElement.classList.add('text-bg-danger');
          }

          // Initialize and show the toast
          var toast = new bootstrap.Toast(toastElement);
          toast.show();

         
          setTimeout(function () {
            toast.hide();
          }, 5000);
        }

        // Check if there's a session message to display
        <?php if (isset($_SESSION['message'])): ?>
          showToast('<?php echo $_SESSION['message']; ?>', '<?php echo $_SESSION['message_type']; ?>');
          <?php
          // Clear the message after displaying
          unset($_SESSION['message']);
          unset($_SESSION['message_type']);
          ?>
        <?php endif; ?>
      </script>
    <!-- endinject -->
  </body>
</html>