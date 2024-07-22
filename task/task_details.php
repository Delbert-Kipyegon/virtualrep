<?php
include '../php/db.php';

$includeFromTaskDetails = true;
// Fetch tasks for task_details.php
$task_id = isset($_GET['task_id']) ? $_GET['task_id'] : 0;

// Fetch the task details from the database based on $task_id
$taskQuery = "SELECT * FROM tasks WHERE id = {$task_id} AND status != 'rejected'";
$taskResult = $conn->query($taskQuery);
if (!$taskResult) {
    die("DB Error: " . mysqli_error($conn));
}

$tasks = [];
while ($taskRow = $taskResult->fetch_assoc()) {
    $tasks[] = $taskRow;
}

?>

<!DOCTYPE html>
<html lang="en" class="light-theme">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <link href="./output.css" rel="stylesheet">
</head>

<body class="font-poppins">
    <div class="container p-4 flex flex-col justify-evenly gap-8 bg-white">
        <div>
            <a href="./user_dashboard.php" class="btn-back bg-main text-white hover:shadow-lg py-2 px-4 rounded ">Back
                to Dashboard</a>
        </div>

        <?php
        $task_id = isset($_GET['task_id']) ? $_GET['task_id'] : 0;

        $task_found = false; // Flag to check if the task is found
        
        foreach ($tasks as $task) {
            if ($task['id'] == $task_id) {
                $task_found = true; // Task is found
                ?>
                <div class="bg-white pt-2 p-6 rounded-lg border-main shadow-lg space-y-3">
                    <h2 class="text-2xl font-semibold">Task Details for Task #
                        <?php echo htmlspecialchars($task['id']); ?>
                    </h2>
                    <p><strong>Company:</strong>
                        <?php echo htmlspecialchars($task['company']); ?>
                    </p>
                    <p><strong>Meeting Information:</strong>
                        <?php echo htmlspecialchars($task['info']); ?>
                    </p>
                    <p><strong>Amount:</strong> $
                        <?php echo htmlspecialchars($task['amount']); ?>
                    </p>
                    <p><strong>Meeting Time:</strong>
                        <?php echo htmlspecialchars($task['meeting_time']); ?>
                    </p>
                    <p><strong>Meeting Platform:</strong>
                        <?php echo htmlspecialchars($task['platform']); ?>
                    </p>
                    <p><strong>Meeting Link:</strong> <a href="<?php echo htmlspecialchars($task['meeting_link']); ?>"
                            target="_blank" class="text-blue-400 hover:text-blue-500">Join Meeting</a></p>
                    <p><strong>Agenda:</strong> <a href="<?php echo htmlspecialchars($task['agenda_link']); ?>" target="_blank"
                            class="text-blue-400 hover:text-blue-500">View Agenda</a></p>
                    <p><strong>Special Instructions:</strong>
                        <?php echo htmlspecialchars($task['special_instructions']); ?>
                    </p>
                    <p><strong>Files:</strong> <a href="<?php echo htmlspecialchars($task['files_link']); ?>" target="_blank"
                            class="text-blue-400 hover:text-blue-500">Access Files</a></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($task['status']); ?></p>

                    <?php
                    // Show job status message based on the task status
                    if ($task['status'] == 'accepted') {
                        echo '<p class="text-green-500 font-semibold">Job Accepted</p>';
                    } elseif ($task['status'] == 'rejected') {
                        echo '<p class="text-red-500 font-semibold">Job Rejected</p>';
                    } else {
                        // Show Accept and Reject buttons if status is pending or any other status
                        ?>
                        <div class="flex flex-row gap-5 ">
                            <button onclick="confirmAction('accept')"
                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded cursor-pointer"
                                id="acceptJobBtn">Accept Job</button>

                            <button onclick="confirmAction('reject')"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded cursor-pointer"
                                id="rejectJobBtn">Reject Job</button>
                        </div>

                        <script>
                            function confirmAction(action) {
                                var message = action === 'accept' ? 'accept' : 'reject';
                                if (confirm("Are you sure you want to " + message + " the job?")) {
                                    // If user confirms, proceed with the action
                                    window.location.href = action === 'accept' ? "acceptTask.php?task_id=<?php echo htmlspecialchars($task_id); ?>" : "rejectTask.php?task_id=<?php echo htmlspecialchars($task_id); ?>";
                                }
                            }
                        </script>
                        <?php
                    }
                    ?>
                </div>
                <?php
                break; // Stop the loop after finding the task
            }
        }

        if (!$task_id || !$task_found) {
            echo "<p class='text-red-500'>Task not found.</p>";
        }
        ?>

        <?php
        // After the task details or "Task not found" message
        if ($task_found) {
            ?>
            <hr class="h-0.5 bg-main ">

            <!-- Task Submission Form -->
            <div class="">
                <h3 class="text-xl pb-6 font-semibold">Submit Task</h3>
                <form action="submitTask.php" method="POST" class="flex flex-col gap-4">
                    <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task_id); ?>">
                    <textarea name="comments" class=" p-2 border rounded" placeholder="Enter your comments here..."
                        rows="4"></textarea>
                    <button type="submit"
                        class="bg-main hover:bg-purple-500 mx-auto text-white font-bold py-2 px-4 rounded cursor-pointer">
                        Submit Task
                    </button>
                </form>
            </div>

            <div class="mt-6">
                <p>By accepting the job, you agree to our <a href="./termsandconditions.html"
                        class="text-blue-400 hover:text-blue-500">Terms and Conditions</a>.</p>
            </div>

            <?php
        }
        ?>
    </div>

    <script>
        function acceptJob() {
            // Accept Job button changes
            document.getElementById('acceptJobBtn').classList.remove('bg-gray-500', 'hover:bg-gray-600');
            document.getElementById('acceptJobBtn').classList.add('bg-green-500', 'hover:bg-green-600');
            document.getElementById('acceptJobBtn').innerText = 'Job Accepted';
            document.getElementById('acceptJobBtn').disabled = true;

            // Reset Reject Job button to initial state
            document.getElementById('rejectJobBtn').classList.add('bg-gray-500', 'hover:bg-gray-600');
            document.getElementById('rejectJobBtn').classList.remove('bg-red-500', 'hover:bg-red-600');
            document.getElementById('rejectJobBtn').innerText = 'Reject Job';
            document.getElementById('rejectJobBtn').disabled = false;

            alert('You have accepted the job!');
        }

        function rejectJob() {
            // Reject Job button changes
            document.getElementById('rejectJobBtn').classList.remove('bg-gray-500', 'hover:bg-gray-600');
            document.getElementById('rejectJobBtn').classList.add('bg-red-500', 'hover:bg-red-600');
            document.getElementById('rejectJobBtn').innerText = 'Job Rejected';
            document.getElementById('rejectJobBtn').disabled = true;

            // Reset Accept Job button to initial state
            document.getElementById('acceptJobBtn').classList.add('bg-gray-500', 'hover:bg-gray-600');
            document.getElementById('acceptJobBtn').classList.remove('bg-green-500', 'hover:bg-green-600');
            document.getElementById('acceptJobBtn').innerText = 'Accept Job';
            document.getElementById('acceptJobBtn').disabled = false;

            alert('You have rejected the job.');
        }
    </script>

</body>

</html>