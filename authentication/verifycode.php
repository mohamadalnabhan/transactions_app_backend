<?php

include "../connect.php" ; 


//Get user input (signup data)

$usersemail = filterRequest("email") ; 
$usersverifycode = filterRequest("users_verificationcode"); 

$stmt = $con->prepare("SELECT * FROM users WHERE users_verificationcode = ?") ;
$stmt ->execute(array($usersverifycode));  
$count = $stmt->rowCount(); 

if($count > 0){
        $data = array("users_approved" => 1);
        updateData("users", $data, "users_email = '$usersemail'");
        printSuccess("✅ Account verified successfully");
}else{
    printFailure("verification code error");
}


?>