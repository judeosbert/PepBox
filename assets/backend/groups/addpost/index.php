<?php
require("../../dbconnect/index.php");

$userPost = $_POST["userPost"];
//$userPost = test_input($userPost);
//$userPost = filter_var(FILTER_SANITIZE_STRING,$userPost);
$userID = $_SESSION["userId"];
$groupID = $_COOKIE["viewGroupID"];
$query = "INSERT INTO groupPosts (groupId,groupPost, postCreator, creationTime) VALUES(?,?,?,?)";
$insertPost = $conn->prepare($query);
$insertPost->bind_param("isis",$groupID,$userPost,$userID,date("Y-m-d H:i:s"));
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
$query = "SELECT groupName FROM groups WHERE groups.groupId = ?";
$getOwner = $conn->prepare($query);
$getOwner->bind_param("i",$groupID);
$getOwner->execute();
$getOwner->bind_result($groupName);
$getOwner->fetch();
$getOwner->close();
$getGroupMembers = $conn->prepare("SELECT userId from groupmembers WHERE groupId = ?");
$getGroupMembers->bind_param("i",$groupID);
$getGroupMembers->execute();
$getGroupMembers->bind_result($memberID);
$members=[];
while($getGroupMembers->fetch())
{
    array_push($members,$memberID);
}

$getGroupMembers->close();
$query = " INSERT INTO notifications(content, recipient, creationTime) VALUES(?,?,?)";
$addNotification = $conn->prepare($query);
$content = $_SESSION["userFullName"]." has posted to  group ".$groupName;
$arrayLength = sizeof($members);
for($i=0;$i<=$arrayLength;$i++) {
    $addNotification->bind_param("sis", $content, $members[$i], date("Y-m-d H:i:s"));
    $addNotification->execute();
}
$addNotification->close();
echo json_encode($results);