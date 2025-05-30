<?php
// delete_toy.php
// Deletes a toy and all its related records (images, purchases, manufacturers, etc.)

// 1) Include your database connection
include 'DBConnector.php';

// 2) Get and sanitize the toy ID from POST
$toyid = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
if ($toyid <= 0) {
    die('Invalid toy ID.');
}

try {
    // Log the toy being deleted
    echo "Deleting toy with ID: $toyid<br>";

    // 3) Fetch associated image IDs
    $sql = "
        SELECT h.image_id
          FROM `has` AS h
          INNER JOIN `toyimage` AS ti
            ON h.image_id = ti.image_id
         WHERE h.item_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $toyid);
    $stmt->execute();
    $res = $stmt->get_result();

    $imageIds = [];
    while ($row = $res->fetch_assoc()) {
        $imageIds[] = $row['image_id'];
    }
    $stmt->close();

    // 4) Delete those images (if any)
    if (!empty($imageIds)) {
        $placeholders = implode(',', array_fill(0, count($imageIds), '?'));
        $sql = "DELETE FROM `toyimage` WHERE image_id IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        // Bind each ID as an integer
        $types = str_repeat('i', count($imageIds));
        $stmt->bind_param($types, ...$imageIds);
        $stmt->execute();
        $stmt->close();
    }

    // 5) Delete from all other related tables + main table
    $tables = [
        'purchaseathrough',
        'manufactures',
        'has',
        'toyitem'
    ];

    foreach ($tables as $table) {
        echo "Executing: DELETE FROM `$table` WHERE item_id = $toyid<br>";
        $sql = "DELETE FROM `$table` WHERE item_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $toyid);
        $stmt->execute();
        $stmt->close();
    }

    echo "Successfully deleted toy (ID = $toyid) and all related records.";

} catch (mysqli_sql_exception $e) {
    // In production, you might log $e->getMessage() instead of echoing
    echo "Error deleting toy: " . $e->getMessage();
}

header("Location: home.php");
exit;

// 6) Close connection
$conn->close();