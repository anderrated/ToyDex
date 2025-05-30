<?php

include 'DBConnector.php';

$item_id = $_POST['item_id'];

$sql = "SELECT * FROM toyitem WHERE item_id = $item_id";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $toyItemRow = $result->fetch_assoc();

    // manufactures, manufacturer
    $sql = "SELECT * FROM manufactures INNER JOIN manufacturer ON manufactures.manufacturer_id = manufacturer.manufacturer_id  WHERE item_id = $item_id";
    $result = $conn->query($sql);
    $manufacturerRow = $result->fetch_assoc();

    //supplier. purchaseathroug
    $sql = "SELECT * FROM supplier INNER JOIN purchaseathrough ON supplier.supplier_id = purchaseathrough.supplier_id  WHERE item_id = $item_id";
    $result = $conn->query($sql);
    $supplierRow = $result->fetch_assoc();
    
    //toyimage has
    $sql = "SELECT * FROM toyimage INNER JOIN has ON toyimage.image_id = has.image_id  WHERE item_id = $item_id";
    $result = $conn->query($sql);
    $imageRow = $result->fetch_assoc();



    echo '
     <form action = "pushEdits.php" method=post>
        <h2>Edit Toy</h2>

        <div>
            <label for="Toy_Name" class = "add_Popup_Label">Toy Name</label>
            <input type = "text" class = "add_Popup_Input" name ="Toy_Name" autocomplete="name" value= "'.$toyItemRow['name'].'" required>
        </div>

        <div>                
            <label for="Description" class = "add_Popup_Label">Description</label>
            <input type = "text" class = "add_Popup_Input" name ="Description" autocomplete="off" value= "'.$toyItemRow['description'].'" required>
        </div>

        <div> 
            <label for="brand" class = "add_Popup_Label">Brand</label>
            <input type = "text" class = "add_Popup_Input" name ="brand" autocomplete="organization" value= "'. $toyItemRow['brand'].'" required>
        </div>

        <div>
            <label for="Category" class = "add_Popup_Label">Category</label>
            <input type = "text" class = "add_Popup_Input" name ="Category" autocomplete="off" value= "'.$toyItemRow['category'].'" required>
        </div>

        <div>
            <label for="Manufacturer_Name" class = "add_Popup_Label">Manufacturer</label>
            <input type = "text" class = "add_Popup_Input" name ="Manufacturer_Name" value= "'.$manufacturerRow['manufacturer_name'].'" required>
        </div>

        <div>
            <label for="manufacturer_location" class = "add_Popup_Label">Manufacturer Location</label>
            <input type = "text" class = "add_Popup_Input" name ="manufacturer_location" value= "'.$manufacturerRow['location'].'" required>
        </div>

        <div>
            <label for="batch_num" class = "add_Popup_Label">Batch_num</label>
            <input type = "number" class = "add_Popup_Input" name ="batch_num" value= "'.$manufacturerRow['batch_num'].'" required>
        </div>

        <div>
            <label for="Supplier_Name" class = "add_Popup_Label">Supplier Name</label>
            <input type = "text" class = "add_Popup_Input" name ="Supplier_Name" value= "'.$supplierRow['supplier_name'].'" required>
        </div>

        <div>
            <label for="Email" class = "add_Popup_Label">Email</label>
            <input type = "text" class = "add_Popup_Input" name ="Email" value= "'.$supplierRow['email'].'" required>
        </div>

        <div>
            <label for="date_ordered" class = "add_Popup_Label">Date_Ordered</label>
            <input type = "date" class = "add_Popup_Input" name ="date_ordered" value= "'.$supplierRow['date_ordered'].'" required>
        </div>

        <div>
            <label for="date_acquired" class = "add_Popup_Label">Date_Acquired</label>
            <input type = "date" class = "add_Popup_Input" name ="date_acquired" value= "'.$supplierRow['date_acquired'].'" required>
        </div>


        <div>
            <label for="image_url" class = "add_Popup_Label">image_url</label>
            <input type = "text" class = "add_Popup_Input" name ="image_url" value= "'.$imageRow['image_url'].'" required>
        </div>

        <div>
            <label for="description" class = "add_Popup_Label">description</label>
            <input type = "text" class = "add_Popup_Input" name ="description" value= "'.$imageRow['description'].'" required>
        </div>

        <input type = "hidden" name ="image_id" value= "'.$imageRow['image_id'].'">
        <input type = "hidden" name ="supplier_id" value= "'.$supplierRow['supplier_id'].'">
        <input type = "hidden" name ="item_id" value= "'.$toyItemRow['item_id'].'">
        <input type = "hidden" name ="manufacturer_id" value= "'.$manufacturerRow['manufacturer_id'].'">

        <button type="submit">Submit</button>
    </form>
    '; 

}else {
    echo "0 results";
}

$conn->close();
?>