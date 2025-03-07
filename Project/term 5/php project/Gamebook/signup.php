<?php
session_start();

include 'db.php'; // to check the connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $library_id = random_int(0,10000); 

    // Check if username or email already exists
    $check_sql = "SELECT * FROM Users WHERE UserName='$username' OR Email='$email'";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        $message = "Username or Email already exists";
    } else {
        // Insert new user into Users table
        $sql = "INSERT INTO Users (Fname, Lname, UserName, Email, Password, DOB, Manage_LibraryID) 
                VALUES ('$fname', '$lname', '$username', '$email', '$password', '$dob', $library_id)";
        
        if ($conn->query($sql) === TRUE) {
            $message = "Account created successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Gamebook</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gamebook</h1>
        <nav>
            <a href="gamebook.php">Home</a>
            <a href="login.php">Login</a>
        </nav>
    </header>
    <main>
        <h2>Create an Account</h2>
        <form method="post" action="signup.php">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" required><br>
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" required><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required><br>
            <input type="submit" value="Sign Up">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
