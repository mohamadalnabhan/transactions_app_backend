<?php

include "../connect.php" ; 


 //Get user input (signup data)
$usersemail = filterRequest("email") ; 
$usersphone = filterRequest("phone") ; 
$userspassword  = sha1($_POST['password'])  ;


getData("users", "users_email = ? AND users_password = ?", array($usersemail, $userspassword));


?>