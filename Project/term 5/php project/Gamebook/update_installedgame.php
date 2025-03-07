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

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the game name and new installed status
    $game_name = $conn->real_escape_string($_POST['game_name']);
    $is_installed = (int)$_POST['is_installed'];

    // Update the isInstalled status
    $sql = "UPDATE OwnedGame 
            SET isInstalled = $is_installed 
            WHERE Name = '$game_name' AND EXISTS (
                SELECT 1 
                FROM Owns 
                WHERE Owns.Name = '$game_name' AND Owns.userid = $user_id
            )";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Game installed status updated successfully!";
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
    <title>Update Installed - Gamebook</title>
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
            <a href="add_ownedgame.php">Add Owned Game</a>
            <a href="update_isfavorite.php">Update Favorite</a>
            <a href="update_installedgame.php">Update Installed</a>
        </nav>
    </div>
    <main>
        <h2>Update Installed Status</h2>
        <form method="post" action="update_installedgame.php">
            <label for="game_name">Game Name:</label>
            <input type="text" id="game_name" name="game_name" required><br>
            <label for="is_installed">Installed Status:</label>
            <select id="is_installed" name="is_installed" required>
                <option value="1">Installed</option>
                <option value="0">Not Installed</option>
            </select><br>
            <input type="submit" value="Update">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
