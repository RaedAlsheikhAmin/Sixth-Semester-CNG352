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

// Define query array
$queries = [
    'Installed Games' => "SELECT * FROM OwnedGame WHERE isInstalled = 1 AND Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = $user_id)",
    'Favorite Games' => "SELECT * FROM OwnedGame WHERE isFavorite = 1 AND Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = $user_id)",
    'Adventure Games' => "SELECT * FROM OwnedGame WHERE Genre = 'Adventure' AND Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = $user_id)",
    'Games with PEGI 12 Rating' => "SELECT * FROM OwnedGame WHERE Age_rating = 12 AND Stored_LibraryID = (SELECT Manage_LibraryID FROM Users WHERE UserID = $user_id)"
];

// Store results
$results = [];
foreach ($queries as $title => $query) {
    $results[$title] = $conn->query($query);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Queries - Gamebook</title>
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
    <main>
        <?php foreach ($results as $title => $result): ?>
            <h2><?php echo $title; ?></h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Genre</th>
                    <th>Age Rating</th>
                    <th>Store</th>
                    <th>Description</th>
                    <th>Hours Played</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["Name"]. "</td><td>" . $row["Typee"]. "</td><td>" . $row["Genre"]. "</td><td>" . $row["Age_rating"]. "</td><td>" . $row["Store"]. "</td><td>" . $row["Description"]. "</td><td>" . $row["HoursPlayed"]. "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No games found</td></tr>";
                }
                ?>
            </table>
        <?php endforeach; ?>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
