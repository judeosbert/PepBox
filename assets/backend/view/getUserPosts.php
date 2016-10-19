<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 16/10/16
 * Time: 12:32 AM
 */
require ("../dbconnect/index.php");

$userID = $_COOKIE["viewProfileID"];

$query = "SELECT postID,postContent,postCreationTime,likes,shares FROM userpost WHERE postOwner = ? ORDER BY postID DESC";
$getPosts = $conn->prepare($query);
$getPosts->bind_param("i",$userID);
$getPosts->execute();
$getPosts->bind_result($postID,$postContent,$postCreationTime,$likes,$shares);
$i=0;
$postBulk=[];
$results=[];
$post=[];
while($getPosts->fetch())
{
    $i++;
    $post=["postID" => $postID,
            "postContent" => $postContent,
            "postCreationTime" => $postCreationTime,
            "likes" => $likes,
            "shares" => $shares];
    $postBulk+=["post".$i => $post];
}
$getPosts->close();
$results+=["postCount" => $i];
$results+=["data" => $postBulk];
echo json_encode($results);
