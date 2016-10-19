<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 19/10/16
 * Time: 6:48 PM
 */

require("../dbconnect/index.php");
$userID= $_SESSION["userId"];
$query="SELECT notificationId,content,creationTime FROM notifications WHERE recipient = ? AND readStatus = 0";
$getNotifs = $conn->prepare($query);
$getNotifs->bind_param("i",$userID);
$getNotifs->execute();
$getNotifs->bind_result($notificationID,$content,$creationTime);
$results=[];
$notif=[];
$notifBulk=[];
$i=0;
$notifs=[];
while($getNotifs->fetch())
{   $i++;
    $notif = ["content" => $content,
            "creationTime" => $creationTime];
    $notifBulk+=["notif".$i => $notif];
    array_push($notifs,$notificationID);


}
$results+=["resultCount" => $i,
            "data" => $notifBulk];
echo json_encode($results);
$getNotifs->close();

$query = "UPDATE notifications SET readStatus = 1 WHERE notificationId = ?";
$updateStatus = $conn->prepare($query);
for($k=0;$k<$i;$k++)
{
    $updateStatus->bind_param("i",$notifs[$k]);
    $updateStatus->execute();
}
$updateStatus->close();


