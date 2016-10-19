<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 15/10/16
 * Time: 10:55 AM
 */
require ("../dbconnect/index.php");

$activeUser = $_SESSION["userId"];
$followUser = $_POST["userID"];
$results=[];
if($activeUser == $followUser)
{
    return;
}
 //Default Fail
$query = "SELECT count(*) FROM followers WHERE followingUser = ? AND followUser = ?";
$isFollowing  = $conn->prepare($query);
$isFollowing->bind_param("ii",$activeUser,$followUser);
$isFollowing->execute();
$isFollowing->bind_result($isFollowingCount);
$isFollowing->fetch();
$isFollowing->close();
if($isFollowingCount == 0) {
    $query = "INSERT INTO followers(followUser, followingUser, followStartTime) VALUES (?,?,?)";
    $follow = $conn->prepare($query);
    $follow->bind_param("iis", $followUser, $activeUser, date('Y-m-d H:i:s'));
    if ($follow->execute()) {
        $results += ["status" => 1]; //Success
    } else {
        $results += ["status" => 0];
    }
    $follow->close();

    $query = "INSERT INTO notifications(content, recipient, creationTime) VALUES (?,?,?)";
    $addNotify = $conn->prepare($query);
    $content = $_SESSION["userFullName"]." has started following you.";
    $addNotify->bind_param("sis",$content,$followUser,date('Y-m-d H:i:s'));
    $addNotify->execute();
    $addNotify->close();
}
else
{
    $query = "DELETE FROM followers WHERE followUser = ? AND followingUser = ?";
    $follow = $conn->prepare($query);
    $follow->bind_param("ii", $followUser, $activeUser);
    if ($follow->execute()) {
        $results += ["status" => 2]; //Success
    } else {
        $results += ["status" => 0];
    }
    $follow->close();
}
echo json_encode($results);



