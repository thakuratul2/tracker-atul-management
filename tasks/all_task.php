<?php
include_once '../connection/common/db_helper.php';
include_once '../connection/db.php';
user_not_login();
$row = manage_task_record($conn);

// Determine if 'Performance' column should be displayed
$showPerformanceColumn = false;
if (mysqli_num_rows($row) > 0) {
    mysqli_data_seek($row, 0); // Reset result pointer to the start
    while ($task = mysqli_fetch_assoc($row)) {
        if (!empty($task['performance'])) {
            $showPerformanceColumn = true;
            break;
        }
    }
}
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
    <style>
        .hidden {
            display: none;
        }
        .performance {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- partial:../partials/_navbar.html -->
        <?php include '../partials/aside.php'; ?>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Tasks > Manage Tasks</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Title</th>
                                                <th>Task Date</th>
                                                <th>Task Time</th>
                                                <th>Consumed Time</th>
                                                <?php if ($showPerformanceColumn): ?>
                                                    <th>Performance</th>
                                                <?php endif; ?>
                                                <th>Project Name</th>
                                                <th>Task Type</th>
                                                <th>Task Timer</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            mysqli_data_seek($row, 0); // Reset result pointer to the start again
                                            if (mysqli_num_rows($row) > 0) {
                                                $i = 1;
                                                while ($task = mysqli_fetch_assoc($row)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $task['title']; ?></td>
                                                    <td><?php echo $task['task_start']; ?></td>
                                                    <td><?php echo $task['start_time']; ?></td>
                                                    <td><?php echo $task['task_used_time'] ?? "00:00"; ?></td>
                                                    <?php if ($showPerformanceColumn): ?>
                                                        <td class="performance" style="color:red;"><?php echo htmlspecialchars($task['performance']); ?></td>
                                                    <?php endif; ?>
                                                    <td><?php echo $task['project_type']; ?></td>
                                                    <td><?php echo $task['task_type']; ?></td>
                                                    <td>
                                                        <i class="fa-regular fa-clock clock-icon-timer" data-task-id="<?php echo $task['t_id']; ?>" style="margin-left:15px; cursor: pointer;"></i>
                                                        <span class="stopwatch-timer" id="timer-<?php echo $task['t_id']; ?>" style="margin-left:10px;"></span>
                                                    </td>
                                                    <td>
                                                        <a href="delete_task.php?t_id=<?php echo $task['t_id']; ?>" class="badge badge-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            <?php 
                                                }
                                            } else {
                                            ?>
                                                <tr>
                                                    <td colspan="<?php echo $showPerformanceColumn ? 10 : 9; ?>" style="text-align: center;">No tasks created yet.</td>
                                                </tr>
                                            <?php 
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once '../partials/footer.php'; ?>
        </div>
    </div>

    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="../assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../assets/vendors/select2/select2.min.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/template.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <script src="../assets/js/file-upload.js"></script>
    <script src="../assets/js/typeahead.js"></script>
    <script src="../assets/js/select2.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const clockIcons = document.querySelectorAll('.clock-icon-timer');
            
            clockIcons.forEach(clockIcon => {
                let timerInterval;
                let startTime;

                function startTimer(startTime, timerDisplay) {
                    timerInterval = setInterval(function () {
                        const currentTime = new Date();
                        const elapsedTime = currentTime - new Date(startTime);
                        const elapsedSeconds = Math.floor(elapsedTime / 1000);

                        const hours = String(Math.floor(elapsedSeconds / 3600)).padStart(2, '0');
                        const minutes = String(Math.floor((elapsedSeconds % 3600) / 60)).padStart(2, '0');
                        const seconds = String(elapsedSeconds % 60).padStart(2, '0');

                        timerDisplay.textContent = `${hours}:${minutes}:${seconds}`;
                    }, 1000);
                }

                function stopTimer(taskId, timerDisplay) {
                    clearInterval(timerInterval);
                    timerInterval = null;

                    const currentTime = new Date();
                    const elapsedTime = currentTime - new Date(startTime);
                    const elapsedSeconds = Math.floor(elapsedTime / 1000);

                    const hours = String(Math.floor(elapsedSeconds / 3600)).padStart(2, '0');
                    const minutes = String(Math.floor((elapsedSeconds % 3600) / 60)).padStart(2, '0');
                    const seconds = String(elapsedSeconds % 60).padStart(2, '0');
                    const taskUsedTime = `${hours}:${minutes}:${seconds}`;
                    console.log(taskUsedTime);

                    localStorage.removeItem(`timerStartTime-${taskId}`);

                    fetch('../method/task_method.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `task_used_time=${taskUsedTime}&task_id=${taskId}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data); // Handle server response here
                    });
                }

                clockIcon.addEventListener('click', function () {
                    const taskId = clockIcon.getAttribute('data-task-id');
                    const timerDisplay = document.getElementById(`timer-${taskId}`);
                    
                    if (!timerInterval) {
                        startTime = new Date();
                        localStorage.setItem(`timerStartTime-${taskId}`, startTime.toISOString());
                        startTimer(startTime, timerDisplay);
                    } else {
                        stopTimer(taskId, timerDisplay);
                    }
                });

                const savedStartTime = localStorage.getItem(`timerStartTime-${clockIcon.getAttribute('data-task-id')}`);
                if (savedStartTime) {
                    startTime = new Date(savedStartTime);
                    startTimer(startTime, document.getElementById(`timer-${clockIcon.getAttribute('data-task-id')}`));
                }
            });
        });
    </script>

</body>
</html>
