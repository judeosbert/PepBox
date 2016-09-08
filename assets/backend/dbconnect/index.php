<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 6/9/16
 * Time: 7:13 PM
 */
$host = "localhost";
$user = "root";
$pass = "root";
$db = "pepbox";

/*****************************CONFIG SECTION************************************************* /
 */error_reporting(1);                                                                      /*
 */                                                                                         /*
 */                                                                                         /*
 */                                                                                         /*
 */                                                                                         /*
 */                                                                                         /*
 */                                                                                          /*
 */                                                                                         /*
 */                                                                                          /*
 * ******************************************************************************************/

$conn = new mysqli($host,$user,$pass,$db);
{
if($conn->connect_error)
{
    echo "Error in Connection";
    exit();
}
session_start();
}



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}