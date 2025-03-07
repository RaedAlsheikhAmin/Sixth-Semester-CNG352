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
if (!$user_result) {
    die("Error executing query: " . $conn->error);
}
$user_row = $user_result->fetch_assoc();
$user_id = $user_row['UserID'];

// Fetch pending friend requests
$pending_sql = "SELECT Users.UserID, Users.UserName FROM Friendship 
                JOIN Users ON Users.UserID = Friendship.UserID1 
                WHERE Friendship.UserID2 = $user_id AND Friendship.Status = 'pending'";
$pending_result = $conn->query($pending_sql);
if (!$pending_result) {
    die("Error executing query: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $friend_id = $_POST['friend_id'];
    $action = $_POST['action'];

    if ($action == 'accept') {
        // Accept the friend request
        $update_sql = "UPDATE Friendship SET Status = 'accepted' 
                       WHERE UserID1 = $friend_id AND UserID2 = $user_id";
        if ($conn->query($update_sql) === TRUE) {
            $message = "Friend request accepted!";
        } else {
            $message = "Error: " . $conn->error;
        }
    } elseif ($action == 'decline') {
        // Decline the friend request
        $delete_sql = "DELETE FROM Friendship WHERE UserID1 = $friend_id AND UserID2 = $user_id";
        if ($conn->query($delete_sql) === TRUE) {
            $message = "Friend request declined!";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
    
    // Refresh the pending requests
    $pending_result = $conn->query($pending_sql);
    if (!$pending_result) {
        die("Error executing query: " . $conn->error);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Friend Requests - Gamebook</title>
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
    <div class="subheader">
        <nav>
            <a href="add_friend.php">Add Friend</a>
            <a href="delete_friend.php">Delete Friend</a>
            <a href="pending_friend.php">Pending Requests</a>
        </nav>
    </div>
    <main>
        <h2>Pending Friend Requests</h2>
        <table>
            <tr>
                <th>Username</th>
                <th>Action</th>
            </tr>
            <?php
            if ($pending_result->num_rows > 0) {
                while($row = $pending_result->fetch_assoc()) {
                    echo "<tr><td>" . $row["UserName"]. "</td><td>
                    <form method='post' action='pending_friend.php'>
                        <input type='hidden' name='friend_id' value='" . $row["UserID"] . "'>
                        <button class='accept-btn' type='submit' name='action' value='accept'>Accept</button>
                        <button class='decline-btn' type='submit' name='action' value='decline'>Decline</button>
                    </form>
                    </td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No pending requests</td></tr>";
            }
            ?>
        </table>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
