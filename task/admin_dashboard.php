<?php
// Start the session
session_start();

// Assuming you'll be saving the tasks in a session or you can integrate database saving here.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $company = htmlspecialchars($_POST['company']);
    $info = htmlspecialchars($_POST['info']);
    $amount = htmlspecialchars($_POST['amount']);
    $meeting_time = htmlspecialchars($_POST['meeting_time']);
    $platform = htmlspecialchars($_POST['platform']);
    $meeting_link = htmlspecialchars($_POST['meeting_link']);
    $agenda_link = htmlspecialchars($_POST['agenda_link']);
    $special_instructions = htmlspecialchars($_POST['special_instructions']);
    $files_link = htmlspecialchars($_POST['files_link']);
    $status = htmlspecialchars($_POST['status']);

    // Task array
    $task = [
        'company' => $company,
        'info' => $info,
        'amount' => $amount,
        'meeting_time' => $meeting_time,
        'platform' => $platform,
        'meeting_link' => $meeting_link,
        'agenda_link' => $agenda_link,
        'special_instructions' => $special_instructions,
        'files_link' => $files_link,
        'status' => $status,
    ];

    // Save the task in a session or database
    $_SESSION['tasks'][] = $task;

    // Redirect or show a success message
    echo "Task added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Tailwind CSS from CDN for simplicity -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="container mx-auto my-8">
        <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-2xl font-semibold mb-4">Admin Dashboard - Add New Task</h1>

            <!-- Task form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="space-y-4">
                <div>
                    <label for="company" class="block text-gray-700 text-sm font-bold mb-2">Company:</label>
                    <input type="text" id="company" name="company" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="info" class="block text-gray-700 text-sm font-bold mb-2">Info:</label>
                    <textarea id="info" name="info" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>

                <div>
                    <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount:</label>
                    <input type="number" id="amount" name="amount" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="meeting_time" class="block text-gray-700 text-sm font-bold mb-2">Meeting Time:</label>
                    <input type="datetime-local" id="meeting_time" name="meeting_time" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="platform" class="block text-gray-700 text-sm font-bold mb-2">Platform:</label>
                    <input type="text" id="platform" name="platform" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="meeting_link" class="block text-gray-700 text-sm font-bold mb-2">Meeting Link:</label>
                    <input type="url" id="meeting_link" name="meeting_link" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="agenda_link" class="block text-gray-700 text-sm font-bold mb-2">Agenda Link:</label>
                    <input type="url" id="agenda_link" name="agenda_link" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="special_instructions" class="block text-gray-700 text-sm font-bold mb-2">Special
                        Instructions:</label>
                    <textarea id="special_instructions" name="special_instructions" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>

                </div>

                <div>
                    <label for="files_link" class="block text-gray-700 text-sm font-bold mb-2">Files Link:</label>
                    <input type="url" id="files_link" name="files_link" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div>
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                    <select id="status" name="status" required
                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="completed">Completed</option>
                        <option value="rejected">Rejected</option>
                        <option value="accepted">Accepted</option>
                    </select>
                </div>

                <div class="flex justify-end mt-4">
                    <input type="submit" value="Add Task"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer">
                </div>
            </form>
        </div>
    </div>
</body>

</html>