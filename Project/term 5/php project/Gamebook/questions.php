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

// Fetch questions
$sql = "SELECT * FROM Question WHERE userid = $user_id";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Questions - Gamebook</title>
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
        <h2>User Questions</h2>
        <table>
            <tr>
                <th>Question ID</th>
                <th>Question</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["QID"]. "</td><td>" . $row["Textt"]. "</td></tr>";
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
