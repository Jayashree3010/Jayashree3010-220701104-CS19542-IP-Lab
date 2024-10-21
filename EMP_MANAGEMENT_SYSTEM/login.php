<?php
session_start(); // Start the session

// Static credentials
define('STATIC_USERNAME', 'Jayashree'); // Change 'your_username' to your desired username
define('STATIC_PASSWORD', 'jass2005'); // Change 'your_password' to your desired password

$error_message = ''; // Initialize the error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify the credentials
    if ($username === STATIC_USERNAME && $password === STATIC_PASSWORD) {
        // Password is correct, log the user in
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true; // Set logged in session variable
        header("Location: index.php");
        exit;
    } else {
        // Invalid username or password
        $error_message = 'Invalid username or password. Please try again.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Custom CSS -->
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden; /* Prevent scrolling */
            background: url('image1.jpg') no-repeat center center/cover; /* Default background */
            animation: slide 40s infinite; /* Animation for the slideshow */
        }

        @keyframes slide {
            0% { background-image: url('jaya'); }
            25% { background-image: url('jaya1'); }
            50% { background-image: url('jaya2'); }
            75% { background-image: url('jaya3'); }
            100% { background-image: url('jaya4'); }
        }

        .card {
            position: relative; /* Relative positioning for the card */
            z-index: 1; /* Ensure card is above the slideshow */
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent background */
            border-radius: 8px; /* Optional: round corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Optional: add shadow */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Welcome Back!</h4>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username" required placeholder="Enter Username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required placeholder="Enter Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                            <?php if ($error_message) echo "<p class='text-danger'>$error_message</p>"; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
