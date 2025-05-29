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

    <style>

        /* for larger section */
        .add_Popup_Form{
        display: none;
        position: fixed;
        bottom: 25%;
        right: 35%;
        border: none;
        z-index: 9;
        width: 20%;
        height: 400px;
        padding: 10px;
        background-color: white;
        border-radius: 50px;
        font-family: Arial;
        }

        /* for form */
        /* .text_section{
        width: 45%;
        } */

        .add_Popup_Input {
        width: 95%;
        height: 25px;
        background-color:rgb(166, 0, 255);
        border-radius: 50px;
        border: none; 
        color: white;
        
        }

        .add_Popup_Label {
        color:rgb(166, 0, 255);
        font-weight: light;
        font-size: 10px;
        font-family: Arial;
        }

        .add_Popup_Form h2{
        color:rgb(0, 0, 0);
        font-weight: 100;
        font-size: 20px;
        font-family: Arial;
        }

        .addToyButton{
        background-color: rgba(0, 247, 255, 0.91);
        }

        .close_addPop{
        background-color: rgba(255, 0, 174, 0.91);
        }

        .addToyButton, .close_addPop{
        color: white;
        align-self: center;
        border-radius: 50px;
        width: 200px;
        border: none;
        margin-top: 10px;
        }

        .input_division{
        width:250px;
        }

        

    </style>

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
                        // $sql = "SELECT toyitem.name, toyitem.description, toyitem.item_id, toyimage.image_url, toyitem.brand, toyitem.category FROM toyitem INNER JOIN toyimage ON toy WHERE toyitem.item_id = toyimage.item_id";

                        $sql = "SELECT toyitem.name, toyitem.description, toyitem.item_id, toyimage.image_url, toyitem.brand, toyitem.category FROM toyitem INNER JOIN has ON toyitem.item_id = has.item_id INNER JOIN toyimage ON toyimage.image_id = has.image_id";

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
        <!-- <img src="images/add-circle-svgrepo-com.svg" id="add-item"> -->
        <button id="add-item" onclick = "openAddPopup()">add item</button>
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

    <!-- <form action = "/action.php" class="add_Popup_Form" id = "add_Popup_Form" method=post>
        <div class ="text_section">
            <h2>Add a New Toy</h2>

            <label for="Toy_Name" class = "add_Popup_Label">Toy Name</label>
            <input type = "text" class = "add_Popup_Input" name ="Toy_Name" required>

            <label for="Description" class = "add_Popup_Label">Description</label>
            <input type = "text" class = "add_Popup_Input" name ="Description" required>

            <label for="Price" class = "add_Popup_Label">Price</label>
            <input type = "text" class = "add_Popup_Input" name ="Price" required>

            <label for="Manufacturer" class = "add_Popup_Label">Manufacturer</label>
            <input type = "text" class = "add_Popup_Input" name ="Manufacturer" required>

            <label for="Category" class = "add_Popup_Label">Category</label>
            <input type = "text" class = "add_Popup_Input" name ="Category" required>

            <button type="submit" class="addToyButton">Add Toy</button>
            <button type="button" class="close_addPop" onclick="closeAddPopup()">Cancel</button>
        </div>
    </form> -->

    <form action = "add_toy.php" class="add_Popup_Form" id = "add_Popup_Form" method=post>
        <h2>Add a New Toy</h2>

        <label for="item_id" class = "add_Popup_Label">item id</label>
        <input type = "text" class = "add_Popup_Input" name ="item_id" required>

        <label for="Toy_Name" class = "add_Popup_Label">Toy Name</label>
        <input type = "text" class = "add_Popup_Input" name ="Toy_Name" required>

        <label for="Description" class = "add_Popup_Label">Description</label>
        <input type = "text" class = "add_Popup_Input" name ="Description" required>

        <label for="brand" class = "add_Popup_Label">Brand</label>
        <input type = "text" class = "add_Popup_Input" name ="brand" required>

        <label for="Category" class = "add_Popup_Label">Category</label>
        <input type = "text" class = "add_Popup_Input" name ="Category" required>

        <label for="Price" class = "add_Popup_Label">Price</label>
        <input type = "text" class = "add_Popup_Input" name ="Price" required>

        <!-- <label for="Manufacturer" class = "add_Popup_Label">Manufacturer</label>
        <input type = "text" class = "add_Popup_Input" name ="Manufacturer" required> -->

        <button type="submit" class="addToyButton">Add Toy</button>
        <button type="button" class="close_addPop" onclick="closeAddPopup()">Cancel</button>
    </form>
   

    <!-- <input type="text" class="imageUrl" placeholder="Enter image URL"> <img src="" alt="Image" class="preview"> <button>Delete</button> -->

    <script src="main.js"> </script>

</body>
</html>