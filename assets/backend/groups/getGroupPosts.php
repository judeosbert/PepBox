<?php
require ("../dbconnect/index.php");
$groupID = $_COOKIE["viewGroupID"];

$query = "SELECT postId,groupPost,users.userFullName,postCreator,creationTIme,likes,shares,users.userProfilePic FROM users,groupPosts WHERE groupPosts.postCreator = users.userId AND groupPosts.groupId = ? AND groupPosts.postId > ? ORDER BY postId DESC LIMIT 20";
$getPosts = $conn->prepare($query);
$getPosts->bind_param("ii",$groupID,$_SESSION["groupLastPostID"]);
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
    if($postId > $_SESSION["groupLastPostID"])
    {
        $_SESSION["groupLastPostID"] = $postId;
    }
    $postBulk+=["post".$i => $post];

}
if($_SESSION["groupLastPostID"] == 0)
{
    $results+=["postCount" => -1];
}
else {
    $results += ["postCount" => $i];
}
$results +=["data" => $postBulk];
$getPosts->close();
echo json_encode($results);