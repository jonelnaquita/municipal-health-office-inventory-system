<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $patientID = $_POST['patientName'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    $availedDate = date('Y-m-d');

    // Perform database update
    $conn->begin_transaction();

    try {
        // Insert into item_requested table

        $conn->query("INSERT INTO item_requested (patient_id, product_id, quantity, availed_date) VALUES ('$patientID', '$productID', '$quantity', '$availedDate')");

        // Insert into stock_out_items table
        $conn->query("INSERT INTO stock_out_items (product_id, stock_out_date, quantity, status) VALUES ('$productID', '$availedDate', '$quantity', 'Requested')");

        // Update product_list table (reduce quantity)
        $conn->query("UPDATE product_list SET qty = qty - '$quantity' WHERE id = '$productID'");

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


