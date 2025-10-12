<?php
include "../connect.php";

// Get user input
$usersemail = filterRequest("email");
$userspassword = sha1($_POST['password']);

// Prepare query
$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? AND users_password = ? AND TRIM(users_approved) = 1");
$stmt->execute([$usersemail, $userspassword]);

$count = $stmt->rowCount();

if ($count > 0) {
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // fetch user data
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));
}
?>
