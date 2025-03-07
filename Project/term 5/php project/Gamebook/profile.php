<?php
session_start();

include 'db.php'; // to check the connection

$message = "";

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch the current user's data
$username = $_SESSION['username'];
$user_sql = "SELECT * FROM Users WHERE UserName='$username'";
$user_result = $conn->query($user_sql);
$user_data = $user_result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update user's data
    $update_sql = "UPDATE Users SET Fname='$fname', Lname='$lname', Email='$email', Password='$password' WHERE UserName='$username'";
    
    if ($conn->query($update_sql) === TRUE) {
        $message = "Profile updated successfully!";
        // Refresh user data
        $user_result = $conn->query($user_sql);
        $user_data = $user_result->fetch_assoc();
    } else {
        $message = "Error: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - Gamebook</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo-container">
            <h1>Gamebook</h1>
        </div>
        <nav>
            <a href="gamebook.php">Home</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="friends.php">Friends</a>
            <a href="queries.php">Statistics</a>
            <a href="feedback.php">Feedback</a>
            <a href="questions.php">Questions</a>
            <a href="profile.php">Profile</a>
            <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="logout.php">Logout (' . $_SESSION['username'] . ')</a>';
            } else {
                echo '<a href="login.php">Login</a>';
            }
            ?>
        </nav>
    </header>
    <main>
        <h2>Profile</h2>
        <form method="post" action="profile.php">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo $user_data['Fname']; ?>" required><br>
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo $user_data['Lname']; ?>" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user_data['Email']; ?>" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo $user_data['Password']; ?>" required><br>
            <input type="submit" value="Update Profile">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
