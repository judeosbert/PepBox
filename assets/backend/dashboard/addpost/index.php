<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 28/9/16
 * Time: 6:09 PM
 */
require("../../dbconnect/index.php");

$userPost = $_POST["userPost"];
//$userPost = test_input($userPost);
//$userPost = filter_var(FILTER_SANITIZE_STRING,$userPost);
$userID = $_SESSION["userId"];
$query = "INSERT INTO userpost (postContent, postOwner, postCreationTime) VALUES(?,?,?)";
$insertPost = $conn->prepare($query);
$insertPost->bind_param("sis",$userPost,$userID,date("Y-m-d H:i:s"));
$results=[];
if($insertPost->execute())
{
    $results+=["status" => 1];    // Success
}
else
{
    $results+=["status" => 0]; //Fail
}
$insertPost->close();
echo json_encode($results);
