<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 28/9/16
 * Time: 6:02 PM
 */
require_once ("../dbconnect/index.php");

$userid = $_SESSION["userId"];

//Select follower count
$query = "SELECT count(*) FROM followers WHERE followUser = ?";
$getFollowerCount = $conn->prepare($query);
$getFollowerCount -> bind_param("i",$userid);
$getFollowerCount->execute();
$getFollowerCount->bind_result($followerCount);
$getFollowerCount->fetch();
$getFollowerCount->close();
$result=[];
$result+=["followerCount" => $followerCount,
            ];
$query = "SELECT count(*) FROM notifications WHERE recipient = ? AND readStatus = 0";
$getNotificationCount = $conn->prepare($query);
$getNotificationCount->bind_param("i",$userid);
$getNotificationCount->execute();
$getNotificationCount->bind_result($notificationCount);
$getNotificationCount->fetch();
$getNotificationCount->close();
$result+=["notificationCount" => $notificationCount];
echo json_encode($result);
