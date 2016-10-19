<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 19/10/16
 * Time: 10:30 PM
 */
require("../dbconnect/index.php");
$groupID = $_COOKIE["viewGroupID"];


$query = "SELECT users.userId,userFullName FROM groupmembers,users WHERE groupId = ? AND groupmembers.userId = users.userId";
$getMembers = $conn->prepare($query);
$getMembers->bind_param("i",$groupID);
$getMembers->execute();
$getMembers->bind_result($memberID,$memberName);
$i=0;
$results=[];
$member=[];
$memberBulk=[];
while($getMembers->fetch())
{
    $i++;
    $member = ["memberID" => $memberID,
                "memberName" => $memberName];
    $memberBulk+=["member".$i => $member];

}
$results+=["resultCount" => $i,
            "data" =>$memberBulk];
echo json_encode($results);

