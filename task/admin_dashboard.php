<?php
// Start the session and include database connection
session_start();
include '../php/db.php';

// Check if the unique_id is set in the session and the user role is admin
if (!isset($_SESSION['unique_id']) || $_SESSION['Role'] !== 'admin') {
    // Redirect to the login page if the user is not logged in or not an admin
    header("Location: ../login_page.html"); // Adjust the path to your login page
    exit();
}

// get users
function getUsers($conn)
{
    $sql = "SELECT * FROM users WHERE Role = 'user'";
    $result = $conn->query($sql); // Execute the query using the database connection

    $users = [];
    if ($result->num_rows > 0) {
        // Loop through each row in the result set
        while ($row = $result->fetch_assoc()) {
            // Fetch PayPal email for each user
            $row['paypal_email'] = getPaypalEmail($conn, $row['id']);
            $users[] = $row;
        }
    }
    return $users;
}

// get paypal email for users from user_data table
function getPaypalEmail($conn, $user_id)
{
    $sql = "SELECT paypal_email FROM user_data WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['paypal_email'];
    }
    return null;
}

$users = getUsers($conn); // Fetch all users with PayPal email


//get all tasks
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);

// submitting tasks to the database
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and prepare variables from form data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING);
    $info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    $meeting_time = filter_input(INPUT_POST, 'meeting_time', FILTER_SANITIZE_STRING);
    $platform = filter_input(INPUT_POST, 'platform', FILTER_SANITIZE_STRING);
    $meeting_link = filter_input(INPUT_POST, 'meeting_link', FILTER_SANITIZE_URL);
    $agenda_link = filter_input(INPUT_POST, 'agenda_link', FILTER_SANITIZE_URL);
    $special_instructions = filter_input(INPUT_POST, 'special_instructions', FILTER_SANITIZE_STRING);
    $files_link = filter_input(INPUT_POST, 'files_link', FILTER_SANITIZE_URL);
    $assigned_to = filter_input(INPUT_POST, 'assigned_to', FILTER_SANITIZE_NUMBER_INT);
    

    // SQL to insert data
    $sql = "INSERT INTO tasks (name, company, info, amount, meeting_time, platform, meeting_link, agenda_link, special_instructions, files_link, assigned_to) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssssssssi", $name, $company, $info, $amount, $meeting_time, $platform, $meeting_link, $agenda_link, $special_instructions, $files_link, $assigned_to);

    // Execute the statement once and check the result
    if ($stmt->execute()) {
        // If execution is successful
        $_SESSION['success'] = 'Task added successfully!';
        // Use JavaScript for alert and redirection
        echo "<script>
            alert('Task added successfully!');
            window.location.href='?page=add_task'; 
          </script>";
        exit(); // Stop script execution after redirection
    } else {
        // If execution failed
        echo "<script>alert('Error executing query: " . addslashes($stmt->error) . "');</script>";
    }

    // Close the statement
    $stmt->close();

}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';


// Fetch notifications
$notificationsByDate = [];
if ($page === 'notifications') {
    $sql = "SELECT notifications.*, tasks.name as task_name FROM notifications 
            JOIN tasks ON notifications.task_id = tasks.id 
            ORDER BY notifications.created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = date('Y-m-d', strtotime($row['created_at']));
            $notificationsByDate[$date][] = $row;
        }
    }
}

$taskCount = $conn->query("SELECT COUNT(*) as count FROM tasks")->fetch_assoc()['count'];
$userCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Optional: Add additional custom styles */
        body,
        html {
            height: 100%;
        }

        .full-height {
            height: 100%;
        }

        .overflow-scroll {
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Sidebar -->
    <div class="md:flex full-height">
        <div id="sidebar"
            class="bg-purple-600 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out h-screen">
            <!-- logo -->
            <h1 class="text-white text-3xl font-semibold pl-6 md:pl-0 hover:text-gray-300">Admin</h1>
            <!-- nav -->
            <nav>
                <a href="../homepage.php"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-purple-700 hover:text-white">Back
                    to Home</a>
                <a href="?page=dashboard"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-purple-700 hover:text-white">Dashboard</a>
                <a href="?page=add_task"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-purple-700 hover:text-white">Tasks</a>
                <a href="?page=view_users"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-purple-700 hover:text-white">View
                    Users</a>
                <a href="?page=notifications"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-purple-700 hover:text-white">Notifications</a>
            </nav>
        </div>

        <div class="flex-1 full-height overflow-scroll">
            <!-- Toggle Button -->
            <button id="sidebarToggle" class="text-purple-600 p-4 focus:outline-none md:hidden"
                onclick="toggleSidebar()">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <!-- Main Content -->
            <div class="p-4">
                <?php
                switch ($page) {
                    case 'add_task':
                        include 'tasks_display.php';
                        break;
                    case 'view_users':
                        include 'users_section.php';
                        break;
                    case 'notifications':
                        include 'notifications_section.php';
                        break;
                    default:
                        echo '<h1 class="text-3xl text-gray-700 mb-6">Dashboard Overview</h1>';
                        echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-4">';
                        echo '<div class="bg-white p-4 rounded-lg shadow text-center">';
                        echo '<h2 class="text-xl font-semibold mb-2">Total Tasks</h2>';
                        echo '<div class="text-3xl font-bold">' . $taskCount . '</div>';
                        echo '</div>';
                        echo '<div class="bg-white p-4 rounded-lg shadow text-center">';
                        echo '<h2 class="text-xl font-semibold mb-2">Total Users</h2>';
                        echo '<div class="text-3xl font-bold">' . $userCount . '</div>';
                        echo '</div>';
                        echo '<div class="bg-white p-4 rounded-lg shadow col-span-2">';
                        echo '<h2 class="text-xl font-semibold mb-2">Activity Chart</h2>';
                        echo '<div id="chartPlaceholder" class="text-gray-500">Chart goes here (Integrate with Chart.js or similar)</div>';
                        echo '</div>';
                        echo '</div>';
                        break;
                }
                ?>
            </div>
        </div>
    </div>

    <script src="./script.js"></script>
</body>

</html>