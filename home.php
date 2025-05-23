<?php
    include 'DBConnector.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>ToyDex</title>
</head>
<body>
    <section class="home">
        <header>
            <div class="main-header">
                <h1 class="toydex-logo">TOYDEX</h1>
                <nav>
                    <ul>
                        <!-- <li><a href="#"><img src="images/view-grid-svgrepo-com.svg" alt="view"></a></li>                    
                        <li><a href="#"><img src="images/inventory-svgrepo-com.svg" alt="view"></a></li>                     -->
                        <li><a href="#"><img src="images/profile-circle-svgrepo-com.svg" alt="view"></a></li>                
                    </ul>
                </nav>
            </div>
            <div class="divider"></div>
        </header> 
        
        <section class="filter-item-container">
            <!--filters-->
            <div class="filter-container">
                <h2>Filter:</h2>
                <form action="" method="post" class="form-vertical">
                    <div class="form-group">
                        <label>Toy Name:</label>
                        <input type="text" name="toy-name" placeholder="Toy Name">
                    </div>
                    <div class="form-group">
                        <label>Category:</label>
                        <select class="expand" name="category" placeholder="Category">
                            <option value="" disabled="">--Select Category--</option>
                            <!--example option-->
                            <option value="1">None</option>
                            <option value="2">Hotdog</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Price Range:</label>
                        <div class="price-range">
                            <input type="number" name="min-price" placeholder="Min Price">
                            <span>to</span>
                            <input type="number" name="max-price" placeholder="Max Price">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Manufacturer:</label>
                        <input type="text" name="manufacturer" placeholder="Manufacturer">
                    </div>
                    <div class="form-group">
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>
            <!--items-->
            <div class="items-container">
                <!-- hardcoded items -->
                <ul class="items-list">
                    <!-- <li id="item1">
                        <div class="li-content">
                            <div class="feedback">
                                <div class="feedback-item"><img src="images/heart-svgrepo-com.svg" class="heart-icon"><span>1.5k</span></div>
                                <div class="feedback-item"><img src="images/comment-alt-lines-svgrepo-com.svg" class="comment-icon"><span>1.5k</span></div> 
                            </div>
                            <div class="main-img">
                                <img src="images/Teddy-Bear-Transparent-PNG-3328812078 1.png">
                            </div>
                            <div class="bubble-text">
                                <h2>Toy Name</h2>
                                <h4>Category</h4>
                                <p>Price</p>
                            </div>
                        </div>
                    </li> -->
                    <?php
                        $sql = "SELECT toyitem.name, toyitem.description, toyitem.item_id, toyimage.image_url, toyitem.brand, toyitem.category FROM toyitem, toyimage WHERE toyitem.item_id = toyimage.item_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<li id='".$row['item_id']."'>
                                    <div class='li-content'>
                                        <div class='feedback'>
                                            <div class='feedback-item'><img src='images/heart-svgrepo-com.svg' class='heart-icon'><span>1.5k</span></div>
                                            <div class='feedback-item'><img src='images/comment-alt-lines-svgrepo-com.svg' class='comment-icon'><span>1.5k</span></div> 
                                        </div>
                                        <div class='main-img'>
                                            <img src='".$row['image_url']."'>
                                        </div>
                                        <div class='bubble-text'>
                                            <h2>".$row['name']."</h2>
                                            <h4>".$row['category']."</h4>
                                            <p>".$row['brand']."</p>
                                        </div>
                                    </div>
                                </li>";
                            }
                        }
                        else {
                            echo "0 results";
                        }

                        $conn->close();
                    ?>
                </ul>
            </div>
        </section>
    <div class="add">
        <img src="images/add-circle-svgrepo-com.svg" id="add-item">
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