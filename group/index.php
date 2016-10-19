<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 17/10/16
 * Time: 8:35 PM
 */
require ("../assets/backend/dbconnect/index.php");
$groupID = $_GET["groupID"];
$userID = $_SESSION["userId"];
if(empty($groupID))
{
    header("Location:../dashboard/");
}
setcookie("viewGroupID", $groupID, time() + 3600, "/");
$_SESSION["groupLastPostID"]= 0;
$query = "SELECT groupName,subjectName FROM groups,subjects WHERE groups.subjectId = subjects.subjectId AND groupId = ?";
$getGroupBasics = $conn->prepare($query);
$getGroupBasics->bind_param("i",$groupID);
$getGroupBasics->execute();
$getGroupBasics->bind_result($groupName,$subjectName);
$getGroupBasics->fetch();
$getGroupBasics->close();
$query = " SELECT count(*) FROM groupmembers WHERE groupId = ?";
$getMemberCount = $conn->prepare($query);
$getMemberCount->bind_param("i",$groupID);
$getMemberCount->execute();
$getMemberCount->bind_result($memberCount);
$getMemberCount->fetch();
$getMemberCount->close();
$query = "SELECT count(*) FROM groupmembers WHERE groupId = ? AND userId = ?";
$results=[];
$isFollowing = $conn->prepare($query);
$isFollowing->bind_param("ii",$groupID,$userID);
$isFollowing->execute();
$isFollowing->bind_result($isFollow);
$isFollowing->fetch();
$isFollowing->close();

?>

<!Doctype html>
    <head>
    <title>Pepbox Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/extraStyleSheet.css" rel="stylesheet" />
    <link href="../assets/css/dashboardPage.css" rel="stylesheet" />
    <script src="../assets/js/jquery-3.1.0.min.js" ></script>
    <script src="../assets/js/bootstrap.min.js" ></script>
    <script src="../assets/js/ajax/group.js"></script>

    <script>
        function likePost(postID)
        {

            $.ajax({
                url:"../assets/backend/groups/likePost/index.php",
                method:"post",
                data:{"postID":postID},
                success:function(response){
                    jsonData = JSON.parse(response);
                    if(jsonData.status == 1)
                    {
                        var element = "#post-status-like-count-"+postID;
                        var presentLikeCount = parseInt($(element).text());
                        presentLikeCount+=1;
                        $(element).text(presentLikeCount);
                    }
                    else
                    {
                        alert("You have already liked this post");
                    }
                },
                error:function(response)
                {
                    alert("Error");
                }
            });
        }
        function sharePost(postID) {

            $.ajax({
                url:"../assets/backend/groups/sharePost/index.php",
                method:"post",
                data:{"postID":postID},
                success:function (response) {
                    jsonData = JSON.parse(response);
                    if(jsonData.status == 1)
                    {
                        var element = "#post-status-comment-count-"+postID;

                        var presentLikeCount = parseInt($(element).text());
                        presentLikeCount+=1;
                        $(element).text(presentLikeCount);
                        alert("The post has been shared");
                        getGroupPosts();
                    }
                    else
                    {
                        alert("The post could not be shared");
                    }
                },
                error:function () {
                    alert("Error");

                }
            });
        }
    </script>
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

                        <input id="search-bar" name="q" class="form-control" placeholder="Search in forums ,groups  or for students and teachers" />
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
                                <span class="little-text">
                                    <button class="btn btn-link" data-toggle="modal" data-target="#create-group">+ Create group</button></span>

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
                <div class="col-lg-12 card box-shadow no-border " style="background: #013F73;border-color: #013F73; color:#fff">
                    <div class="row">
                        <div class="col-lg-12"><br /></div>

                        <div class="col-lg-10 text-lg-center"><h4  ><?php echo $groupName; ?>&nbsp;&nbsp; <span><button id="getGroupMembers" class="btn-sm btn-link"><img src="../assets/images/ic_info_black_24px.svg" /> </button> </span></h4><p class="small">Group Topic-<?php echo $subjectName; ?></p></div>

                        <div class="col-lg-1">
                            <?php if($isFollow == 0){ ?>
                    <button id="group-follow" class="btn btn-primary " style="">Follow</button>
                            <?php }else {?>
                            <button id="group-follow" class="btn btn-primary " style="">Following</button>
                            <?php } ?>
                            <br/><br />
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10 text-lg-center">
                            <p class="small"><span id="group-member-count"><?php echo $memberCount;?></span> Members <span id="group-postCount">0</span> Posts </p>
                        </div>
                        <div class="col-lg-2"></div>
                    </div>
                </div>
                <div class="col-lg-12 card no-border maincontent-area">
                    <br />
                    <textarea class="form-control no-border user-post" id="user-post" placeholder="Write a post"></textarea>
                    <hr />
                    <div class="add-extra">

                        <ul class="list-inline-item">
                            <li class="list-inline-item"><button class="btn  btn-sm btn-primary">Add Photo</button></li>
                            <li class="list-inline-item"><button class="btn  btn-sm btn-primary">Add Place</button></li>
                            <li class="list-inline-item"><button class="btn  btn-sm btn-primary">Add Video</button></li>

                        </ul>
                        <button id="post-postBtn" class="btn btn-primary" style="float:right">Post</button>
                    </div>

                    <br />
                </div>


            </div>

            <div class="row">
                <div class="col-lg-12">
                    <p class="font-weight-bold small">User Posts</p>
                    <ul class="list-group" id="user-postList" >
                        <li class="list-group-item" style="display:none;"></li>
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

<div class="modal fade" id="groupMemberList" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">

        <div class="modal-content">
            <div class="modal-header">
                <h4>Group Members</h4>
            </div>
            <div class="modal-body">
                <ul id="memberList" class="list-group">
                    <li class="list-inline-item card"></li>

                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>

