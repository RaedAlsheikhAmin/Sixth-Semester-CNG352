<?php
session_start();

include 'db.php'; // to check the connection
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $friend_username = $_POST['friend_username'];

    // Fetch the current user's ID
    $username = $_SESSION['username'];
    $user_sql = "SELECT UserID FROM Users WHERE UserName='$username'";
    $user_result = $conn->query($user_sql);
    $user_row = $user_result->fetch_assoc();
    $user_id = $user_row['UserID'];

    // Fetch the friend's ID
    $friend_sql = "SELECT UserID FROM Users WHERE UserName='$friend_username'";
    $friend_result = $conn->query($friend_sql);

    if ($friend_result->num_rows > 0) {
        $friend_row = $friend_result->fetch_assoc();
        $friend_id = $friend_row['UserID'];

        // Check if they are already friends
        $check_sql = "SELECT * FROM Friendship WHERE (UserID1='$user_id' AND UserID2='$friend_id') OR (UserID1='$friend_id' AND UserID2='$user_id')";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows == 0) {
            // Add to Friendship table
            $sql = "INSERT INTO Friendship (UserID1, UserID2) VALUES ('$user_id', '$friend_id')";
            if ($conn->query($sql) === TRUE) {
                $message = "Friend added successfully!";
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $message = "You are already friends with this user.";
        }
    } else {
        $message = "User not found.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Friend - Gamebook</title>
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
            <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="logout.php">Logout (' . $_SESSION['username'] . ')</a>';
            } else {
                echo '<a href="login.php">Login</a>';
            }
            ?>
        </nav>
    </header>
    <div class="subheader">
        <nav>
        <a href="add_friend.php">Add Friend</a>
            <a href="delete_friend.php">Delete Friend</a>
            <a href="pending_friend.php">Pending Requests</a>
        </nav>
    </div>
    <main>
        <h2>Add New Friend</h2>
        <form method="post" action="add_friend.php">
            <label for="friend_username">Friend's Username:</label>
            <input type="text" id="friend_username" name="friend_username" required><br>
            <input type="submit" value="Add Friend">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
