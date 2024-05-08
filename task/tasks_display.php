<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <style>
        #addTaskForm {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Tasks Dashboard</h1>

        <!-- Button to show or hide the add task form -->
        <button id="showFormBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Task
        </button>

        <!-- The add task form -->
        <div id="addTaskForm" class="mt-4">
            <?php include 'task_form.php'; ?>
        </div>

        <div class="mt-8">
            <?php
            if ($result->num_rows > 0) {
                echo '<div class="overflow-x-auto">';
                echo '<table class="min-w-full table-auto">';
                echo '<thead class="bg-gray-200">';
                echo '<tr>';
                echo '<th class="px-4 py-2">Task Name</th>';
                echo '<th class="px-4 py-2">Company</th>';
                echo '<th class="px-4 py-2">Date</th>';
                echo '<th class="px-4 py-2">Status</th>';
                echo '<th class="px-4 py-2">Assigned To</th>';
                echo '<th class="px-4 py-2">Actions</th>'; // Added column for actions
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="border px-4 py-2">' . $row["name"] . '</td>';
                    echo '<td class="border px-4 py-2">' . $row["company"] . '</td>';
                    echo '<td class="border px-4 py-2">' . $row["created_at"] . '</td>';
                    echo '<td class="border px-4 py-2">' . $row["status"] . '</td>';

                    // Fetch the user's email from the $users array based on the assigned_to ID
                    $assignedEmail = '';
                    foreach ($users as $user) {
                        if ($user['id'] == $row["assigned_to"]) {
                            $assignedEmail = $user['email'];
                            break;
                        }
                    }

                    // Display the assigned email
                    echo '<td class="border px-4 py-2">' . $assignedEmail . '</td>';
                    echo '<td class="border px-4 py-2">';
                    echo '<a href="tasks.php?id=' . $row["id"] . '" class="text-blue-500 mr-2">View</a>'; // View task button
                    echo '<a href="delete_task.php?id=' . $row["id"] . '" onclick="return confirm(\'Are you sure you want to delete this task?\')" class="text-red-500">Delete</a>';
                    ; // Delete task button
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<div class="text-center text-gray-500">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto mb-4" viewBox="0 0 20 20" fill="currentColor">';
                echo '<path fill-rule="evenodd" d="M10 2a8 8 0 00-8 8c0 3.38 2.464 6.197 5.678 6.788.233.885.928 1.571 1.769 1.791C8.443 19.094 9.213 20 10 20s1.557-.906 2.553-1.421c.841-.22 1.536-.906 1.769-1.791C17.536 16.197 20 13.38 20 10a8 8 0 00-8-8zM8 11a1 1 0 11-2 0 1 1 0 012 0zm2 0a1 1 0 11-2 0 1 1 0 012 0zm4 0a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />';
                echo '</svg>';
                echo '<p>No tasks available</p>';
                echo '</div>';
            }
            ?>
        </div>

        <script>
            document.getElementById("showFormBtn").addEventListener("click", function () {
                var form = document.getElementById("addTaskForm");
                var btn = document.getElementById("showFormBtn");
                if (form.style.display === "none" || !form.style.display) {
                    form.style.display = "block";
                    btn.textContent = "Close Form";
                } else {
                    form.style.display = "none";
                    btn.textContent = "Add New Task";
                }
            });
        </script>
    </div>
</body>

</html>