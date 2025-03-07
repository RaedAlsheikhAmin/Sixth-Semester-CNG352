<?php
session_start();

include 'db.php';// to check the connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch user ID
$username = $_SESSION['username'];
$user_sql = "SELECT UserID FROM Users WHERE UserName='$username'";
$user_result = $conn->query($user_sql);
$user_row = $user_result->fetch_assoc();
$user_id = $user_row['UserID'];

// Fetch friends
$sql = "SELECT Users.UserID, Users.Fname, Users.Lname 
        FROM Friendship 
        JOIN Users ON (Friendship.UserID1 = Users.UserID OR Friendship.UserID2 = Users.UserID) 
        WHERE (Friendship.UserID1 = $user_id OR Friendship.UserID2 = $user_id)
        AND Users.UserID != $user_id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Friends - Gamebook</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
            <h1>Gamebook</h1>
        
        <nav>
        <a href="gamebook.php">Home</a>
    <a href="wishlist.php">Wishlist</a>
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
        <h2>Friends List</h2>
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["Fname"]. "</td><td>" . $row["Lname"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No friends found</td></tr>";
            }
            ?>
        </table>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
