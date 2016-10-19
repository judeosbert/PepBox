<?php

require ("../dbconnect/index.php");

$query = "SELECT subjectId,subjectName FROM subjects";
$getGroups = $conn->prepare($query);
$getGroups->execute();
$getGroups->bind_result($subjectID,$subjectName);
$subjects=[];
$results=[];
$subjectBulk=[];
$i=0;
while($getGroups->fetch())
{
    $i++;
    $subjects=["subjectID" => $subjectID,
                "subjectName" => $subjectName];
    $subjectBulk+=["subject".$i => $subjects];
}
$results+=["subjectCount" => $i];
$results+=["data" => $subjectBulk];
$getGroups->close();
echo json_encode($results);

