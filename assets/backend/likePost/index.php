<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 16/10/16
 * Time: 9:01 PM
 */

require ("../dbconnect/index.php");
$postID = $_POST["postID"];
$userID = $_SESSION["userId"];
$query = "INSERT INTO likeactivity (postId, likeTime, likedBy) VALUES(?,?,?);";
$addLike = $conn->prepare($query);
$addLike->bind_param("isi",$postID,date("Y-m-d H:i:s"),$userID);
$results=[];
if($addLike->execute()) {
$results+=["status" => 1];
}
else
    {
    $results+=["status" => 0];
}
$addLike->close();
if($results["status"] == 1) {
    $query = "UPDATE userpost SET likes = likes+1 WHERE postId = ?";
    $updateLike = $conn->prepare($query);
    $updateLike->bind_param("i", $postID);
    if ($updateLike->execute()) {
        $results["status"] = 1;
    } else {
        $results["status"] = 0;
    }
    $updateLike->close();
    $query = "SELECT postOwner FROM userpost WHERE postId =? ";
    $getOwner = $conn->prepare($query);
    $getOwner->bind_param("i",$postID);
    $getOwner->execute();
    $getOwner->bind_result($postOwner);
    $getOwner->fetch();
    $getOwner->close();

    $query = " INSERT INTO notifications(content, recipient, creationTime) VALUES(?,?,?)";
    $addNotification = $conn->prepare($query);
    $content = $_SESSION["userFullName"]." has liked your post";
    $addNotification->bind_param("sis",$content,$postOwner,date("Y-m-d H:i:s"));
    $addNotification->execute();
    $addNotification->close();
}
echo json_encode($results);
