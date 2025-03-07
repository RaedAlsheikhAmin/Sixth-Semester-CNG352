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

// Fetch wishlist games
$wishlist_sql = "SELECT WishListGame.Name, WishListGame.Typee, WishListGame.Genre, WishListGame.Age_rating, WishListGame.Store, WishListGame.Description, WishListGame.Price 
                 FROM WishListGame 
                 JOIN Has_wishlist ON Has_wishlist.Name = WishListGame.Name 
                 WHERE Has_wishlist.userid = $user_id";
$wishlist_result = $conn->query($wishlist_sql);
if (!$wishlist_result) {
    die("Error executing query: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $game_name = $_POST['game_name'];

    // Delete the wishlist game
    $delete_sql = "DELETE FROM Has_wishlist WHERE Name = '$game_name' AND userid = $user_id";
    if ($conn->query($delete_sql) === TRUE) {
        $message = "Wishlist game deleted successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }

    // Refresh the wishlist games
    $wishlist_result = $conn->query($wishlist_sql);
    if (!$wishlist_result) {
        die("Error executing query: " . $conn->error);
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Wishlist Game - Gamebook</title>
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
        <h2>Delete Wishlist Game</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Genre</th>
                <th>Age Rating</th>
                <th>Store</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php
            if ($wishlist_result->num_rows > 0) {
                while($row = $wishlist_result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["Name"]. "</td>
                            <td>" . $row["Typee"]. "</td>
                            <td>" . $row["Genre"]. "</td>
                            <td>" . $row["Age_rating"]. "</td>
                            <td>" . $row["Store"]. "</td>
                            <td>" . $row["Description"]. "</td>
                            <td>$" . $row["Price"]. "</td>
                            <td>
                                <form method='post' action='delete_wishlist.php'>
                                    <input type='hidden' name='game_name' value='" . $row["Name"] . "'>
                                    <button class='delete-btn' type='submit'>Delete</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No wishlist games found</td></tr>";
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
