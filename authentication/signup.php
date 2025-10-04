<?php

include "../connect.php" ; 

include __DIR__ . "/../mail/mailer.php";
$verifyCode = rand(10000, 99999); // 5-digit random code

//Get user input (signup data)
$username = filterRequest("username") ;
$usersemail = filterRequest("email") ; 
$usersphone = filterRequest("phone") ; 

// $verifyCode =  filterRequest("verifycode") ;  
$userspassword  = sha1($_POST['password'])  ; 

//checking if email exist 
$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? OR users_phone = ?");
$stmt ->execute(array($usersemail , $usersphone)) ; 

$count = $stmt ->rowCount() ; 

 // If user exists → return error
if($count > 0 ) {
   printFailure("error happened with email or phone number") ;
}else {
    //5. Else → create new user
    $data = array(
        "username" => $username , 
        "users_email"=>$usersemail  ,
        "users_password" =>$userspassword  ,
        "users_phone" => $usersphone , 
        "users_verificationcode" =>$verifyCode , 
    ) ; 
 $sent = sendEmail($usersemail, "Verification code Test", "Verification code $verifyCode");


    if (!$sent) {
    error_log("❌ sendEmail failed for $usersemail");
}
    insertData("users" , $data);
}

?> 