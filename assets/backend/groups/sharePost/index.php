<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 16/10/16
 * Time: 9:25 PM
 */
require ("../../dbconnect/index.php");
$postID = $_POST["postID"];
$userID = $_SESSION["userId"];
$groupID = $_COOKIE["viewGroupID"];

$query = "SELECT groupPost FROM groupPosts WHERE postId = ?";
$getPostContent = $conn->prepare($query);
$getPostContent->bind_param("i",$postID);
$getPostContent->execute();
$getPostContent->bind_result($userPost);
$getPostContent->fetch();
$getPostContent->close();

//Adding to the new owner
$query = "INSERT INTO groupPosts (groupPost,postCreator,creationTIme,groupId) VALUES(?,?,?,?)";
$insertPost = $conn->prepare($query);
$insertPost->bind_param("sisi",$userPost,$userID,date("Y-m-d H:i:s"),$groupID);
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

if($results["status"] == 1) {
    $query = "UPDATE groupPosts SET shares = shares+1 WHERE postId = ?";
    $updateLike = $conn->prepare($query);
    $updateLike->bind_param("i", $postID);
    if ($updateLike->execute()) {
        $results["status"] = 1;
    } else {
        $results["status"] = 0;
    }
    $updateLike->close();
    $query = "SELECT postCreator,groupName FROM groupPosts,groups WHERE postId =? AND groupPosts.groupId = groups.groupId";
    $getOwner = $conn->prepare($query);
    $getOwner->bind_param("i",$postID);
    $getOwner->execute();
    $getOwner->bind_result($postOwner,$groupName);
    $getOwner->fetch();
    $getOwner->close();

    $query = " INSERT INTO notifications(content, recipient, creationTime) VALUES(?,?,?)";
    $addNotification = $conn->prepare($query);
    $content = $_SESSION["userFullName"]." has re-shared your post to group ".$groupName;
    $addNotification->bind_param("sis",$content,$postOwner,date("Y-m-d H:i:s"));
    $addNotification->execute();
    $addNotification->close();
}
echo json_encode($results);