<?php
session_start();

include "db.php"; // to check the connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $conn->real_escape_string($_POST['question']); // Sanitize user input to prevent sql injection

    $username = $_SESSION['username'];
    $user_sql = "SELECT UserID FROM Users WHERE UserName='$username'";
    $user_result = $conn->query($user_sql);
    if ($user_result && $user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $user_id = $user_row['UserID'];
        $QUESTIONID= random_int(0,1000000);//it needs to be fixed later on to read the QID from db and increament, or i can add auto increament to db table
        $sql = "INSERT INTO Question (QID,Textt, userid) VALUES ('$QUESTIONID','$question', '$user_id')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "New question added successfully!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Error fetching user ID.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Question - Gamebook</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gamebook</h1>
        <nav>
            <a href="gamebook.php">Home</a>
            <a href="wishlist.php">Wishlist</a>
            <a href="friends.php">Friends</a>
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
        <a href="add_question.php">Add Question</a>
         <a href="answer_question.php">Answer Question</a>
         <a href="show_questions_response.php"> Responses</a>
        </nav>
    </div>
    <main>
        <h2>Add New Question</h2>
        <form method="post" action="add_question.php">
            <label for="question">Question:</label>
            <textarea id="question" name="question" required></textarea><br>
            <input type="submit" value="Add Question">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
