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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css">
</head>


<body class="bg-white h-screen flex flex-col justify-between font-poppins min-h-[100%] text-black">
    <div clas="pb-10">
        <!-- Responsive Navbar -->
        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <!-- Logo and Welcome Message -->
                <a href="#" class="flex hover:no-underline items-center space-x-3 rtl:space-x-reverse">
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
                                class=" hover:no-underline block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</a>
                        </li>

                        <li>
                            <a href="user_profile.php"
                                class=" hover:no-underline block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Profile</a>
                        </li>
                        <li>
                            <a href="../php/logout.php"
                                class=" hover:no-underline block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Logout</a>
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
            <hr class="h-0.5 bg-purple-700">

            <h2 class="text-xl font-semibold my-4">Available Jobs:</h2>

            <!-- Task list -->
            <div class="space-y-4 py-16">
                <?php if (empty($tasks)): ?>
                    <div class="text-center text-gray-500">
                        <img src="Images/notasks.jpg" alt="no tasks" />
                        <p>No tasks available</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <div
                            class="bg-purple-700 flex flex-col md:flex-row justify-between align-middle p-4 rounded-lg shadow-md text-white space-y-2 md:space-y-0 md:space-x-4">

                            <span class="px-3 py-2 rounded self-start md:self-center
            <?php
            // Check the status and set the background color accordingly
            switch ($task['status']) {
                case 'completed':
                    echo 'bg-green-500 text-white'; // Green background for completed tasks
                    break;
                case 'accepted':
                    echo 'bg-blue-500 text-white'; // Blue background for accepted tasks
                    break;
                case 'rejected':
                    echo 'bg-red-500 text-white'; // Red background for rejected tasks
                    break;
                default:
                    echo 'bg-gray-500'; // Light gray background for pending tasks
                    break;
            }
            ?>
        ">
                                <?php echo $task['status']; ?>
                            </span>

                            <h3 class="text-xl truncate font-semibold">
                                <?php echo " {$task['name']}"; ?>
                            </h3>

                            <p class="truncate">
                                <?php
                                $maxWords = 10;
                                echo truncateText($task['info'], $maxWords);
                                ?>
                            </p>

                            <p class=""><strong>Amount:</strong> $
                                <?php echo $task['amount']; ?>
                            </p>

                            <div class="flex justify-end">
                                <a href="task_details.php?task_id=<?php echo $task['id']; ?>"
                                    class="bg-white text-black py-2 px-4 rounded">View Job</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>


        </div>
    </div>

    <div class="footer">
        <?php include 'footer.php'; ?>
    </div>

    <script>
        function toggleMenu() {
            const navbar = document.getElementById('navbar');
            navbar.classList.toggle('hidden');
        }
    </script>
</body>

</html>