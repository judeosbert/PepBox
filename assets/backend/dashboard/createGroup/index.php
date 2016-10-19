<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 17/10/16
 * Time: 10:48 AM
 */
require("../../dbconnect/index.php");

$userID = $_SESSION["userId"];
$groupName = $_POST["groupName"];
$subjectID = $_POST["subjectID"];

$query = "INSERT INTO groups(groupName, subjectId, creationTime, groupOwner) VALUES(?,?,?,?) ";
$addGroup = $conn->prepare($query);
$addGroup->bind_param("sisi",$groupName,$subjectID,date("Y-m-d H:i:s"),$userID);
$results=[];
$groupID = 0;
if($addGroup->execute())
{
    $results+=["status" => 1];
    $groupID = $conn->insert_id;
}
else
{
    $results+=["status" => 0];
}
$addGroup->close();

if($results["status"] == 1)
{
    $query = "INSERT INTO groupmembers (groupId, userId) VALUES (?,?)";
    $addMember = $conn->prepare($query);
    $addMember->bind_param("ii",$groupID,$userID);
    if($addMember->execute())
    {
        $results["status"] = 1;
    }
    else{
        $results["status"] = 0;
    }
    $addMember->close();
}
echo json_encode($results);
