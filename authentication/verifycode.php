<?php
include "../connect.php"; 

$email = $_POST['email'];
$code = $_POST['users_verificationcode'];

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? AND users_verificationcode = ?");
$stmt->execute(array($email, $code));
$count = $stmt->rowCount();

if ($count > 0) {
    $data = array("users_approved" => 1);
    updateData("users", $data, "users_email = '$email'");
    echo json_encode(["status" => "success", "message" => "✅ Account verified successfully"]);
} else {
    echo json_encode(["status" => "failure", "message" => "Invalid verification code or email"]);
}

?>
