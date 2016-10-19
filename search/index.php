<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 18/10/16
 * Time: 8:14 PM
 */
    require ("../assets/backend/dbconnect/index.php");
$q = $_GET["q"];


if(!$_SESSION["loggedIn"])
{
    header("Location:../");
}
$query = "SELECT userId,userFullName,userLevel,academicdomains.collegeName,userProfilePic FROM users,academicdomains WHERE userFullName LIKE ? AND users.collegeId = academicdomains.academicId LIMIT 8";
$getStudents = $conn->prepare($query);
$q = "%".$q."%";
$getStudents->bind_param("s",$q);
$getStudents->execute();
$getStudents->bind_result($userID,$userFullName,$userLevel,$collegeName,$userProfilePic);



?>

<!Doctype html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <title>Pepbox Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/extraStyleSheet.css" rel="stylesheet" />
    <link href="../assets/css/dashboardPage.css" rel="stylesheet" />
    <script src="../assets/js/jquery-3.1.0.min.js" ></script>
    <script src="../assets/js/bootstrap.min.js" ></script>
    <script src="../assets/js/ajax/dashboard.js"></script>

</head>
<body style="background-color: whitesmoke;">
<div class="container-fluid">
    <nav class="nav navbar-sticky-top top-nav-bar">
        <div class="row" style="background:#025aa5;">
            <div class="col-lg-12"><div class="top2"></div> </div>
            <div class="col-lg-2">
                <p><img src="../assets/images/pepbox_white.png" class="small-logo" /> </p>
            </div>
            <div class="col-lg-7">
                <form action="../search/" method="get">
                    <div class="input-group">

                        <input id="search-bar" name="q" class="form-control" placeholder="Search in forums ,groups  or for students and teachers" value="<?php echo $_GET["q"]; ?>" />
                        <span class="input-group-btn">
                <button type="submit" class="btn btn-primary" style="background: #013F73;border-color: #013F73;">Search</button>
                </span>
                </form>
            </div>
        </div>
        <div class="col-lg-3">
            <ul class="list-inline">
                <li class="list-inline-item"><button id="getNotifications" style="background: #013F73;border-color: #013F73;" class="btn btn-primary">Notifications <span id="notification-count" class="tag">0</span> </button> </li>
                <li class="list-inline-item"><a href="../logout.php"> <button  style="color:#fff;background: #013F73;border-color: #013F73;"class="btn  btn-outline-primary">Logout</button></a> </li>
            </ul>
        </div>
</div>
</nav>

<div class="row">
    <div class="col-lg-2">
        <!--                Student Profile Section of photo name and edit profile button-->
        <div class="row">
            <div class="col-lg-12"><div class="top10"></div> </div>
            <div class="col-lg-12 text-lg-center">
                <p><a href="" ><img src="../assets/images/sampleProfilePic.png" class="card-img tile-img" /> <span id="dashboard-userFName"><?php echo $_SESSION["userFullName"]; ?></span></a></span> </p>


            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-inline">
                    <li class="list-inline-item"> <p>Followers <span id="dashboard-followerCount">120</span></p></li>
                    <li class="list-inline-item">|</li>

                    <li class="list-inline-item"> <p>Groups <span id="dashboard-groupCount">10</span></p></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card-title no-title" id="dashboard-getUserGroups">Groups</div>
                <div class="card no-border" id="dashboard-group-content">
                    <ul id="user-group-list" class="list-group content-list">
                        <li class="list-group-item ">
                            <span class="little-text"><button class="btn btn-link" data-toggle="modal" data-target="#create-group">+ Create group</button></span>

                        </li>
                        <span class="small text-lg-left font-weight-bold">Your Groups</span>
                        <li class="list-group-item"></li>


                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card-title no-title" id="dashboard-getUserForum">Question Forums</div>
                <div id="dashboard-forum-content">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="little-text">Android</span>
                        </li>
                        <li class="list-group-item">
                            <span class="little-text">Android</span>
                        </li>

                        <li class="list-group-item">
                            <span class="little-text">Android</span>
                        </li>
                        <li class="list-group-item">
                            <span class="little-text">Android</span>
                        </li>
                        <li class="list-group-item">
                            <span class="little-text">Computer Architecture </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-9  ">
        <!--            Main content area of the dashboard-->
        <div class="row">
            <div class="col-lg-12"><div class="top2"></div></div>


        </div>
        <div class="row">

        <div class="col-lg-12">
            <p class="small font-weight-bold">Students and Teachers</p>
            <ul class="list-inline">
                <?php
                $count =0;
                while($getStudents->fetch())
                {
                    $count++;
                ?>

                <li class="list-inline-item text-lg-center">

                    <div class="box-shadow card profile-tab">
                        <Br />
                        <p><img src="<?php echo $userProfilePic?>"   /> </p>
                        <h3><a href="../view/index.php?pid=<?php echo $userID?>"> <?php echo $userFullName; ?> </h3></a>
                        <p class="small "><?php if($userLevel == 0 ){echo "Student";} else{echo "Teacher";} ?> at <?php echo $collegeName; ?></p>
                        <a href="../view/index.php?pid=<?php echo $userID ;?>"><button class="btn btn-primary btn-sm">View</button></a>
                        <br /><Br />

                        </div>
                </li>
                <?php }


                if($count == 0)
                {
                    echo "<p class='text-lg-center font-weight-bold'>No user was found with this name</p>";
                }?>
                    </div>

            </ul>


        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="small font-weight-bold">Groups</p>
                <ul class="list-inline">

                    <?php

                    $query = "SELECT groupId,groupName,subjectName,subject_Icon FROM groups,subjects WHERE groupName LIKE ? AND groups.subjectId=subjects.subjectId LIMIT 8";
                    $getGroups = $conn->prepare($query);
                    $qw = $_GET["q"]."%";
                    $getGroups->bind_param("s",$q);
                    $getGroups->execute();
                    $getGroups->bind_result($groupId,$groupName,$subjectName,$subjectIcon);
                    $count =0;
                    while($getGroups->fetch())
                    {$count++;
                    ?>

                    <li class="list-inline-item text-lg-center">

                        <div class="box-shadow card profile-tab">
                            <Br />
                            <p><img src="<?php echo $subjectIcon?>"   /> </p>
                            <h3><a href="../group/index.php?groupID=<?php echo $groupId?>"> <?php echo $groupName; ?> </h3></a>
                            <p class="small "><?php echo $subjectName; ?></p>
                            <a href="../group/index.php?groupID=<?php echo $groupId;?>"><button class="btn btn-primary btn-sm">View</button></a>
                            <br /><Br />

                        </div>
                    </li>
                    <?php }
                    $count = $conn->affected_rows;

                    if($count == 0)
                    {
                        echo "<p class='text-lg-center font-weight-bold'>No group was found with this name</p>";
                    }?>
                </ul>
                </div>
        </div>


    </div>


</div>



</div>

<div class="modal fade" id="create-group" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">
                <h5>Create a new group</h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row card">
                        <div class="col-lg-3 text-lg-center">
                            <p><img src="../assets/images/create_group.png"  style="height:80px;"/></p>
                        </div>
                        <div class="col-lg-9">
                            <p class="small"><br />Groups are great for getting things done and staying in touch with just the people you want. Share photos and videos, have conversations, make plans and more.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="createGroup">
                                <p class="font-weight-bold small">Name Your Group</p>
                                <input id="group-name" class="form-control" placeholder="" />
                                <div class="top2"></div>
                                <select class="form-control" id="group-subject">
                                    <option selected disabled class="form-control">Select your group topic</option>

                                </select>
                                <p class="small alert-danger" id="error-msg"></p>
                        </div>
                        <div class="col-lg-12 text-lg-center" >
                            <br/>
                            <button type="submit" class="btn btn-primary btn-sm">Create Group</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="notification-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">

            <div class="modal-content">
                <div class="modal-header">
                    <h4>Notifications</h4>
                </div>
                <div class="modal-body">
                    <ul id="notificationList" class="list-group">
                        <li class="list-inline-item card"></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

