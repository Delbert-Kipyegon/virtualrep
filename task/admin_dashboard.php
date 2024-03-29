<?php
// Start the session and include database connection
session_start();
include '../php/db.php';

// get users
function getUsers($conn)
{
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql); // Execute the query using the database connection

    $users = [];
    if ($result->num_rows > 0) {
        // Loop through each row in the result set
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

$users = getUsers($conn); // Fetch all users
// $notifications = getNotifications($conn); // Fetch notifications


//get all tasks
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);

// submitting tasks to the database
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and prepare variables from form data
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
    $sql = "INSERT INTO tasks (company, info, amount, meeting_time, platform, meeting_link, agenda_link, special_instructions, files_link, assigned_to) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("ssdssssssi", $company, $info, $amount, $meeting_time, $platform, $meeting_link, $agenda_link, $special_instructions, $files_link, $assigned_to);

    // Execute the statement once and check the result
    if ($stmt->execute()) {
        // If execution is successful
        $_SESSION['success'] = 'Task added successfully!';
        // Use JavaScript for alert and redirection
        echo "<script>
            alert('Task added successfully!');
            window.location.href='?page=add_task'; // Adjust the redirect URL as needed
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white min-h-screen border-r border-gray-200">
            <div class="flex flex-col space-y-4 p-4">
                <a href="?page=dashboard"
                    class="text-gray-700 text-base font-semibold p-2 hover:bg-gray-200 rounded">Dashboard</a>
                <a href="?page=add_task" class="text-gray-700 text-base font-semibold p-2 hover:bg-gray-200 rounded">
                    Tasks</a>
                <a href="?page=view_users"
                    class="text-gray-700 text-base font-semibold p-2 hover:bg-gray-200 rounded">View Users</a>
                <a href="?page=notifications"
                    class="text-gray-700 text-base font-semibold p-2 hover:bg-gray-200 rounded">Notifications</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-4">
            <?php
            switch ($page) {
                case 'add_task':
                    include 'tasks.php'; // The task submission form
                    break;
                case 'view_users':
                    include 'users_section.php'; // The users viewing section
                    break;
                case 'notifications':
                    include 'notifications_section.php'; // The notifications section
                    break;
                default:
                    echo '<h1>Welcome to the Admin Dashboard</h1>';
                    break;
            }
            ?>
        </div>
    </div>
</body>

</html>