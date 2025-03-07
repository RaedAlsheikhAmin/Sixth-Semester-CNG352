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

// Fetch wishlist games for the current user
$sql = "SELECT WishListGame.Name, WishListGame.Typee, WishListGame.Genre, WishListGame.Age_rating, WishListGame.Store, WishListGame.Description, WishListGame.Price
        FROM WishListGame
        JOIN Has_wishlist ON Has_wishlist.Name = WishListGame.Name
        WHERE Has_wishlist.userid = $user_id";
$result = $conn->query($sql);
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Wishlist - Gamebook</title>
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
            <a href="add_wishlist.php">Add Wishlist Game</a>
            <a href="update_wishlist.php">Update Wishlist Game</a>
            <a href="delete_wishlist.php">Delete Wishlist Game</a>
        </nav>
    </div>
    <main>
        <h2>Wishlist Games</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Genre</th>
                <th>Age Rating</th>
                <th>Store</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["Name"]. "</td>
                            <td>" . $row["Typee"]. "</td>
                            <td>" . $row["Genre"]. "</td>
                            <td>" . $row["Age_rating"]. "</td>
                            <td>" . $row["Store"]. "</td>
                            <td>" . $row["Description"]. "</td>
                            <td>$" . $row["Price"]. "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No games found</td></tr>";
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
