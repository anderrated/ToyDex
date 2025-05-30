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
                        <li><a href="#"><img src="images/profile-circle-svgrepo-com.svg" alt="profile"></a></li>                
                    </ul>
                </nav>
            </div>
            <div class="divider"></div>
        </header>
        
        <section class="filter-item-container">
            <!--filters-->
            <div class="filter-container">
                <h2>Filter:</h2>
                <form action="" method="get" class="form-vertical">
                    <div class="form-group">
                        <label>Toy Name:</label>
                        <input type="text" name="toy-name" placeholder="Toy Name" value="<?php echo isset($_GET['toy-name']) ? htmlspecialchars($_GET['toy-name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Category:</label>
                        <select class="expand" name="category" placeholder="Category">
                            <option value="">--Select Category--</option>
                            <option value="None" <?php echo (isset($_GET['category']) && $_GET['category'] == 'None') ? 'selected' : ''; ?>>None</option>
                            <option value="Hotdog" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Hotdog') ? 'selected' : ''; ?>>Hotdog</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Manufacturer:</label>
                        <input type="text" name="manufacturer" placeholder="Manufacturer" value="<?php echo isset($_GET['manufacturer']) ? htmlspecialchars($_GET['manufacturer']) : ''; ?>">
                    </div>
                    <div class="search-container">
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>

            <!--items-->
            <div class="items-container">
                <ul class="items-list">
                    <?php
                    // Only perform search if at least one filter has a value
                    if (isset($_GET['toy-name']) || isset($_GET['category']) || isset($_GET['manufacturer'])) {
                        // Build the base SQL query
                        $sql = "SELECT toyitem.name, toyitem.description, toyitem.item_id, toyimage.image_url, toyitem.brand, toyitem.category 
                                FROM toyitem 
                                INNER JOIN has ON toyitem.item_id = has.item_id 
                                INNER JOIN toyimage ON toyimage.image_id = has.image_id
                                WHERE 1=1";
                        
                        // Add conditions based on filters
                        $conditions = [];
                        $params = [];
                        $types = '';
                        
                        if (!empty($_GET['toy-name'])) {
                            $sql .= " AND toyitem.name LIKE ?";
                            $params[] = '%' . $_GET['toy-name'] . '%';
                            $types .= 's';
                        }
                        
                        if (!empty($_GET['category'])) {
                            $sql .= " AND toyitem.category = ?";
                            $params[] = $_GET['category'];
                            $types .= 's';
                        }
                        
                        if (!empty($_GET['manufacturer'])) {
                            $sql .= " AND toyitem.brand LIKE ?";
                            $params[] = '%' . $_GET['manufacturer'] . '%';
                            $types .= 's';
                        }
                        
                        // Prepare and execute the statement
                        $stmt = $conn->prepare($sql);
                        
                        if (!empty($params)) {
                            $stmt->bind_param($types, ...$params);
                        }
                        
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<li id='".$row['item_id']."'>
                                        <div class='li-content'>
                                            <button onclick=\"if(confirm('Are you sure you want to delete this toy?')){document.getElementById('deleteForm_".$row['item_id']."').submit();}\" class='delete-btn'>Delete</button>
                                            <form id='deleteForm_".$row['item_id']."' action='delete_toy.php' method='post' style='display: none;'>
                                                <input type='hidden' name='item_id' value='" . $row['item_id'] . "'>
                                            </form>
                                            <div class='main-img'>
                                                <img src='".$row['image_url']."'>
                                            </div>
                                            <div class='bubble-text'>
                                                <h2>".htmlspecialchars($row['name'])."</h2>
                                                <h4>".htmlspecialchars($row['category'])."</h4>
                                                <p>".htmlspecialchars($row['brand'])."</p>
                                            </div>
                                        </div>
                                    </li>";
                            }
                        } else {
                            echo "<p class='no-results'>No item(s) found matching your criteria.</p>";
                        }
                        
                        $stmt->close();
                    } else {
                        // Display all items when no filters are applied
                        $sql = "SELECT toyitem.name, toyitem.description, toyitem.item_id, toyimage.image_url, toyitem.brand, toyitem.category 
                                FROM toyitem 
                                INNER JOIN has ON toyitem.item_id = has.item_id 
                                INNER JOIN toyimage ON toyimage.image_id = has.image_id";
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<li id='".$row['item_id']."'>
                                        <div class='li-content'>
                                            <button onclick=\"if(confirm('Are you sure you want to delete this toy?')){document.getElementById('deleteForm_".$row['item_id']."').submit();}\" class='delete-btn'>Delete</button>
                                            <form id='deleteForm_".$row['item_id']."' action='delete_toy.php' method='post' style='display: none;'>
                                                <input type='hidden' name='item_id' value='" . $row['item_id'] . "'>
                                            </form>
                                            <div class='main-img'>
                                                <img src='".$row['image_url']."'>
                                            </div>
                                            <div class='bubble-text'>
                                                <h2>".htmlspecialchars($row['name'])."</h2>
                                                <h4>".htmlspecialchars($row['category'])."</h4>
                                                <p>".htmlspecialchars($row['brand'])."</p>
                                            </div>
                                        </div>
                                    </li>";
                            }
                        } else {
                            echo "<p class='no-results'>No items available.</p>";
                        }
                    }
                    
                    $conn->close();
                    ?>
                </ul>
            </div>
        </section>
    <div class="add">
        <button id="add-item" onclick="openAddPopup()"><img src = "images/add-circle-svgrepo-com.svg"></button>
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

    <!-- Add Toy Popup Form (remains the same) -->
    <form action="addToy.php" class="add_Popup_Form" id="add_Popup_Form" method="post">
        <!-- Form fields remain the same -->
    </form>

    <script src="main.js"></script>
</body>
</html>