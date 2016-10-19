<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 26/9/16
 * Time: 11:23 AM
 */
require ("../../dbconnect/index.php");
$userEmail = $_POST["userEmail"];
$results=[];


if(empty($userEmail))
{
    $results+=["status" => 0]; //Empty Parameters
    echo json_encode($results);
    exit();
}
if(!filter_var($userEmail,FILTER_VALIDATE_EMAIL))
{
    $results+=["status" => 1]; //Invalid Email ID
    echo json_encode($results);
    exit();
}
//Checking for email in database
$userID=0;

$query = "SELECT userID from users where userEmail LIKE ?";
$getUserID = $conn->prepare($query);
$getUserID->bind_param("s",$userEmail);
$getUserID->execute();
$getUserID->bind_result($userID);
$getUserID->fetch();
$getUserID->close();
if($userID !=0)
{

    //User ID is valid and input the request to db
    $hashCode = md5(time().$userID.$userEmail."pepbox.orgcomin");
    $query = "INSERT INTO passwordResetRequests (userID,resetCode,requestTime)VALUES(?,?,?)";
    $insertRequest = $conn->prepare($query);
    $insertRequest->bind_param("iss",$userID,$hashCode,date("Y-m-d H:i:s"));
    $insertRequest->execute();
    $insertRequest->close();

    //Sending request code along with mail
    $subject = "Password Request Code";
    $body = "You requested for a password change for your account. Please click the below link to reset your password <br /><a href='";//.$serverRoot;
    $body+="'>Reset Password</a>";

//    if(mail($userEmail,$subject,$body)) {
        $results += ["status" => 3]; //Success
        echo json_encode($results);
        exit();

//    }

}
else
{
    $results+=["status" => 2];//Fail due to email not found
    echo json_encode($results);
    exit();
}


