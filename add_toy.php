<?php
include 'DBConnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Start a transaction for data consistency
    $conn->begin_transaction();

    try {
        // Get form data for toyItem
        $name = $_POST['Toy_Name'];
        $description = $_POST['Description'];
        $brand = $_POST['brand'];
        $category = $_POST['Category'];

        // Get form data for manufacturer
        $manufacturer_name = $_POST['Manufacturer_Name'];
        $manufacturer_location = $_POST['manufacturer_location'];
        $batch_num = $_POST['batch_num'];

        // Get form data for supplier
        $supplier_name = $_POST['Supplier_Name'];
        $email = $_POST['Email'];
        $date_ordered = $_POST['date_ordered'];
        $date_acquired = $_POST['date_acquired'];

        // Insert into toyItem
        $stmt = $conn->prepare("INSERT INTO toyitem (name, description, brand, category) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $description, $brand, $category);
        $stmt->execute();
        $item_id = $conn->insert_id; // Get the newly inserted toy's ID
        $stmt->close();

        // Insert into manufacturer
        $stmt = $conn->prepare("INSERT INTO manufacturer (manufacturer_name, location) VALUES (?, ?)");
        $stmt->bind_param("ss", $manufacturer_name, $manufacturer_location);
        $stmt->execute();
        $manufacturer_id = $conn->insert_id;
        $stmt->close();

        // Insert into supplier
        $stmt = $conn->prepare("INSERT INTO supplier (supplier_name, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $supplier_name, $email);
        $stmt->execute();
        $supplier_id = $conn->insert_id;
        $stmt->close();

        // Insert into manufactures
        $stmt = $conn->prepare("INSERT INTO manufactures (manufacturer_id, item_id, batch_num) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $manufacturer_id, $item_id, $batch_num);
        $stmt->execute();
        $stmt->close();

        // Insert into purchasedThrough (corrected table name from purchaseathrough)
        $stmt = $conn->prepare("INSERT INTO purchasedThrough (item_id, supplier_id, date_ordered, date_acquired) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $item_id, $supplier_id, $date_ordered, $date_acquired);
        $stmt->execute();
        $stmt->close();

        // Insert into provides
        $stmt = $conn->prepare("INSERT INTO provides (manufacturer_id, supplier_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $manufacturer_id, $supplier_id);
        $stmt->execute();
        $stmt->close();

        // Handle image uploads (assuming this was part of the previous version)
        if (isset($_FILES['images']) && $_FILES['images']['error'][0] == 0) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['images']['name'][$key];
                $file_tmp = $_FILES['images']['tmp_name'][$key];
                $image_id = 'img_' . uniqid();
                $uploaded_file = $upload_dir . basename($file_name);
                if (move_uploaded_file($file_tmp, $uploaded_file)) {
                    $stmt = $conn->prepare("INSERT INTO toyImage (image_id, image_url, description, is_primary_image) VALUES (?, ?, '', 0)");
                    $stmt->bind_param("ss", $image_id, $uploaded_file);
                    $stmt->execute();
                    $stmt->close();

                    $stmt = $conn->prepare("INSERT INTO has (item_id, image_id) VALUES (?, ?)");
                    $stmt->bind_param("is", $item_id, $image_id);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    throw new Exception("Failed to upload file");
                }
            }
        }

        // Commit the transaction
        $conn->commit();
        echo "New toy added successfully";
        header("Location: home.php"); // Redirect to home.php instead of employees.php
        exit();
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    // Display the form
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
                            <label for="Toy_Name">Toy Name:</label>
                            <input type="text" id="Toy_Name" name="Toy_Name" placeholder="Toy Name" required>
                        </div>
                        <div class="form-group">
                            <label for="Description">Description:</label>
                            <textarea id="Description" name="Description" placeholder="Describe the toy"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="brand">Brand:</label>
                            <input type="text" id="brand" name="brand" placeholder="Brand" required>
                        </div>
                        <div class="form-group">
                            <label for="Category">Category:</label>
                            <input type="text" id="Category" name="Category" placeholder="Category" required>
                        </div>
                        <div class="form-group">
                            <label for="Manufacturer_Name">Manufacturer Name:</label>
                            <input type="text" id="Manufacturer_Name" name="Manufacturer_Name" placeholder="Manufacturer Name" required>
                        </div>
                        <div class="form-group">
                            <label for="manufacturer_location">Manufacturer Location:</label>
                            <input type="text" id="manufacturer_location" name="manufacturer_location" placeholder="Manufacturer Location" required>
                        </div>
                        <div class="form-group">
                            <label for="batch_num">Batch Number:</label>
                            <input type="text" id="batch_num" name="batch_num" placeholder="Batch Number" required>
                        </div>
                        <div class="form-group">
                            <label for="Supplier_Name">Supplier Name:</label>
                            <input type="text" id="Supplier_Name" name="Supplier_Name" placeholder="Supplier Name" required>
                        </div>
                        <div class="form-group">
                            <label for="Email">Supplier Email:</label>
                            <input type="email" id="Email" name="Email" placeholder="Supplier Email" required>
                        </div>
                        <div class="form-group">
                            <label for="date_ordered">Date Ordered:</label>
                            <input type="date" id="date_ordered" name="date_ordered" required>
                        </div>
                        <div class="form-group">
                            <label for="date_acquired">Date Acquired:</label>
                            <input type="date" id="date_acquired" name="date_acquired" required>
                        </div>
                        <div class="form-group">
                            <label>Images:</label>
                            <div id="image-inputs">
                                <div class="image-group">
                                    <input type="file" name="images[]" accept="image/*" class="image-input">
                                    <img class="image-preview" src="" alt="Preview" style="display:none; max-width:100px;">
                                    <button type="button" class="remove-image">Remove</button>
                                </div>
                            </div>
                            <button type="button" id="add-image">Add Another Image</button>
                        </div>
                        <div class="form-group">
                            <button type="submit">Add Toy</button>
                            <button type="button" onclick="window.location.href='home.php'">Cancel</button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
        <script>
            document.getElementById('image-inputs').addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-image')) {
                    event.target.parentElement.remove();
                }
            });

            function createImageGroup() {
                var group = document.createElement('div');
                group.className = 'image-group';
                var input = document.createElement('input');
                input.type = 'file';
                input.name = 'images[]';
                input.accept = 'image/*';
                input.className = 'image-input';
                var preview = document.createElement('img');
                preview.className = 'image-preview';
                preview.src = '';
                preview.alt = 'Preview';
                preview.style.display = 'none';
                preview.style.maxWidth = '100px';
                var removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-image';
                removeBtn.textContent = 'Remove';
                group.appendChild(input);
                group.appendChild(preview);
                group.appendChild(removeBtn);
                document.getElementById('image-inputs').appendChild(group);

                input.addEventListener('change', function() {
                    var file = this.files[0];
                    if (file) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.src = '';
                        preview.style.display = 'none';
                    }
                });
            }

            document.querySelector('.image-input').addEventListener('change', function() {
                var preview = this.nextElementSibling;
                var file = this.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.style.display = 'none';
                }
            });

            document.getElementById('add-image').addEventListener('click', createImageGroup);
        </script>
    </body>
    </html>
    <?php
}
$conn->close();
?>