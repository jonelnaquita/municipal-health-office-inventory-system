<?php

include 'db_connect.php';

session_start();

$response = ['success' => false, 'error' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resetCode = mysqli_real_escape_string($conn, $_POST['resetCode']);
    $newPassword = mysqli_real_escape_string($conn, md5($_POST['newPassword']));
    $confirmPassword = mysqli_real_escape_string($conn, md5($_POST['confirmPassword']));

    $result = mysqli_query($conn, "SELECT * FROM users WHERE code='$resetCode'");

    if (mysqli_num_rows($result) > 0) {
        if ($newPassword === $confirmPassword) {
            $updateQuery = mysqli_query($conn, "UPDATE users SET password='$newPassword', code='' WHERE code='$resetCode'");

            if ($updateQuery) {
                $response['success'] = true;
            } else {
                $response['error'] = "Error updating password. Please try again.";
            }
        } else {
            $response['error'] = "New Password and Confirm Password do not match.";
        }
    } else {
        $response['error'] = "Reset link is invalid.";
    }
}

header('Content-Type: application/json');
echo json_encode($response);

?>
