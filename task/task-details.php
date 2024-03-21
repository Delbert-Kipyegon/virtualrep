<?php
$includeFromTaskDetails = true;
require_once './user_dashboard.php';
?>


<!DOCTYPE html>
<html lang="en" class="light-theme">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="./output.css" rel="stylesheet">
</head>

<body class="font-poppins">
    <div class="container p-4 flex flex-col justify-evenly gap-8 bg-white">
        <div>
            <a href="./user_dashboard.php" class="btn-back bg-main text-white hover:shadow-lg py-2 px-4 rounded ">Back
                to
                Dashboard</a>
        </div>

        <?php
        $task_id = isset ($_GET['task_id']) ? $_GET['task_id'] : 0;

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
            <!-- Accept Job Button -->
            <div class="flex flex-row gap-5 ">
                <button id="acceptJobBtn" onclick="acceptJob()"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                    Accept Job
                </button>
                <button id="rejectJobBtn" onclick="rejectJob()"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                    Reject Job
                </button>
            </div>



            <hr class="h-0.5 bg-main ">

            <!-- Task Submission Form -->
            <div class="mt-4 mx-auto w-[60%] pb-10">
                <h3 class="text-xl pb-6 font-semibold">Submit Task</h3>
                <form action="submitTask.php" method="POST" class="flex flex-col gap-4">
                    <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task_id); ?>">
                    <textarea name="comments" class="resize-none p-2 border rounded"
                        placeholder="Enter your comments here..." rows="4"></textarea>
                    <button type="submit"
                        class="bg-main hover:bg-purple-500 text-white font-bold py-2 px-4 rounded cursor-pointer">
                        Submit Task
                    </button>
                </form>
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