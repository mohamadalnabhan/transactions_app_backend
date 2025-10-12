<?php
include "../connect.php";

$usersemail = filterRequest("email");
$verifyCode = rand(10000, 99999);

// 1️⃣ Check if user exists
$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ?");
$stmt->execute([$usersemail]);
$count = $stmt->rowCount();

if ($count > 0) {
    // 2️⃣ Save code in DB
    $data = array("users_verificationcode" => $verifyCode);
    updateData("users", $data, "users_email = '$usersemail'", false);

    // 3️⃣ Send email
    $sent = sendEmail($usersemail, "Password Reset Code", "Here is your reset code: $verifyCode");
    if (!$sent) {
        error_log("❌ sendEmail failed for $usersemail");
    }

    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "failure", "message" => "Email not found"]);
}
?>
