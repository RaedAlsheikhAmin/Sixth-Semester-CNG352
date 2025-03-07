<?php
session_start();

include 'db.php'; // to check the connection

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

// Fetch questions and their responses
$sql = "SELECT q.QID, q.Textt AS Question, r.Textt AS Response 
        FROM Question q 
        LEFT JOIN Response r ON q.QID = r.Belongs_QID 
        ORDER BY q.QID";
$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Questions and Responses - Gamebook</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gamebook</h1>
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
        <a href="add_question.php">Add Question</a>
         <a href="answer_question.php">Answer Question</a>
         <a href="show_questions_response.php"> Responses</a>
        </nav>
    </div>
    <main>
        <h2>Questions and Responses</h2>
        <table>
            <tr>
                <th>Question</th>
                <th>Response</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . htmlspecialchars($row["Question"]) . "</td><td>" . htmlspecialchars($row["Response"]) . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No questions found</td></tr>";
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
