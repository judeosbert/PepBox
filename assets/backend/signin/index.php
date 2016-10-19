<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 7/9/16
 * Time: 7:32 PM
 */
require ("../dbconnect/index.php");
$email =$_POST["email"];
$password = $_POST["password"];
$email = test_input($email);

$query = "SELECT userId,userFullName,userLevel,userPassword from users WHERE userEmail LIKE ?";
$getPassword  =  $conn->prepare($query);
$getPassword->bind_param("s",$email);
$getPassword->execute();
$getPassword->bind_result($userId,$userFullName,$userLevel,$userPasswordHash);
$getPassword->fetch();
$getPassword->close();
$results=[];
if(password_verify($password,$userPasswordHash))
{
    $_SESSION["loggedIn"] = true;
    $_SESSION["userId"] = $userId;
    $_SESSION["userFullName"] = $userFullName;
    $_SESSION["userLevel"] = $userLevel;
    $results+=["status"=>1]; //Success
    $_SESSION["userLastPostID"] = 0;
    $_SESSION["groupLastPostID"] = 0;
}
else{
    $results+=["status" => 0]; //Fail
}
echo json_encode($results);
exit();
