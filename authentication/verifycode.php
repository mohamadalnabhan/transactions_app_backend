<?php
include "../connect.php"; 

$email = trim($_POST['email']);
$code  = trim($_POST['users_verificationcode']);

$stmt = $con->prepare("SELECT * FROM users WHERE TRIM(users_email) = ? AND TRIM(users_verificationcode) = ?");
$stmt->execute([$email, $code]);
$count = $stmt->rowCount();

if ($count > 0) {
    $data = array("users_approved" => 1);
    updateData("users", $data, "users_email = '$email'");
  
} else {
    echo json_encode(["status" => "failure", "message" => "Invalid verification code or email"]);
}
?>
