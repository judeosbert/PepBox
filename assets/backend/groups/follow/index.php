<?php

require ("../../dbconnect/index.php");
$userID = $_SESSION["userId"];
$groupID = $_COOKIE["viewGroupID"];
$query = "SELECT count(*) FROM groupmembers WHERE groupId = ? AND userId = ?";
$results=[];
$isFollowing = $conn->prepare($query);
$isFollowing->bind_param("ii",$groupID,$userID);
$isFollowing->execute();
$isFollowing->bind_result($isFollow);
$isFollowing->fetch();
$isFollowing->close();
if($isFollow == 0)
{
    $query = "INSERT INTO groupmembers(groupId, userId) VALUES (?,?)";
    $addFollow = $conn->prepare($query);
    $addFollow->bind_param("ii",$groupID,$userID);
    if($addFollow->execute())
    {
        $results+=["status"=>1];
    }
    else
    {
        $results+=["status"=>0];
    }
    $addFollow->close();

    $getOwner = $conn->prepare("SELECT groupOwner,groupName FROM groups WHERE groupId = ?");
    $getOwner->bind_param("i",$groupID);
    $getOwner->execute();
    $getOwner->bind_result($groupOwner,$groupName);
    $getOwner->fetch();
    $getOwner->close();
    $query = " INSERT INTO notifications(content, recipient, creationTime) VALUES(?,?,?)";
    $addNotification = $conn->prepare($query);
    $content = $_SESSION["userFullName"]." has joined you group ".$groupName;
    $addNotification->bind_param("sis",$content,$groupOwner,date("Y-m-d H:i:s"));
    $addNotification->execute();
    $addNotification->close();
}
else
{
    $query="DELETE FROM groupmembers WHERE groupId=? AND userId = ? ";
    $remFollow = $conn->prepare($query);
    $remFollow->bind_param("ii",$groupID,$userID);
    if($remFollow->execute())
    {
        $results+=["status"=>2];
    }
    else
    {
        $results+=["status"=>0];
    }
    $remFollow->close();
}
echo json_encode($results);