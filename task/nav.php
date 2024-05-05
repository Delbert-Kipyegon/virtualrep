<?php
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
?>

<!-- Responsive Navbar -->
<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <!-- Logo and Welcome Message -->
        <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Welcome,
                <?php echo $first_name; ?></span>
        </a>
        <!-- Mobile menu button -->
        <button onclick="toggleMenu()" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text:white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
                </li>
                <li>
                    <a href="user_profile.php"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text:white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Profile</a>
                </li>
                <li>
                    <a href="../php/logout.php"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text:white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    function toggleMenu() {
        const navbar = document.getElementById('navbar');
        navbar.classList.toggle('hidden');
    }
</script>