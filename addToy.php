<?php
include 'DBConnector.php';

// Start a transaction for data consistency
$conn->begin_transaction();

try {
    // Get form data
    $name = $_POST['Toy_Name'];
    $description = $_POST['Description'];
    $brand = $_POST['brand'];
    $category = $_POST['Category'];
    $manufacturer_name = $_POST['Manufacturer_Name'];
    $manufacturer_location = $_POST['manufacturer_location'];
    $batch_num = $_POST['batch_num'];
    $supplier_name = $_POST['Supplier_Name'];
    $email = $_POST['Email'];
    $date_ordered = $_POST['date_ordered'];
    $date_acquired = $_POST['date_acquired'];

    // Insert into toyitem
    $stmt = $conn->prepare("INSERT INTO toyitem (name, description, brand, category) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $name, $description, $brand, $category);
    $stmt->execute();
    $item_id = $conn->insert_id;
    $stmt->close();

    // Handle image upload
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] == 0) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $file_name = $_FILES['image_url']['name'];
        $file_tmp = $_FILES['image_url']['tmp_name'];
        $image_id = $conn->insert_id + 1; // Generate a unique image_id
        $uploaded_file = $upload_dir . basename($file_name);
        if (move_uploaded_file($file_tmp, $uploaded_file)) {
            $stmt = $conn->prepare("INSERT INTO toyimage (image_id, image_url, description, is_primary_image) VALUES (?, ?, '', 1)");
            $stmt->bind_param('is', $image_id, $uploaded_file);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO has (item_id, image_id) VALUES (?, ?)");
            $stmt->bind_param('ii', $item_id, $image_id);
            $stmt->execute();
            $stmt->close();
        } else {
            throw new Exception("Failed to upload image");
        }
    } else {
        throw new Exception("No image uploaded or upload error");
    }

    // Insert into manufacturer
    $stmt = $conn->prepare("INSERT INTO manufacturer (manufacturer_name, location) VALUES (?, ?)");
    $stmt->bind_param('ss', $manufacturer_name, $manufacturer_location);
    $stmt->execute();
    $manufacturer_id = $conn->insert_id;
    $stmt->close();

    // Insert into supplier
    $stmt = $conn->prepare("INSERT INTO supplier (supplier_name, email) VALUES (?, ?)");
    $stmt->bind_param('ss', $supplier_name, $email);
    $stmt->execute();
    $supplier_id = $conn->insert_id;
    $stmt->close();

    // Insert into manufactures
    $stmt = $conn->prepare("INSERT INTO manufactures (manufacturer_id, item_id, batch_num) VALUES (?, ?, ?)");
    $stmt->bind_param('iii', $manufacturer_id, $item_id, $batch_num);
    $stmt->execute();
    $stmt->close();

    // Insert into purchaseathrough
    $stmt = $conn->prepare("INSERT INTO purchaseathrough (item_id, supplier_id, date_ordered, date_acquired) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('iiss', $item_id, $supplier_id, $date_ordered, $date_acquired);
    $stmt->execute();
    $stmt->close();

    // Insert into provides
    $stmt = $conn->prepare("INSERT INTO provides (manufacturer_id, supplier_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $manufacturer_id, $supplier_id);
    $stmt->execute();
    $stmt->close();

    // Commit the transaction
    $conn->commit();
    echo "New toy added successfully";
    header("Location: home.php");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
?>