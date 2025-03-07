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
    $title = $_POST['title'];
    $comments = $_POST['comments'];
    $rating = $_POST['rating'];
    $game = $_POST['game'];

    $username = $_SESSION['username'];
    $user_sql = "SELECT UserID FROM Users WHERE UserName='$username'";
    $user_result = $conn->query($user_sql);
    $user_row = $user_result->fetch_assoc();
    $user_id = $user_row['UserID'];

    $sql = "INSERT INTO Feedback (Title, Comments, Rating, userid, About_name, time_stamp) 
            VALUES ('$title', '$comments', '$rating', '$user_id', '$game', NOW())";
    
    if ($conn->query($sql) === TRUE) {
        $message = "New feedback added successfully!";
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
    <title>Add Feedback - Gamebook</title>
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
    <a href="feedback.php">Feedback</a>
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
        <h2>Add New Feedback</h2>
        <form method="post" action="add_feedback.php">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br>
            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" required></textarea><br>
            <label for="rating">Rating (0-5):</label>
            <input type="number" id="rating" name="rating" min="0" max="5" required><br>
            <label for="game">Game:</label>
            <input type="text" id="game" name="game" required><br>
            <input type="submit" value="Add Feedback">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
