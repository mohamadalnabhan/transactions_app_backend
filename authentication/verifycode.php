<?php
include "../connect.php"; 

$usersemail = filterRequest("email");
$usersverifycode = filterRequest("users_verificationcode");

// ✅ Check both email and verification code
$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? AND users_verificationcode = ?");
$stmt->execute(array($usersemail, $usersverifycode));
$count = $stmt->rowCount();

if ($count > 0) {
    $data = array("users_approved" => 1);
    updateData("users", $data, "users_email = '$usersemail'");
    printSuccess("✅ Account verified successfully");
} else {
    printFailure("Invalid verification code or email");
}
?>
