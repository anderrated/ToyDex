<?php
include 'DBConnector.php';

$name = $_POST['Toy_Name'];
$description_item = $_POST['Description'];
$brand = $_POST['brand'];
$category = $_POST['Category'];


$manufacturer_name = $_POST['Manufacturer_Name'];
$manufacturer_location = $_POST['manufacturer_location'];
$batch_num = $_POST['batch_num'];


$supplier_name = $_POST['Supplier_Name'];
$email = $_POST['Email'];
$date_ordered = $_POST['date_ordered'];
$date_acquired = $_POST['date_acquired'];

$image_url = $_POST['image_url'];
$description_image = $_POST['description'];

$item_id = $_POST['item_id'];
$image_id = $_POST['image_id'];
$supplier_id = $_POST['supplier_id'];
$manufacturer_id = $_POST['manufacturer_id'];


//toyitem
$sql = "UPDATE toyitem SET name = '$name', description = '$description_item', brand = '$brand', category = '$category' WHERE item_id = $item_id";
$conn->query($sql);

if($conn->query($sql) === TRUE){

    //purchaseathrough
    $sql = "UPDATE purchaseathrough SET date_ordered = '$date_ordered', date_acquired = '$date_acquired' WHERE item_id = $item_id AND supplier_id = $supplier_id;";
    $conn->query($sql);

    //supplier
    $sql = "UPDATE supplier SET supplier_name = '$supplier_name', email = '$email' WHERE supplier_id = $supplier_id;";
    $conn->query($sql);

    //toyimage
    $sql = "UPDATE toyimage SET image_url = '$image_url', description = '$description_image' WHERE image_id = $image_id;";
    $conn->query($sql);

    //manufactures
    $sql = "UPDATE manufactures SET batch_num = '$batch_num' WHERE manufacturer_id = $manufacturer_id AND item_id = $item_id;";
    $conn->query($sql);

    //manufacturer
    $sql = "UPDATE manufacturer SET manufacturer_name = '$manufacturer_name', location = '$manufacturer_location' WHERE manufacturer_id = $manufacturer_id;";
    $conn->query($sql);

    header("Location: home.php");


}else {
     echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>