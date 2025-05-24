<?php
include 'DBConnector.php';

$item_id = $_GET['item_id'];

//fetch toy data
$sql_toy = "SELECT * FROM toyItem WHERE item_id = '$item_id'";
$result_toy = $conn->query($sql_toy);
$row_toy = $result_toy->fetch_assoc();

//fetch images
$sql_images = "SELECT ti.image_id, ti.image_url FROM toyImage ti JOIN has h ON ti.image_id = h.image_id WHERE h.item_id = '$item_id'";
$result_images = $conn->query($sql_images);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //update "toyItem"
    $name = $_POST['name'];
    $description = $_POST['description'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $sql_update = "UPDATE toyItem SET name = '$name', description = '$description', brand = '$brand', category = '$category', price = '$price' WHERE item_id = '$item_id'";
    $conn->query($sql_update);

    //handle deleted images
    if (isset($_POST['delete_images'])) {
        foreach ($_POST['delete_images'] as $del_image_id) {
            //delete from "has"
            $sql_delete_has = "DELETE FROM has WHERE image_id = '$del_image_id' AND item_id = '$item_id'";
            $conn->query($sql_delete_has);
            //delete from "toyImage" if no other references
            $sql_check_has = "SELECT * FROM has WHERE image_id = '$del_image_id'";
            $result_check = $conn->query($sql_check_has);
            if ($result_check->num_rows == 0) {
                $sql_delete_image = "DELETE FROM toyImage WHERE image_id = '$del_image_id'";
                $conn->query($sql_delete_image);
            }
        }
    }

    //handle new images
    if (isset($_FILES['new_images']) && $_FILES['new_images']['error'][0] == 0) {
        $upload_dir = 'Uploads/';
        foreach ($_FILES['new_images']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['new_images']['name'][$key];
            $file_tmp = $_FILES['new_images']['tmp_name'][$key];
            $image_id = 'img_' . uniqid();
            $uploaded_file = $upload_dir . basename($file_name);
            if (move_uploaded_file($file_tmp, $uploaded_file)) {
                $sql_image = "INSERT INTO toyImage (image_id, image_url, description, is_primary_image) VALUES ('$image_id', '$uploaded_file', '', 0)";
                $conn->query($sql_image);
                $sql_has = "INSERT INTO has (item_id, image_id) VALUES ('$item_id', '$image_id')";
                $conn->query($sql_has);
            }
        }
    }

    echo "Toy updated successfully";
} else {
    //display form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Edit Toy - ToyDex</title>
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
                    <h2>Edit Toy</h2>
                    <form method="post" action="edit_toy.php?item_id=<?php echo $item_id; ?>" enctype="multipart/form-data" class="form-vertical">
                        <div class="form-group">
                            <label for="name">Toy Name:</label>
                            <input type="text" id="name" name="name" value="<?php echo $row_toy['name']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description"><?php echo $row_toy['description']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand:</label>
                            <input type="text" id="brand" name="brand" value="<?php echo $row_toy['brand']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category:</label>
                            <input type="text" id="category" name="category" value="<?php echo $row_toy['category']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" step="0.01" id="price" name="price" value="<?php echo $row_toy['price']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Current Images:</label>
                            <?php while ($row_image = $result_images->fetch_assoc()) { ?>
                                <img src="<?php echo $row_image['image_url']; ?>" width="100">
                                <input type="checkbox" name="delete_images[]" value="<?php echo $row_image['image_id']; ?>"> Delete<br>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="new_images">Add New Images:</label>
                            <input type="file" id="new_images" name="new_images[]" multiple>
                        </div>
                        <div class="form-group">
                            <button type="submit">Update Toy</button>
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