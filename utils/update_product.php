<?php
include('../db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $dosage_form = $_POST['dosage_form'];
    $brand = $_POST['brand'];
    $batch_no = $_POST['batch_no'];
    $dosage = $_POST['dosage'];
    $unit_measure = $_POST['unit_measure'];
    $date_expiry = $_POST['date_expiry'];
    $type_id = $_POST['type_id'];
    $supplier_id = $_POST['supplier_id'];
    $shelf_no = $_POST['shelf_no'];
    $sub_category_id = $_POST['sub_category_id'];

    // Check if the prescription checkbox is checked
    $prescription = isset($_POST['prescription']) ? 1 : 0;

    // Perform the update query
    $query = "UPDATE product_list SET
              dosage_form = '$dosage_form',
              brand = '$brand',
              batch_no = '$batch_no',
              dosage = '$dosage',
              unit_measure = '$unit_measure',
              date_expiry = '$date_expiry',
              type_id = '$type_id',
              supplier_id = '$supplier_id',
              shelf_no = '$shelf_no',
              sub_category_id = '$sub_category_id',
              prescription = '$prescription'
              WHERE id = $id";

    if ($conn->query($query) === TRUE) {
        
        echo 1; // Success
    } else {
        echo 'Error: ' . $conn->error;
    }

    exit(); // Stop further execution
}
?>
