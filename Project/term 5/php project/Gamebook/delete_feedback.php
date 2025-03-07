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

// Fetch feedback entries
$feedback_sql = "SELECT Feedback.FeedbackID, Feedback.Title, Feedback.Comments, Feedback.Rating, Feedback.About_name, Feedback.time_stamp 
                 FROM Feedback 
                 WHERE Feedback.userid = $user_id";
$feedback_result = $conn->query($feedback_sql);
if (!$feedback_result) {
    die("Error executing query: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback_id = $_POST['feedback_id'];

    // Delete the feedback entry
    $delete_sql = "DELETE FROM Feedback WHERE FeedbackID = $feedback_id AND userid = $user_id";
    if ($conn->query($delete_sql) === TRUE) {
        $message = "Feedback deleted successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }

    // Refresh the feedback entries
    $feedback_result = $conn->query($feedback_sql);
    if (!$feedback_result) {
        die("Error executing query: " . $conn->error);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Feedback - Gamebook</title>
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
        <a href="add_feedback.php">Add Feedback</a>
        <a href="delete_feedback.php">Delete Feedback</a>
        </nav>
    </div>
    <main>
        <h2>Delete Feedback</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Comments</th>
                <th>Rating</th>
                <th>Game</th>
                <th>Timestamp</th>
                <th>Action</th>
            </tr>
            <?php
            if ($feedback_result->num_rows > 0) {
                while($row = $feedback_result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["Title"]. "</td>
                            <td>" . $row["Comments"]. "</td>
                            <td>" . $row["Rating"]. "</td>
                            <td>" . $row["About_name"]. "</td>
                            <td>" . $row["time_stamp"]. "</td>
                            <td>
                                <form method='post' action='delete_feedback.php'>
                                    <input type='hidden' name='feedback_id' value='" . $row["FeedbackID"] . "'>
                                    <button class='delete-btn' type='submit'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No feedback found</td></tr>";
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
