<?php
session_start();
include '../php/db.php';

// Check if unique_id is set and redirect if not
if (empty($_SESSION['unique_id'])) {
    header("Location: ../login_page.html");
    exit(); // Don't forget to call exit() after header redirection
}

$unique_id = $_SESSION['unique_id'];

// Fetch user details
$qry = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
if (!$qry) {
    die("DB Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($qry) > 0) {
    $row = mysqli_fetch_assoc($qry);
    $first_name = $row['fname'];
    $phone = $row['phone'];
    $role = $row['Role'];
    $_SESSION['Role'] = $role;

    // Redirect if not verified
    if ($row['verification_status'] != 'Verified') {
        header("Location: verify.html");
        exit();
    }
} else {
    // Handle no user found
    header("Location: ../login_page.html");
    exit();
}

// Define functions before using them
function truncateText($text, $maxWords)
{
    $wordArray = explode(' ', $text);
    if (count($wordArray) > $maxWords) {
        $wordArray = array_slice($wordArray, 0, $maxWords);
        $text = implode(' ', $wordArray) . '...';
    }
    return $text;
}

function countTasksByStatus($tasks, $status)
{
    return count(array_filter($tasks, function ($task) use ($status) {
        return $task['status'] === $status;
    }));
}

// Fetch tasks
$taskQuery = "SELECT * FROM tasks WHERE (SELECT id FROM users WHERE unique_id = '{$unique_id}') = assigned_to";
$taskResult = $conn->query($taskQuery);
if (!$taskResult) {
    die("DB Error: " . mysqli_error($conn));
}

$tasks = [];
while ($taskRow = $taskResult->fetch_assoc()) {
    $tasks[] = $taskRow;
}

$acceptedTasksCount = countTasksByStatus($tasks, 'accepted');
$rejectedTasksCount = countTasksByStatus($tasks, 'rejected');
$completedTasksCount = countTasksByStatus($tasks, 'completed');
$totalTasksCount = count($tasks);

?>

<!DOCTYPE html>
<html lang="en" class="light-theme">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard</title>
    <!-- Combine Google Fonts links -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css">
    <link href="./output.css" rel="stylesheet">
    <link href="../css1/style.css" rel="stylesheet">
</head>


<body class="bg-white font-poppins text-black">

    <nav class="navbar navbar-expand-lg fixed-top" style="background: #a200ff;">
        <div class="container">
            <a class="navbar-brand" href="#">Welcome: <?php echo $first_name; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar"
                aria-controls="collapsibleNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../homepage.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./user_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../php/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-6">My Tasks</h1>

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
                        <?php echo " {$task['name']}"; ?>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit-code.js"></script>
    <script src="../js1/owl.carousel.min.js"></script>
    <script src="../js1/scrollIt.min.js"></script>
    <script src="../js1/script.js"></script>
</body>

</html>