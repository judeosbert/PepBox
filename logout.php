<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 17/10/16
 * Time: 10:26 AM
 */
require("assets/backend/dbconnect/index.php");

if(session_destroy())
{
    header("Location:index.php");
}