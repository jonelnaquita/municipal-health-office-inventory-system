<?php
include 'db_connect.php';

if (isset($_GET['brgyName'])) {
    $brgyName = $conn->real_escape_string($_GET['brgyName']);

    $query = $conn->query("SELECT ir.quantity, ms.sub_category_name, ms.brand_name
                            FROM item_requested ir
                            LEFT JOIN patient_list p ON ir.patient_id = p.id
                            LEFT JOIN product_list pl ON ir.product_id = pl.id
                            LEFT JOIN manage_sub_category ms ON pl.sub_category_id = ms.id
                            WHERE p.address = '$brgyName'
                            GROUP BY ms.sub_category_name, ms.brand_name");

    if ($query) {
        $requestedItems = $query->fetch_all(MYSQLI_ASSOC);

        $content = '';
        foreach ($requestedItems as $item) {
            $content .= '- ' . $item['sub_category_name'] . ' ' . $item['brand_name'] . ': ' . $item['quantity'] . '<br>';
        }

        echo $content;
    } else {
        echo 'Error: ' . $conn->error;
    }
} else {
    echo 'Invalid request';
}
?>
