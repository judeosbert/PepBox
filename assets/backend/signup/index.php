<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 7/9/16
 * Time: 10:53 AM
 */
require("../dbconnect/index.php");
$results=[];
$userFullName = $_POST["userFullName"];
$accountType = $_POST["accountType"];
$email = $_POST["userEmail"];
$password =$_POST["userPassword"];
$userFullName = test_input($userFullName);
$accountType = test_input($accountType);
$email = test_input($email);

$password_hash = password_hash($password,PASSWORD_BCRYPT);

//Check if Domain Belongs to Academic Database
$parts = explode("@",$email);
$domain = $parts[1];

$domainId = 0;
$query = "SELECT academicId FROM academicdomains WHERE academicDomain LIKE ?";
$check = $conn->prepare($query);
$check->bind_param("s",$domain);
$check->execute();
$check->bind_result($domainId);
$check->fetch();
$check->close();

if($domainId == 0)
{
    $results+=["status"=>3]; //Invalid Domains
    echo json_encode($results);
    exit();
}





//Check unique for Email

$query = "SELECT count(*) FROM users WHERE userEmail LIKE ?";
$unique = $conn->prepare($query);
$unique->bind_param("s",$email);
$unique->execute();
$unique->bind_result($count);
$unique->fetch();
$unique->close();
if($count > 0)
{
    $results+=["status" => 2]; // Not Unique Mail
    echo json_encode($results);
    exit();
}


$query = "INSERT INTO users (userFullName,userPassword,userAccountCreatedTime,userLevel,userEmail,collegeId) VALUES(?,?,?,?,?,?)";
if(strcmp($accountType,"student")==0)
{
    $accountType = 0;
}else
{
    $accountType = 1;
}
$create = $conn->prepare($query);
$create->bind_param("sssisi",$userFullName,$password_hash,date("Y:m:d H:i:s"),$accountType,$email,$domainId);

if($create->execute())
{
    $results+=["status"=>1]; //Success
    $create->close();
    //mail($email,"Welcome to PepBox","Welcome to PepBox.");
}
else
{
    $results+=["status" => 0];
}
echo json_encode($results);
exit();

















