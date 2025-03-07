<?php
session_start();

include "db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE UserName = '$user' AND Password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $user;
        header("Location: gamebook.php");
    } else {
        $error = "Invalid username or password";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Gamebook</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gamebook</h1>
        <nav>
            <a href="gamebook.php">Home</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Create Account </a>
        </nav>
    </header>
    <main>
        <h2>Login</h2>
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Login">
        </form>
        <p style="color:red;"><?php echo $error; ?></p>
    </main>
    <footer>
        <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
