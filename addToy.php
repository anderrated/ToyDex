<?php
include 'DBConnector.php';

// 1) grab all the POSTed fields
$name                   = $_POST['Toy_Name'];
$description            = $_POST['Description'];
$brand                  = $_POST['brand'];
$category               = $_POST['Category'];
$image_url              = $_POST['image_url'];       // new!

$manufacturer_name      = $_POST['Manufacturer_Name'];
$manufacturer_location  = $_POST['manufacturer_location'];
$batch_num              = $_POST['batch_num'];

$supplier_name          = $_POST['Supplier_Name'];
$email                  = $_POST['Email'];
$date_ordered           = $_POST['date_ordered'];
$date_acquired          = $_POST['date_acquired'];

// 2) insert into toyitem
$stmt = $conn->prepare("
  INSERT INTO toyitem (name, description, brand, category)
  VALUES (?, ?, ?, ?)
");
$stmt->bind_param('ssss', $name, $description, $brand, $category);
$stmt->execute();
$item_id = $conn->insert_id;
$stmt->close();

// 3) insert image + link
$imgStmt = $conn->prepare("
  INSERT INTO toyimage (image_url) VALUES (?)
");
$imgStmt->bind_param('s', $image_url);
$imgStmt->execute();
$image_id = $conn->insert_id;
$imgStmt->close();

$hasStmt = $conn->prepare("
  INSERT INTO has (item_id, image_id) VALUES (?, ?)
");
$hasStmt->bind_param('ii', $item_id, $image_id);
$hasStmt->execute();
$hasStmt->close();

// 4) the rest of your existing inserts...
//    manufacturer ➔ manufactures
//    supplier ➔ purchaseathrough
//    provides

// 5) finally redirect back
header("Location: home.php");
exit;
?>
