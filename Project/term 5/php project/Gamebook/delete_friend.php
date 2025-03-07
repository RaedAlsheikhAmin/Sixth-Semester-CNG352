<?php
session_start();

include 'db.php'; // to check the connection

$message = "";

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch the current user's ID
$username = $_SESSION['username'];
$user_sql = "SELECT UserID FROM Users WHERE UserName='$username'";
$user_result = $conn->query($user_sql);
$user_row = $user_result->fetch_assoc();
$user_id = $user_row['UserID'];

// Fetch friends
$friends_sql = "SELECT Users.UserID, Users.UserName FROM Friendship 
                JOIN Users ON (Friendship.UserID1 = Users.UserID OR Friendship.UserID2 = Users.UserID) 
                WHERE (Friendship.UserID1 = $user_id OR Friendship.UserID2 = $user_id)
                AND Users.UserID != $user_id";
$friends_result = $conn->query($friends_sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $friend_id = $_POST['friend_id'];

    // Delete from Friendship table
    $sql = "DELETE FROM Friendship WHERE (UserID1='$user_id' AND UserID2='$friend_id') OR (UserID1='$friend_id' AND UserID2='$user_id')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Friend deleted successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Friend - Gamebook</title>
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
        <h2>Delete Friend</h2>
        <form method="post" action="delete_friend.php">
            <label for="friend_id">Select Friend to Delete:</label>
            <select id="friend_id" name="friend_id" required>
                <?php
                if ($friends_result->num_rows > 0) {
                    while($row = $friends_result->fetch_assoc()) {
                        echo "<option value='" . $row["UserID"] . "'>" . $row["UserName"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No friends available</option>";
                }
                ?>
            </select><br>
            <input type="submit" value="Delete Friend">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
