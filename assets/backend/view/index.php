<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 15/10/16
 * Time: 3:01 PM
 */
require("../dbconnect/index.php");
$userID = $_SESSION["userId"];
$viewProfileID = $_COOKIE["viewProfileID"];
//$viewProfileID = $_GET["a"];
$results=[];
$query = "SELECT userFullName,userName,userLevel,userEmail,userPhone,userProfilePic,academicDomain FROM users,academicdomains WHERE users.collegeId = academicdomains.academicId AND userId = ?";
$getDetails = $conn->prepare($query);
$getDetails->bind_param("i",$viewProfileID);
$getDetails->execute();
$getDetails->bind_result($userFullName,$userName,$userLevel,$userEmail,$userPhone,$userProfilePic,$academicsDomain);
$getDetails->fetch();
$getDetails->close();

$results+=["userFullName" => $userFullName,
    "userName" => $userName,
    "userLevel" => $userLevel,
    "userEmail" => $userEmail,
    "userPhone" => $userPhone,
    "userProfilePic" => $userProfilePic,
    "collegeName" => $academicsDomain
            ];

$query = "SELECT count(*) FROM followers WHERE followUser = ? ";
$getFollowerCount = $conn->prepare($query);
$getFollowerCount->bind_param("i",$viewProfileID);
$getFollowerCount->execute();
$getFollowerCount->bind_result($followerCount);
$getFollowerCount->fetch();
$getFollowerCount->close();
$results+=["followerCount" => $followerCount];

$getGroupCount = $conn->prepare($query);



$query = "SELECT count(*) FROM followers WHERE followingUser = ? AND followUser = ?";
$isFollowing  = $conn->prepare($query);
$isFollowing->bind_param("ii",$userID,$viewProfileID);
$isFollowing->execute();
$isFollowing->bind_result($isFollowingCount);
$isFollowing->fetch();
$isFollowing->close();

$results+=["isFollowing"=> $isFollowingCount]; //Expects only 0 or 1
echo json_encode($results);
?>