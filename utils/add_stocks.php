<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];

    // Fetch current quantity
    $result = $conn->query("SELECT qty FROM product_list WHERE id = '$productID'");
    $row = $result->fetch_assoc();
    $currentQuantity = $row['qty'];

    // Perform database update
    $conn->begin_transaction();

    try {
        // Update product_list table (add current quantity and posted quantity)
        $newQuantity = $currentQuantity + $quantity;
        $stmt = $conn->prepare("UPDATE product_list SET qty = ? WHERE id = ?");
        $stmt->bind_param("ii", $newQuantity, $productID);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        echo json_encode(['status' => 'success', 'message' => 'Request submitted successfully']);
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Error processing request']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
