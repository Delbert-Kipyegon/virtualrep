<?php
session_start();
include '../php/db.php';

if (empty($_SESSION['unique_id'])) {
    header("Location: ../login_page.html");
    exit;
}

$unique_id = $_SESSION['unique_id'];

// Fetch user's information from the users table
$stmt = $conn->prepare("SELECT id, fname, lname, email, phone FROM users WHERE unique_id = ?");
$stmt->bind_param("s", $unique_id);
$stmt->execute();
$result = $stmt->get_result();
$user_info = $result->fetch_assoc();
$stmt->close();

// Check if the user has completed their profile
$stmt = $conn->prepare("SELECT * FROM user_data WHERE user_id = (SELECT id FROM users WHERE unique_id = ?)");
$stmt->bind_param("s", $unique_id);
$stmt->execute();
$result = $stmt->get_result();
$profile_completed = $result->num_rows > 0;
$stmt->close();

// Fetch user's profile data if it exists
if ($profile_completed) {
    // Prepare and execute the SELECT query to fetch profile data
    $stmt = $conn->prepare("SELECT gender, paypal_email, location, dob FROM user_data WHERE user_id = (SELECT id FROM users WHERE unique_id = ?)");
    $stmt->bind_param("s", $unique_id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// Update user's profile data in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post data
    $gender = $_POST['gender'];
    $paypalEmail = $_POST['paypal_email'];
    $location = $_POST['location'];
    $dob = $_POST['dob'];
    $id = $user_info['id']; // Use the id fetched from the users table

    // Prepare SQL and bind parameters for updating the existing record
    $stmt = $conn->prepare("UPDATE user_data SET gender = ?, paypal_email = ?, location = ?, dob = ? WHERE user_id = ?");
    $stmt->bind_param("ssssi", $gender, $paypalEmail, $location, $dob, $id);

    if ($stmt->execute()) {
        echo '<script>alert("Profile updated!");</script>';
        // Reload the page to show the updated data
        echo '<script>window.location.href = "user_profile.php";</script>';
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
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
            height: 100%;
        }
    </style>
</head>

<body class="bg-gray-10 font-poppins">
    <?php include 'nav.php'; ?>

    <div class="container mx-auto mt-4 p-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">User Profile</h2>
            <?php if ($profile_completed): ?>
                <p>Name: <?php echo $user_info['fname'] . ' ' . $user_info['lname']; ?></p>
                <p>Email: <?php echo $user_info['email']; ?></p>
                <p>Phone: <?php echo $user_info['phone']; ?></p>
                <p>Gender: <?php echo $data['gender']; ?></p>
                <p>PayPal Email: <?php echo $data['paypal_email']; ?></p>
                <p>Location: <?php echo $data['location']; ?></p>
                <p>Date of Birth: <?php echo $data['dob']; ?></p>
                <hr class="my-6">
                <form action="user_profile.php" method="post" class="space-y-6 hidden">
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
                    <div class="flex justify-between">
                        <button id="closeFormBtn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Close
                            Form</button>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Complete
                            Profile</button>
                    </div>
                </form>
                <button id="editProfileBtn" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Edit
                    Profile</button>
            <?php else: ?>
                <p>Name: <?php echo $user_info['fname'] . ' ' . $user_info['lname']; ?></p>
                <p>Email: <?php echo $user_info['email']; ?></p>
                <p>Phone: <?php echo $user_info['phone']; ?></p>
                <hr class="my-6">
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
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Complete
                            Profile</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- <?php include 'footer.php'; ?> -->



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get the edit profile button and the form
            const editProfileBtn = document.getElementById('editProfileBtn');
            const form = document.querySelector('form[action="user_profile.php"]');

            // Add event listener to the edit profile button
            editProfileBtn.addEventListener('click', function () {
                // Show the form and hide the edit profile button
                form.style.display = 'block';
                editProfileBtn.style.display = 'none';
            });

            // Get the close form button
            const closeFormBtn = document.getElementById('closeFormBtn');

            // Add event listener to the close form button
            closeFormBtn.addEventListener('click', function () {
                // Hide the form and show the edit profile button
                form.style.display = 'none';
                editProfileBtn.style.display = 'block';
            });
        });

    </script>


</body>

</html>