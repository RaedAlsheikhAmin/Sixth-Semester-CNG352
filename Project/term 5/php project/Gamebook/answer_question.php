<?php
session_start();

include "db.php";
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question_id = $_POST['question_id'];
    $response = $_POST['response'];

    $username = $_SESSION['username'];
    $user_sql = "SELECT UserID FROM Users WHERE UserName='$username'";
    $user_result = $conn->query($user_sql);
    $user_row = $user_result->fetch_assoc();
    $user_id = $user_row['UserID'];
    $ResponseID=rand($question_id,1000000);
    $sql = "INSERT INTO Response (ResponseID,Textt, userid, Belongs_QID) VALUES ('$ResponseID','$response', '$user_id', '$question_id')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Response added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch questions to answer
$sql = "SELECT * FROM Question";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Answer Question - Gamebook</title>
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
        <h2>Answer Questions</h2>
        <form method="post" action="answer_question.php">
            <label for="question_id">Select Question:</label>
            <select id="question_id" name="question_id" required>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["QID"]. "'>" . $row["Textt"]. "</option>";
                    }
                } else {
                    echo "<option value=''>No questions available</option>";
                }
                ?>
            </select><br>
            <label for="response">Response:</label>
            <textarea id="response" name="response" required></textarea><br>
            <input type="submit" value="Submit Response">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
