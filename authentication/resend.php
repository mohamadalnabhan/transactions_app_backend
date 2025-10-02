<?php
include "../connect.php";
include "../mail/mailer.php";

// User enters email
$usersemail = filterRequest("email");

// Check if user exists and is not verified
$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? AND users_approved = 0");
$stmt->execute(array($usersemail));
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Generate new verification code
    $verifyCode = rand(10000, 99999);

    // Update DB w
    $data = array(
        "users_verificationcode" => $verifyCode
    );
    updateData("users", $data, "users_email = '$usersemail'");

    // Send verification email
    $sent = sendEmail($usersemail, "Resend Verification Code", "Your new code is $verifyCode");

    if ($sent) {
        printSuccess("Verification code resent");
    } else {
        printFailure("Failed to send verification email");
    }
} else {
    printFailure("User not found or already verified");
}
?>
