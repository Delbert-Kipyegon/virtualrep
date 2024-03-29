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
    <div class="container mx-auto my-8">
        <h1 class="text-xl font-bold mb-4">Tasks Dashboard</h1>

        <!-- Button to show the add task form -->
        <button id="showFormBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add Task
        </button>

        <!-- The add task form -->
        <div id="addTaskForm">
            <?php include 'task_form.php'; ?>
        </div>

        <!-- Display tasks -->
        <div class="mt-8">
            <?php
            if ($result->num_rows > 0) {
                echo '<div class="overflow-x-auto">';
                echo '<table class="min-w-full table-auto">';
                echo '<thead class="bg-gray-200">';
                echo '<tr>';
                echo '<th class="px-4 py-2">Company</th>';
                echo '<th class="px-4 py-2">Info</th>';
                echo '<th class="px-4 py-2">Amount</th>';
                echo '<th class="px-4 py-2">Meeting Time</th>';
                echo '<th class="px-4 py-2">Platform</th>';
                echo '<th class="px-4 py-2">Meeting Link</th>';
                echo '<th class="px-4 py-2">Agenda Link</th>';
                echo '<th class="px-4 py-2">Special Instructions</th>';
                echo '<th class="px-4 py-2">Files Link</th>';
                echo '<th class="px-4 py-2">Status</th>';
                echo '<th class="px-4 py-2">Assigned To</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="border px-4 py-2">' . $row["company"] . '</td>';
                    echo '<td class="border px-4 py-2">' . $row["info"] . '</td>';
                    echo '<td class="border px-4 py-2">' . $row["amount"] . '</td>';
                    echo '<td class="border px-4 py-2">' . $row["meeting_time"] . '</td>';
                    echo '<td class="border px-4 py-2">' . $row["platform"] . '</td>';
                    echo '<td class="border px-4 py-2"><a href="' . $row["meeting_link"] . '" target="_blank">Link</a></td>';
                    echo '<td class="border px-4 py-2"><a href="' . $row["agenda_link"] . '" target="_blank">Link</a></td>';
                    echo '<td class="border px-4 py-2">' . $row["special_instructions"] . '</td>';
                    echo '<td class="border px-4 py-2"><a href="' . $row["files_link"] . '" target="_blank">Link</a></td>';
                    echo '<td class="border px-4 py-2">' . $row["status"] . '</td>';
                    echo '<td class="border px-4 py-2">' . $row["assigned_to"] . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo "<p class='text-lg text-red-500'>No tasks found.</p>";
            }
            ?>

        </div>
    </div>

    <script>
        document.getElementById("showFormBtn").addEventListener("click", function () {
            var form = document.getElementById("addTaskForm");
            if (form.style.display === "none" || !form.style.display) {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        });
    </script>
</body>

</html>