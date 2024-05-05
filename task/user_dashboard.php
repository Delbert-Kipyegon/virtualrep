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
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>


<body class="bg-white font-poppins text-black">
    <!-- Responsive Navbar -->
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <!-- Logo and Welcome Message -->
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Welcome,
                    <?php echo $first_name; ?></span>
            </a>
            <!-- Mobile menu button -->
            <button onclick="toggleMenu()" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 6h18M3 12h18M3 18h18" />
                </svg>
            </button>
            <!-- Menu items -->
            <div class="hidden w-full md:block md:w-auto" id="navbar">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="../homepage.php"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
                    </li>
                    <li>
                        <a href="user_profile.php"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Profile</a>
                    </li>
                    <li>
                        <a href="../php/logout.php"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Logout</a>
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

    <script>
        function toggleMenu() {
            const navbar = document.getElementById('navbar');
            navbar.classList.toggle('hidden');
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit-code.js"></script>
    <script src="../js1/owl.carousel.min.js"></script>
    <script src="../js1/scrollIt.min.js"></script>
    <script src="../js1/script.js"></script>
</body>

</html>