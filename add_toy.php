<?php
include 'DBConnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //get form data
    $item_id = $_POST['item_id'];
    $name = $_POST['Toy_Name'];
    $description = $_POST['Description'];
    $brand = $_POST['brand'];
    $category = $_POST['Category'];
    $price = $_POST['Price'];

    //insert into "toyItem"
    // $sql_toy = "INSERT INTO toyItem (item_id, name, description, brand, category, price) VALUES ('$item_id', '$name', '$description', '$brand', '$category', '$price')";
    $sql_toy = "INSERT INTO toyItem (item_id, name, description, brand, category) VALUES ('$item_id', '$name', '$description', '$brand', '$category')";
    if ($conn->query($sql_toy) === TRUE) {
        //handle image uploads
        if (isset($_FILES['images']) && $_FILES['images']['error'][0] == 0) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['images']['name'][$key];
                $file_tmp = $_FILES['images']['tmp_name'][$key];
                //generate unique image_id
                $image_id = 'img_' . uniqid();
                //move uploaded file
                $uploaded_file = $upload_dir . basename($file_name);
                if (move_uploaded_file($file_tmp, $uploaded_file)) {
                    //insert into "toyImage"
                    $sql_image = "INSERT INTO toyImage (image_id, image_url, description, is_primary_image) VALUES ('$image_id', '$uploaded_file', '', 0)";
                    if ($conn->query($sql_image) === TRUE) {
                        //insert into "has"
                        $sql_has = "INSERT INTO has (item_id, image_id) VALUES ('$item_id', '$image_id')";
                        $conn->query($sql_has);
                    } else {
                        echo "Error inserting image: " . $conn->error;
                    }
                } else {
                    echo "Failed to upload file";
                }
            }
        }
        echo "New toy added successfully";
    } else {
        echo "Error: " . $sql_toy . "<br>" . $conn->error;
    }
} else {
    //display form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Add New Toy - ToyDex</title>
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
                    <h2>Add New Toy</h2>
                    <form method="post" action="add_toy.php" enctype="multipart/form-data" class="form-vertical">
                        <div class="form-group">
                            <label for="item_id">Item ID:</label>
                            <input type="text" id="item_id" name="item_id" placeholder="e.g., item004" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Toy Name:</label>
                            <input type="text" id="name" name="name" placeholder="Toy Name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" placeholder="Describe the toy"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand:</label>
                            <input type="text" id="brand" name="brand" placeholder="Brand" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category:</label>
                            <input type="text" id="category" name="category" placeholder="Category" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" step="0.01" id="price" name="price" placeholder="Price" required>
                        </div>
                        <div class="form-group">
                            <label for="images">Images:</label>
                            <input type="file" id="images" name="images[]" multiple>
                        </div>
                        <div class="form-group">
                            <button type="submit">Add Toy</button>
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