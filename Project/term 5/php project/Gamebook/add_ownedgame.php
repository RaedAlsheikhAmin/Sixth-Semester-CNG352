<?php
session_start();

include 'db.php'; // to check the connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the current user's ID
    $username = $_SESSION['username'];
    $user_sql = "SELECT UserID, Manage_LibraryID FROM Users WHERE UserName='$username'";
    $user_result = $conn->query($user_sql);
    if (!$user_result) {
        die("Error executing query: " . $conn->error);
    }
    $user_row = $user_result->fetch_assoc();
    $user_id = $user_row['UserID'];
    $LibraryID = $user_row['Manage_LibraryID'];

    // Get form data
    $name = $conn->real_escape_string($_POST['name']);
    $type = $conn->real_escape_string($_POST['type']);
    $genre = $conn->real_escape_string($_POST['genre']);
    $age_rating = (int)$_POST['age_rating'];
    $store = $conn->real_escape_string($_POST['store']);
    $description = $conn->real_escape_string($_POST['description']);
    $date_added = date('Y-m-d');
    
   
    // Insert the game into OwnedGame
    $sql = "INSERT INTO OwnedGame (Name, Typee, Genre, Age_rating, Store, Description, DateAdded, Stored_LibraryID) 
            VALUES ('$name', '$type', '$genre', $age_rating, '$store', '$description', '$date_added', $LibraryID)"; 

    if ($conn->query($sql) === TRUE) {
        // Insert into Owns table
        $owns_sql = "INSERT INTO Owns (userid, Name) VALUES ($user_id, '$name')";
        if ($conn->query($owns_sql) === TRUE) {
            $message = "New owned game added successfully!";
        } else {
            $message = "Error: " . $owns_sql . "<br>" . $conn->error;
        }
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
    <title>Add Owned Game - Gamebook</title>
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
        <h2>Add New Owned Game</h2>
        <form method="post" action="add_ownedgame.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required><br>
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" required><br>
            <label for="age_rating">Age Rating:</label>
            <select id="age_rating" name="age_rating" required>
                <option value="3">3</option>
                <option value="7">7</option>
                <option value="12">12</option>
                <option value="16">16</option>
                <option value="18">18</option>
            </select><br>
            <label for="store">Store:</label>
            <input type="text" id="store" name="store" required><br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>
            <input type="submit" value="Add Game">
        </form>
        <p><?php echo $message; ?></p>
    </main>
    <footer>
    <p>&copy; 2024 Gamebook by Raed A.A & Farnaz R.N</p>
    </footer>
</body>
</html>