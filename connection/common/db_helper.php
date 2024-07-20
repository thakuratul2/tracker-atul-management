<?php
include_once ("session.php");

/*

This is the db helper where we write all common sql here


*/


if (function_exists('get_user_get_id')) {
    echo "Function get_user_get_id already exists";
} else {
    function get_user_get_id()
    {
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        } else {
            return false;
        }
    }
}

function user_login()
{

    if (isset($_SESSION['user_id'])) {
        header("Location: ./dashboard.php");
        exit;
    }
}

function user_not_login()
{

    if (!isset($_SESSION['user_id'])) {
        header("Location: ./index.php");
        exit;
    }
}



function greetfunction()
{
    $time = date('H');
    if ($time >= 5 && $time <= 11) {
        echo "Good Morning";
    } else if ($time >= 12 && $time <= 18) {

        echo "Good Afternoon";
    } else if ($time >= 19 && $time <= 4) {

        echo "Good Evening";
    } else {
        echo "Good Night";
    }
}


function totalusers($conn)
{

    $sql = "select * from `users`";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($result);
    if ($rows > 0) {
        echo $rows;
    } else {
        echo "0";
    }
}

if (function_exists('get_total_clients')) {
    echo "Function get_total_clients already exists";
} else {
    function get_total_clients($conn)
    {
        $sql = "select * from `clients`";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($result);
        if ($rows > 0) {
            echo $rows;
        } else {
            echo "0";
        }
    }
}

if (function_exists('get_difference_client_status')) {
    echo "Function get_difference_client_statu already exists";
} else {

    function get_difference_client_status($conn)
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $sql_yesterday = "SELECT COUNT(*) as count FROM clients WHERE DATE(created_at) = '$yesterday'";
        $result_yesterday = $conn->query($sql_yesterday);
        $row_yesterday = $result_yesterday->fetch_assoc();
        $clients_yesterday = $row_yesterday['count'];


        $today = date('Y-m-d');
        $sql_today = "SELECT COUNT(*) as count FROM clients WHERE DATE(created_at) = '$today'";
        $result_today = $conn->query($sql_today);
        $row_today = $result_today->fetch_assoc();
        $clients_today = $row_today['count'];


        $difference = $clients_today - $clients_yesterday;
        $class = $difference >= 0 ? 'text-success' : 'text-danger';
        $icon = $difference >= 0 ? 'mdi-menu-up' : 'mdi-menu-down';
        $difference_percentage = ($clients_yesterday == 0) ? $difference : abs(($difference / $clients_yesterday));
        $difference_text = $difference_percentage;


        return [
            'class' => $class,
            'icon' => $icon,
            'difference_text' => $difference_text
        ];
    }
}

if (function_exists('get_difference_user_status')) {
    echo "Function get_difference_client_statu already exists";
} else {

    function get_difference_user_status($conn)
    {
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $sql_yesterday = "SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = '$yesterday'";
        $result_yesterday = $conn->query($sql_yesterday);
        $row_yesterday = $result_yesterday->fetch_assoc();
        $clients_yesterday = $row_yesterday['count'];


        $today = date('Y-m-d');
        $sql_today = "SELECT COUNT(*) as count FROM users WHERE DATE(created_at) = '$today'";
        $result_today = $conn->query($sql_today);
        $row_today = $result_today->fetch_assoc();
        $clients_today = $row_today['count'];


        $difference = $clients_today - $clients_yesterday;
        $class = $difference >= 0 ? 'text-success' : 'text-danger';
        $icon = $difference >= 0 ? 'mdi-menu-up' : 'mdi-menu-down';
        $difference_percentage = ($clients_yesterday == 0) ? $difference : abs(($difference / $clients_yesterday));
        $difference_text = $difference_percentage;


        return [
            'class' => $class,
            'icon' => $icon,
            'difference_text' => $difference_text
        ];
    }
}

if (function_exists('display_clients')) {
    echo "Function display_clients already exists";
} else {
    function display_clients($conn)
    {
        $sql = "SELECT * FROM clients";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            $snr = 1;

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $snr++ . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";

                echo "<td>" . $row['email'] . "</td>";
                if ($row['address'] == 0 || $row['address'] == null) {
                    echo "<td>No address found</td>";
                } else {
                    echo "<td>" . $row['address'] . "</td>";
                }
                echo "<td>" . $row['mobile'] . "</td>";
                if ($row['status'] == 0) {
                    echo "<td> <label class='badge badge-success'>Enable</td>";
                } else {
                    echo "<td> <label class='badge badge-danger'>Disable</td>";
                }
                echo "<td>
                        <a href='../clients/client_edit.php?id=" . $row['id'] . "' class='btn btn-success'>Edit</a>
                        <a href='../clients/client_delete.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
                    </td>";

                echo "</tr>";
            }


        } else {
            echo "No clients found.";
        }
    }
}


if (function_exists('get_project_types')) {
    echo "Function get_project_types already exists";
} else {
    function get_project_types($conn)
    {
        $sql = "SELECT * FROM project_type";
        $result = mysqli_query($conn, $sql);
        $project_types = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $project_types[] = $row;
            }
        }
        return $project_types;

    }
}

if (function_exists('display_users')) {
    echo 'this function already exists';
} else {
    function display_users($conn)
    {
        $sql = "select * from users";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($result);
        if ($rows > 0) {
            $nir = 1;
            while ($data = mysqli_fetch_assoc($result)) {
                
                echo "<tr>";
                echo "<td>" . $nir++ . "</td>";
                echo "<td>" . $data['name'] . "</td>";
                if ($data['email'] == null) {
                    echo "<td>No email Found</td>";
                } else {
                    echo "<td>" . $data['email'] . "</td>";
                }
                if ($data['address'] == null) {
                    echo "<td>No Address Found</td>";
                } else {
                    echo "<td>" . $data['address'] . "</td>";
                }
                if ($data['salary'] == null) {
                    echo "<td>No salary Found</td>";
                } else {
                    echo "<td>" . $data['salary'] . "</td>";
                }
                $p_type_id = $data['role_id'];
                $sql_project_type = "SELECT userrole FROM users_role WHERE role_id = $p_type_id";
                $result_project_type = mysqli_query($conn, $sql_project_type);
                $row_project_type = mysqli_fetch_assoc($result_project_type);
                $project_type_name = isset($row_project_type['userrole']) ? $row_project_type['userrole'] : null;
                if ($project_type_name == NULL) {
                    echo "<td>Please assign role</td>";
                } else {
                    echo "<td>" . ucfirst($project_type_name) . "</td>";
                }
                
               
                if ($data['status'] == 0) {
                    echo "<td><label class='badge badge-success'>Enable</td>";
                } else {
                    echo "<td><label class='badge badge-danger'>Disable</td>";
                }
                echo "<td>
                        <a href='../users/user_edit.php?id=" . $data['id'] . "' class='btn btn-success'>Edit</a>
                         <a href='../users/user_delete.php?id=" . $data['id'] . "' class='btn btn-danger'>Delete</a>
                         </td>";
                echo "</tr>";
            }


        } else {
            echo "No User found.";
        }

    }
}

if (function_exists('get_projects_all')) {
    echo "Function get_project_all already exists";
} else {
    function get_project_all($conn)
    {


        $sql = "SELECT * FROM projects";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {

            $snr = 1;

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $snr++ . "</td>";
                echo "<td>" . $row['project_name'] . "</td>";
                echo "<td>" . $row['project_start'] . "</td>";

                echo "<td>" . $row['project_end'] . "</td>";
                echo "<td>" . $row['project_budget'] . "</td>";
                $p_type_id = $row['project_type'];
                $sql_project_type = "SELECT project_type FROM project_type WHERE p_type = $p_type_id";
                $result_project_type = mysqli_query($conn, $sql_project_type);
                $row_project_type = mysqli_fetch_assoc($result_project_type);
                $project_type_name = $row_project_type['project_type'];
                echo "<td>" . $project_type_name . "</td>";
                if ($row['status'] == 0) {
                    echo "<td> <label class='badge badge-warning'>Working</td>";
                } else {
                    echo "<td> <label class='badge badge-success'>Completed</td>";
                }
                echo "<td>
                        <a href='../projects/edit_project.php?p_id=" . $row['p_id'] . "' class='btn btn-success'>Edit</a>
                        <a href='../projects/delete_project.php?p_id=" . $row['p_id'] . "' class='btn btn-danger'>Delete</a>
                    </td>";

                echo "</tr>";
            }


        } else {
            echo "No Projects found.";
        }
    }
}

if(function_exists('get_count_project'))
{
    echo "Function get_count_project already exists";
}
else
{
    function get_count_project($conn)
    {

        $sql_count = "SELECT * FROM projects";
        $result = mysqli_query($conn, $sql_count);

        $row = mysqli_num_rows($result);

        if ($row > 0) {
            echo $row;
        } else {
            echo "0";
        }
    }

}

//fetch the roles for the users

if(function_exists('fetch_roles'))
{
    echo "Function fetch_roles already exists";
}
else
{
    function fetch_roles($conn)
    {
        $sql = "SELECT * FROM users_role";
        $result = mysqli_query($conn, $sql);
        $roles = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $roles[] = $row;
            }
        }
        return $roles;
    }
}

if(function_exists('fetch_project_tupe'))
{
    echo "Function fetch_roles already exists";
}
else
{
    function fetch_project_type($conn)
    {
        $sql = "SELECT * FROM project_type";
        $result = mysqli_query($conn, $sql);
        $roles = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $roles[] = $row;
            }
        }
        return $roles;
    }
}