<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 16/10/16
 * Time: 9:01 PM
 */

require ("../../dbconnect/index.php");
$postID = $_POST["postID"];
$userID = $_SESSION["userId"];


    $query = "UPDATE groupPosts SET likes = likes+1 WHERE postId = ?";
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
$content = $_SESSION["userFullName"]." has liked your post from group ".$groupName;
$addNotification->bind_param("sis",$content,$postOwner,date("Y-m-d H:i:s"));
$addNotification->execute();
$addNotification->close();
echo json_encode($results);
