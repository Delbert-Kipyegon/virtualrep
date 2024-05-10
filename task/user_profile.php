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
    $stmt = $conn->prepare("SELECT gender, paypal_email, country, dob, id_number, address FROM user_data WHERE user_id = (SELECT id FROM users WHERE unique_id = ?)");
    $stmt->bind_param("s", $unique_id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}
// Check if user profile status is 'null', 'pending', 'approved', or 'rejected'
if ($profile_completed && isset($data['status'])) {
    $profileStatus = $data['status'];
} else {
    $profileStatus = 'null';
}

// Update user's profile data in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post data
    $gender = $_POST['gender'];
    $paypalEmail = $_POST['paypal_email'];
    $country = $_POST['country'];
    $dob = $_POST['dob'];
    $idNumber = $_POST['id'];
    $address = $_POST['address'];
    $id = $user_info['id']; // Use the id fetched from the users table

    // Set initial status as 'pending' for new profile submissions
    $status = 'pending';

    // Handle uploaded photo
    $photoName = $_FILES['photo']['name'];
    $photoTmp = $_FILES['photo']['tmp_name'];
    $photoError = $_FILES['photo']['error'];
    $photoType = $_FILES['photo']['type'];

    // Check if a photo was uploaded
    if ($photoError === 0) {
        // Get the file extension
        $photoExt = strtolower(pathinfo($photoName, PATHINFO_EXTENSION));
        // Allow certain file formats
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf');
        if (in_array($photoExt, $allowedExtensions)) {
            // Define the upload directory
            $uploadDirectory = 'uploads\\';

            // Check if the directory exists, create it if not
            if (!file_exists($uploadDirectory)) {
                if (!mkdir($uploadDirectory, 0755, true)) {
                    die("Failed to create upload directory.");
                }
            }

            // Store the photo in the directory
            $photoNewName = uniqid('', true) . '.' . $photoExt;
            $photoDestination = $uploadDirectory . $photoNewName;
            if (move_uploaded_file($photoTmp, $photoDestination)) {
                // echo "File uploaded successfully!";
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file format. Allowed formats: jpg, jpeg, png, pdf";
        }
    } else {
        echo "Error: " . $photoError;
    }


    // if there is no data in user_data table for the user, insert new record
    $stmt = null;

    if (!$profile_completed) {
        // Insert data with status
        $stmt = $conn->prepare("INSERT INTO user_data (user_id, gender, paypal_email, country, dob, photo, id_number, address, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssss", $id, $gender, $paypalEmail, $country, $dob, $photoDestination, $idNumber, $address, $status);
    } else {
        // Update data
        $stmt = $conn->prepare("UPDATE user_data SET gender = ?, paypal_email = ?, country = ?, dob = ?, photo = ?, id_number = ?, address = ?, status = ? WHERE user_id = ?");
        $stmt->bind_param("ssssssssi", $gender, $paypalEmail, $country, $dob, $photoDestination, $idNumber, $address, $status, $id);
    }

    if ($stmt->execute()) {
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
        <div class="mb-8">
            <a href="./user_dashboard.php"
                class="btn-back bg-purple-500 hover:bg-purple-700 text-white hover:shadow-lg py-2 px-4 mb-4 rounded ">Back
                to
                Dashboard</a>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">User Profile</h2>
            <?php if ($profile_completed): ?>
                <p>Name: <?php echo $user_info['fname'] . ' ' . $user_info['lname']; ?></p>
                <p>Email: <?php echo $user_info['email']; ?></p>
                <p>Phone: <?php echo $user_info['phone']; ?></p>
                <p>Gender: <?php echo $data['gender']; ?></p>
                <p>PayPal Email: <?php echo $data['paypal_email']; ?></p>
                <p>Country: <?php echo $data['country']; ?></p>
                <p>Date of Birth: <?php echo $data['dob']; ?></p>

                <?php if (!empty($data['photo'])): ?>
                    <img src="<?php echo $data['photo']; ?>" alt="User Photo" style="max-width: 200px;">
                <?php endif; ?>
                <hr class="my-6">
                <form action="user_profile.php" method="post" enctype="multipart/form-data" class="space-y-6 hidden">
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
                        <input type="email" name="

paypal_email" id="paypal_email" required class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-600">Country</label>
                        <input type="text" name="country" id="country" required
                            class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-600">Date of Birth</label>
                        <input type="date" name="dob" id="dob" required
                            class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="id" class="block text-sm font-medium text-gray-600">ID Number</label>
                        <input type="text" name="id" id="id" required
                            class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-600">Driving Licence/ID photo or any
                            other official document photo</label>
                        <input type="file" name="photo" id="photo" accept="image/*, application/pdf">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-600">Address</label>
                        <input type="text" name="address" id="address" required
                            class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex justify-between">
                        <button id="closeFormBtn"
                            class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">Close
                            Form</button>

                        <button type="submit"
                            class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">Complete
                            Profile</button>
                    </div>
                </form>
                <button id="editProfileBtn" class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">Edit
                    Profile</button>
            <?php else: ?>
                <p>Name: <?php echo $user_info['fname'] . ' ' . $user_info['lname']; ?></p>
                <p>Email: <?php echo $user_info['email']; ?></p>
                <p>Phone: <?php echo $user_info['phone']; ?></p>
                <hr class="my-6">
                <form action="user_profile.php" method="post" enctype="multipart/form-data" class="space-y-6">
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
                        <label for="country" class="block text-sm font-medium text-gray-600">Country</label>
                        <input type="text" name="country" id="country" required
                            class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-600">Date of Birth</label>
                        <input type="date" name="dob" id="dob" required
                            class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="id" class="block text-sm font-medium text-gray-600">ID Number</label>
                        <input type="text" name="id" id="id" required
                            class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-600">Driving Licence/ID photo or any
                            other official document photo</label>
                        <input type="file" name="photo" id="photo" accept="image/*, application/pdf">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-600">Address</label>
                        <input type="text" name="address" id="address" required
                            class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-700">Complete
                            Profile</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

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