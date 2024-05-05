<?php
session_start();
include '../php/db.php';  // Assuming this file contains the database connection logic

if (empty($_SESSION['unique_id'])) {
    header("Location: ../login_page.html");
    exit;
}

$unique_id = $_SESSION['unique_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post data
    $gender = $_POST['gender'];
    $paypalEmail = $_POST['paypal_email'];
    $location = $_POST['location'];
    $dob = $_POST['dob'];
    $idNumber = $_POST['id_number'];

    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO user_data (user_id, gender, paypal_email, location, dob, id_number) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssi", $unique_id, $gender, $paypalEmail, $location, $dob, $idNumber);
    if ($stmt->execute()) {
        echo "Profile updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Update</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-poppins">
    <?php include 'nav.php'; ?>

    <div class="container max-wid mx-auto mt-10 p-4">

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Update Profile</h2>
            <hr class="mb-6">
            <form action="user_profile.php" method="post" class="space-y-6">
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-600">Gender</label>
                    <select name="gender" id="gender" required
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="paypal_email" class="block text-sm font-medium text-gray-600">PayPal Email</label>
                    <input type="email" name="paypal_email" id="paypal_email" required
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-600">Location</label>
                    <input type="text" name="location" id="location" required
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="dob" class="block text-sm font-medium text-gray-600">Date of Birth</label>
                    <input type="date" name="dob" id="dob" required
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="id_number" class="block text-sm font-medium text-gray-600">ID Number</label>
                    <input type="number" name="id_number" id="id_number" required
                        class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Update
                        Profile</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>