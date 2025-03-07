<?php
session_start();

include "db.php";

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

// Fetch feedback
$sql = "SELECT * FROM Feedback WHERE userid = $user_id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback - Gamebook</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        
            <h1>Gamebook</h1>
        
        <nav>
        <a href="gamebook.php">Home</a>
         <a href="wishlist.php">Wishlist</a>
        <a href="friends.php">Friends</a>     
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
        <a href="add_feedback.php">Add Feedback</a>
        <a href="delete_feedback.php">Delete Feedback</a>
        </nav>
    </div>
    <main>
        <h2>User Feedback</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Comments</th>
                <th>Rating</th>
                <th>Game</th>
                <th>Timestamp</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["Title"]. "</td><td>" . $row["Comments"]. "</td><td>" . $row["Rating"]. "</td><td>" . $row["About_name"]. "</td><td>" . $row["time_stamp"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No feedback found</td></tr>";
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
