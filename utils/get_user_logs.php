<?php

include '../db_connect.php';

if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];

    $userLogs = $conn->query("SELECT * FROM user_logs WHERE user_id = '$userId'");

    while ($log = $userLogs->fetch_assoc()) {
        echo '<div class="row">';
        echo '<div class="col-md-6">' . $log['logs'] . '</div>';
        echo '<div class="col-md-6">' . $log['date_added'] . '</div>';
        echo '</div>';
    }
} else {
    echo 'Invalid request';
}
?>
