<?php
// Include your database connection file
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Handle invalid request method
    http_response_code(405); // Method Not Allowed
    exit('Invalid request method');
}

// Sanitize and validate input
$selectedDate = isset($_POST['selectedDate']) ? $_POST['selectedDate'] : '';
$selectedBarangay = isset($_POST['selectedBarangay']) ? $_POST['selectedBarangay'] : '';

// Initialize the WHERE clause for the SQL query
$whereClause = 'WHERE status = ""';

// Add conditions based on user input
if ($selectedDate) {
    $whereClause .= " AND ir.availed_date = '$selectedDate'";
}

if ($selectedBarangay) {
    $whereClause .= " AND pl.address = '$selectedBarangay'";
}

// Fetch data from the database
$query = "SELECT m.sub_category_name, m.brand_name, SUM(ir.quantity) AS request_count, ir.availed_date
            FROM manage_sub_category m
            LEFT JOIN product_list p ON m.id = p.sub_category_id
            LEFT JOIN item_requested ir ON p.id = ir.product_id
            LEFT JOIN patient_list pl ON ir.patient_id = pl.id
            LEFT JOIN heat_map hm ON pl.address = hm.brgy_name
            $whereClause
            GROUP BY p.sub_category_id";

$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'label' => $row['sub_category_name'] . ' ' . $row['brand_name'],
        'data' => $row['request_count'],
    ];
}

echo json_encode($data);
?>
