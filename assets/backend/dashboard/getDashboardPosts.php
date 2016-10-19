<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 16/10/16
 * Time: 11:29 PM
 */
require ("../dbconnect/index.php");
$userID= $_SESSION["userId"];
$query = "SELECT postId,postContent,users.userFullName,postOwner,userpost.postCreationTime,userpost.likes,userpost.shares,users.userProfilePic FROM users,userpost,followers WHERE userpost.postOwner = followUser AND followers.followingUser = ? AND users.userId = followers.followUser AND userpost.postId > ?  ORDER BY  postId DESC LIMIT 20 ";
$getPosts = $conn->prepare($query);
$getPosts->bind_param("ii",$userID,$_SESSION["userLastPostID"]);
$getPosts->execute();
$getPosts->bind_result($postId,$postContent,$userFullName,$postOwner,$postCreationTime,$likes,$shares,$userProfilePic);
$i=0;
$results=[];
$post=[];
$postBulk=[];
while($getPosts->fetch())
{
    $i++;
    $post=["postID" => $postId,
        "postContent" => $postContent,
        "userFullName" => $userFullName,
        "postOwner" => $postOwner,
        "likes" => $likes,
        "shares" => $shares,
        "userProfilePic" => $userProfilePic,
        "postCreationTime" => $postCreationTime];
    if($postId > $_SESSION["userLastPostID"])
    {
        $_SESSION["userLastPostID"] = $postId;
    }
    $postBulk+=["post".$i => $post];

}
if($_SESSION["userLastPostID"] == 0)
{
    $results+=["postCount" => -1];
}
else {
    $results += ["postCount" => $i];
}
    $results +=["data" => $postBulk];
$getPosts->close();
echo json_encode($results);
