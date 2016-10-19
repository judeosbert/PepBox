<?php

require("../../dbconnect/index.php");
$userID = $_SESSION["userId"];
$query = "SELECT groups.groupId,groups.groupName FROM groups,groupmembers WHERE groupmembers.userId = ? AND groupmembers.groupId = groups.groupId ";
$getGroups = $conn->prepare($query);
$getGroups->bind_param("i",$userID);
$getGroups->execute();
$getGroups->bind_result($groupID,$groupName);
$results=[];
$i=0;
while($getGroups->fetch())
{
    $i++;
    $results+=["group".$i => $groupName,"groupID".$i => $groupID];

}
$results+=["resultCount" => $i];
$getGroups->close();
echo json_encode($results);



