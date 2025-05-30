<?php
include 'DBConnector.php';

  $item_id = isset($_GET['item_id']) && ctype_digit($_GET['item_id'])
         ? (int) $_GET['item_id']
         : 0;
// if ($item_id === 0) {
//     die("Invalid toy ID.");
// }
    
    $item_id = (int) $_GET['item_id'];

    $sql = "SELECT toyitem.name, toyitem.description, toyitem.item_id, toyimage.image_url, toyitem.brand, toyitem.category 
                                FROM toyitem 
                                INNER JOIN has ON toyitem.item_id = has.item_id 
                                INNER JOIN toyimage ON toyimage.image_id = has.image_id";

    $stmt = $conn->prepare($sql);
    //$stmt->bind_param("i", $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // 3. Did we get a row?
    if ($result->num_rows === 0) {
        die("Toy not found.");
    }
    $row = $result->fetch_assoc();
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles.css">
            <title>View Item | ToyDex</title>
        </head>
        <body>
            <section class="home">
                <header>
                    <div class="main-header">
                        <h1 class="toydex-logo">TOYDEX</h1>
                        <nav>
                            <ul>
                                <li><a href="#"><img src="images/profile-circle-svgrepo-com.svg" alt="view"></a></li>                
                            </ul>
                        </nav>
                    </div>
                    <div class="divider"></div>
                </header>

            <div class="view-container">
                 <a href="home.php">← Back to List</a>
                <h1><?= htmlspecialchars($row['name']) ?></h1>
                <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">

                <div class="field">
                    <label>Description</label>
                    <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                </div>
                <div class="field">
                    <label>Brand</label>
                    <p><?= htmlspecialchars($row['brand']) ?></p>
                </div>
                <div class="field">
                    <label>Category</label>
                <p><?= htmlspecialchars($row['category']) ?></p>
            </div>

            </section>

            <footer>
                <div class="logo">
                    <img src="images/logo.png">
                    <h1>TOYDEX</h1>
                </div>
                <div class="labels">
                    <div class="label">
                        <h2>Community</h2>
                        <a href="#">Support</a>
                        <a href="#">Help</a>
                    </div>
                    <div class="label">
                        <h2>Overview</h2> 
                        <a href="#">Contact</a>
                        <a href="#">Terms of Use</a>
                        <a href="#">Privacy Policy</a>
                    </div>
                    <div class="label">
                        <h2>Follow Us</h2> 
                        <div class="icons">
                            <a href="#"><img src="images/facebook-svgrepo-com.svg"></a>
                            <a href="#"><img src="images/youtube-svgrepo-com.svg"></a>
                            <a href="#"><img src="images/discord-fill-svgrepo-com.svg"></a>
                        </div>
                    </div>
                </div>
            </footer>
        </body>
        </html>
        <?php
    

?>
