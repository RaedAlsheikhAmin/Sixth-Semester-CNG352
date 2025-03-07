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
    $type = $_POST['type'];
    $genre = $_POST['genre'];
    $age_rating = $_POST['age_rating'];
    $store = $_POST['store'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $username = $_SESSION['username'];
    $user_sql = "SELECT UserID FROM Users WHERE UserName='$username'";
    $user_result = $conn->query($user_sql);
    if ($user_result && $user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $user_id = $user_row['UserID'];
    $sql = "INSERT INTO WishListGame (Name, Typee, Genre, Age_rating, Store, Description, Price) 
            VALUES ('$name', '$type', '$genre', '$age_rating', '$store', '$description', '$price')";
    
    if ($conn->query($sql) === TRUE) {
        $sql="INSERT INTO has_wishlist(userid, Name) Values ('$user_id','$name')";
        if($conn->query($sql)===TRUE)
            $message = "New wishlist game added successfully!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Wishlist Game - Gamebook</title>
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
        <h2>Add New Wishlist Game</h2>
        <form method="post" action="add_wishlist.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required><br>
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" required><br>
            <label for="age_rating">Age Rating:</label>
            <input type="number" id="age_rating" name="age_rating" required><br>
            <label for="store">Store:</label>
            <input type="text" id="store" name="store" required><br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required><br>
            <input type="submit" value="Add Game">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>
