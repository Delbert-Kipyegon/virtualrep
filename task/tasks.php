<?php
// Include your database connection code here
include '../php/db.php';

// Check if task ID is provided in the URL
if (isset($_GET['id'])) {
    $taskId = $_GET['id'];

    // Fetch the task details from the database
    $sql = "SELECT * FROM tasks WHERE id = $taskId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>View Task</title>
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
        </head>

        <body class="bg-gray-100">
            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-6">View Task</h1>
                <div class="border p-4 bg-white rounded-lg shadow-md">
                    <h2 class="text-xl font-bold mb-2"><?php echo $row['name']; ?></h2>
                    <p><strong>Company:</strong> <?php echo $row['company']; ?></p>
                    <p><strong>Info:</strong> <?php echo $row['info']; ?></p>
                    <p><strong>Amount:</strong> <?php echo $row['amount']; ?></p>
                    <p><strong>Meeting Time:</strong> <?php echo $row['meeting_time']; ?></p>
                    <p><strong>Platform:</strong> <?php echo $row['platform']; ?></p>
                    <p><strong>Meeting Link:</strong> <a href="<?php echo $row['meeting_link']; ?>" target="_blank">Link</a></p>
                    <p><strong>Agenda Link:</strong> <a href="<?php echo $row['agenda_link']; ?>" target="_blank">Link</a></p>
                    <p><strong>Special Instructions:</strong> <?php echo $row['special_instructions']; ?></p>
                    <p><strong>Files Link:</strong> <a href="<?php echo $row['files_link']; ?>" target="_blank">Link</a></p>
                    <p><strong>Status:</strong> <?php echo $row['status']; ?></p>
                    <p><strong>Assigned To:</strong> <?php echo $row['assigned_to']; ?></p>
                </div>

                <div class="mt-6">
                    <a href="admin_dashboard.php?page=add_task  "
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back to
                        Dashboard</a>
                </div>
            </div>
        </body>

        </html>
        <?php
    } else {
        echo 'Task not found.';
    }
} else {
    echo 'Task ID not provided.';
}
?>