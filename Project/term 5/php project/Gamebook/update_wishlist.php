<?php
session_start();

include 'db.php';// to check the connection
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];

    $sql = "UPDATE WishListGame SET Price='$price' WHERE Name='$name'";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Wishlist game updated successfully!";
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
    <title>Update Wishlist Game - Gamebook</title>
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
        <a href="add_wishlist.php">Add Wishlist Game</a>
            <a href="update_wishlist.php">Update Wishlist Game</a>
            <a href="delete_wishlist.php">Delete Wishlist Game</a>
        </nav>
    </div>
    <main>
        <h2>Update Wishlist Game</h2>
        <form method="post" action="update_wishlist.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="price">New Price:</label>
            <input type="number" id="price" name="price" required><br>
            <input type="submit" value="Update Game">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
