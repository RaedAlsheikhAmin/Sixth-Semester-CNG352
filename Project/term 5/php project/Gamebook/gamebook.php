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

// Fetch owned games for the current user
$sql = "SELECT OwnedGame.Name, OwnedGame.Typee, OwnedGame.Genre, OwnedGame.Age_rating, OwnedGame.Store, OwnedGame.Description 
        FROM OwnedGame 
        JOIN Owns ON Owns.Name = OwnedGame.Name 
        WHERE Owns.userid = $user_id";
$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gamebook</title>
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
        <h2>Owned Games</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Genre</th>
                <th>Age Rating</th>
                <th>Store</th>
                <th>Description</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["Name"]. "</td><td>" . $row["Typee"]. "</td><td>" . $row["Genre"]. "</td><td>" . $row["Age_rating"]. "</td><td>" . $row["Store"]. "</td><td>" . $row["Description"]. "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No games found</td></tr>";
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
