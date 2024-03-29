<?php
session_start();
include '../php/db.php';
$unique_id = $_SESSION['unique_id'];
$email = $_SESSION['email'];
if (empty($unique_id)) {
    header("Location: ../login_page.html");
}
$qry = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
if (mysqli_num_rows($qry) > 0) {
    $row = mysqli_fetch_assoc($qry);
    $first_name = $row['fname'];
    $phone = $row['phone'];
    $role = $row['Role'];
    // $data = $row['data'];
    // $amount = $row['Amount'];
    $data = "20";
    $amount = "20";

    if ($row) {
        $_SESSION['Role'] = $row['Role'];
        if ($row['verification_status'] != 'Verified') {
            header("Location: verify.php");
        }
    }
}
// Helper function to truncate text to a specified number of words
function truncateText($text, $maxWords)
{
    $wordArray = explode(' ', $text); // Break string into word array
    if (count($wordArray) > $maxWords) {
        // Slice the array if word count exceeds the limit
        $wordArray = array_slice($wordArray, 0, $maxWords);
        $text = implode(' ', $wordArray) . '...'; // Rebuild the string and append ellipsis
    }
    return $text;
}

$maxWordsToDisplay = 10; // Set the maximum number of words you want to display

// Function to count tasks by status
function countTasksByStatus($tasks, $status)
{
    return count(array_filter($tasks, function ($task) use ($status) {
        return $task['status'] === $status;
    }));
}

// $tasks = [
//     [
//         'id' => 1,
//         'company' => 'Company A',
//         'info' => 'Strategy planning meeting for Q3. Discussing new market opportunities and product launches.',
//         'amount' => 100,
//         'meeting_time' => 'April 21, 2024, 10:00 AM',
//         'platform' => 'Zoom',
//         'meeting_link' => 'https://zoom.us/j/1234567890',
//         'agenda_link' => 'https://docs.google.com/document/d/1ABCDEFGH/document',
//         'special_instructions' => 'Please review the market analysis report before the meeting.',
//         'files_link' => 'https://drive.google.com/drive/folders/1HIJKLMNOP',
//         'status' => 'completed',
//     ],
//     [
//         'id' => 2,
//         'company' => 'Company A',
//         'info' => 'Product design brainstorming session. Focus on user experience and design aesthetics.',
//         'amount' => 200,
//         'meeting_time' => 'April 22, 2024, 11:00 AM',
//         'platform' => 'Microsoft Teams',
//         'meeting_link' => 'https://teams.microsoft.com/l/meetup-join/234567890',
//         'agenda_link' => 'https://docs.google.com/document/d/1IJKLMNOPQ/document',
//         'special_instructions' => 'Prepare 3 design proposals to discuss.',
//         'files_link' => 'https://drive.google.com/drive/folders/1QRSTUVWXYZ',
//         'status' => 'rejected',
//     ],
//     [
//         'id' => 3,
//         'company' => 'Company A',
//         'info' => 'Day 3 Meeting information focused on sales targets and key performance indicators for the sales team.',
//         'amount' => 100,
//         'meeting_time' => 'April 23, 2024, 10:00 AM',
//         'platform' => 'Google Meet',
//         'meeting_link' => 'https://meet.google.com/123-456-789',
//         'agenda_link' => 'https://docs.google.com/document/d/1ABCDEFGH2/document',
//         'special_instructions' => 'Have your previous quarter sales reports ready for discussion.',
//         'files_link' => 'https://drive.google.com/drive/folders/1ABCDE12345',
//         'status' => 'accepted',
//     ],
// ];

$taskQuery = "SELECT * FROM tasks WHERE (SELECT id FROM users WHERE unique_id = '{$unique_id}') = assigned_to";
$taskResult = $conn->query($taskQuery);

$tasks = [];
if ($taskResult->num_rows > 0) {
    while ($taskRow = $taskResult->fetch_assoc()) {
        $tasks[] = $taskRow;
    }
}
// Counters for different statuses
$acceptedTasksCount = countTasksByStatus($tasks, 'accepted');
$rejectedTasksCount = countTasksByStatus($tasks, 'rejected');
$completedTasksCount = countTasksByStatus($tasks, 'completed');
$totalTasksCount = count($tasks);

if (isset($_SESSION['message'])) {
    echo "<p class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative'>" . $_SESSION['message'] . "</p>";
    unset($_SESSION['message']);
}

if (isset($_SESSION['error'])) {
    echo "<p class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}



if (empty($includeFromTaskDetails)) {
    // HTML and direct output here will only be executed
    // if $includeFromTaskDetails is not set or is false.
    ?>
    <!DOCTYPE html>
    <html lang="en" class="light-theme">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
            rel="stylesheet">

        <link rel="stylesheet" href="css1/owl.carousel.min.css">
        <link rel="stylesheet" href="css1/fontAwsome.min.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Londrina+Solid:wght@300&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
        <link href="./output.css" rel="stylesheet">
        <link href="../css1/style.css" rel="stylesheet">
    </head>


    <body class="bg-white font-poppins text-black">

        <nav style="background: #a200ff; " class=" navbar navbar-expand-lg fixed-top">
            <!-- Brand -->
            <div class="container">
                <a class="navbar-brand" href="#">Welcome:
                    <?php echo $first_name; ?>
                </a>

                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Navbar links -->
                <div class="" id="collapsibleNavbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link " href="../homepage.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./user_dashboard.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-scroll-nav="4" href="#pricing">Data</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-scroll-nav="5" href="#contact">Contact</a>
                        </li>
                        <li class="nav-item logout-btn">
                            <a class="nav-link" href="../php/logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-semibold mb-6">Tasks Dashboard</h1>

            <!-- Dashboard counters -->
            <div class="justify-between mb-4 grid grid-cols-2 gap-4">
                <div class="p-4 bg-blue-200 rounded">
                    <h2 class="font-bold">Accepted Jobs</h2>
                    <p>
                        <?php echo $acceptedTasksCount; ?>
                    </p>
                </div>
                <div class="p-4 bg-red-200 rounded">
                    <h2 class="font-bold">Rejected Jobs</h2>
                    <p>
                        <?php echo $rejectedTasksCount; ?>
                    </p>
                </div>
                <div class="p-4 bg-green-200 rounded">
                    <h2 class="font-bold">Completed Jobs</h2>
                    <p>
                        <?php echo $completedTasksCount; ?>
                    </p>
                </div>
                <div class="p-4 bg-gray-200 rounded">
                    <h2 class="font-bold">Total Jobs</h2>
                    <p>
                        <?php echo $totalTasksCount; ?>
                    </p>
                </div>
            </div>
            <hr class="h-0.5 bg-main">

            <h2 class="text-xl font-semibold my-4">Available Jobs:</h2>

            <!-- Task list -->
            <div class="space-y-4">
                <?php foreach ($tasks as $task): ?>
                    <div
                        class="bg-main flex flex-col md:flex-row justify-between align-middle p-4 rounded-lg shadow-md text-white space-y-2 md:space-y-0 md:space-x-4">

                        <span class="bg-white text-black px-3 py-2 rounded self-start md:self-center">
                            <?php echo $task['status']; ?>
                        </span>

                        <h3 class="text-xl truncate font-semibold">
                            <?php echo " {$task['company']}"; ?>
                        </h3>

                        <p class="truncate">
                            <?php echo truncateText($task['info'], $maxWordsToDisplay); ?>
                        </p>

                        <p class=""><strong>Amount:</strong> $
                            <?php echo $task['amount']; ?>
                        </p>

                        <div class="flex justify-end">
                            <a href="task-details.php?task_id=<?php echo $task['id']; ?>"
                                class="bg-white text-black py-2 px-4 rounded">View Job</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>


        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../js1/owl.carousel.min.js"></script>
        <script src="../js1/scrollIt.min.js"></script>
        <script src="../js1/script.js"></script>
    </body>

    </html>
    <?php
}
?>