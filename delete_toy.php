<?php
include 'DBConnector.php';

$item_id = $_GET['item_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //delete from related tables
    $conn->query("DELETE FROM likedBy WHERE item_id = '$item_id'");
    $conn->query("DELETE FROM ownedBy WHERE item_id = '$item_id'");
    $conn->query("DELETE FROM commentedBy WHERE item_id = '$item_id'");
    $conn->query("DELETE FROM purchasedThrough WHERE item_id = '$item_id'");
    $conn->query("DELETE FROM manufactures WHERE item_id = '$item_id'");
    $conn->query("DELETE FROM has WHERE item_id = '$item_id'");
    //delete from "toyItem"
    $sql_delete_toyitem = "DELETE FROM toyItem WHERE item_id = '$item_id'";
    if ($conn->query($sql_delete_toyitem) === TRUE) {
        echo "Toy deleted successfully";
    } else {
        echo "Error deleting toy: " . $conn->error;
    }
} else {
    //display confirmation
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Delete Toy - ToyDex</title>
    </head>
    <body>
        <section class="home">
            <header>
                <div class="main-header">
                    <h1 class="toydex-logo">TOYDEX</h1>
                    <nav>
                        <ul>
                            <li><a href="home.php"><img src="images/view-grid-svgrepo-com.svg" alt="home"></a></li>
                            <li><a href="#"><img src="images/inventory-svgrepo-com.svg" alt="inventory"></a></li>
                            <li><a href="#"><img src="images/profile-circle-svgrepo-com.svg" alt="profile"></a></li>
                        </ul>
                    </nav>
                </div>
                <div class="divider"></div>
            </header>
            <section class="filter-item-container">
                <div class="filter-container">
                    <h2>Delete Toy</h2>
                    <p>Are you sure you want to delete toy with ID: <?php echo $item_id; ?>?</p>
                    <form method="post" action="delete_toy.php?item_id=<?php echo $item_id; ?>" class="form-vertical">
                        <div class="form-group">
                            <button type="submit">Yes, Delete</button>
                            <button type="button" onclick="window.location.href='home.php'">Cancel</button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </body>
    </html>
    <?php
}

$conn->close();
?>