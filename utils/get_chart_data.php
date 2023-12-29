<?php
// Include your database connection file
include '../db_connect.php';

// Fetch data from the database
$query = "SELECT m.sub_category_name, m.brand_name, SUM(ir.quantity) AS request_count
          FROM manage_sub_category m
          LEFT JOIN product_list p ON m.id = p.sub_category_id
          LEFT JOIN item_requested ir ON p.id = ir.product_id
          WHERE status = ''
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
