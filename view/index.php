<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 6/9/16
 * Time: 8:41 PM
 */
require("../assets/backend/dbconnect/index.php");
if(empty($_GET["pid"]))
{
    header("Location:../");
}
if($_GET["pid"] == $_SESSION["userId"])
{
    header("Location:../profile/");
}
setcookie("viewProfileID", $_GET["pid"], time() + 3600, "/");

?>
<!Doctype html>
    <html>
<head>
    <title> - PepBox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/extraStyleSheet.css" rel="stylesheet" />
    <link href="../assets/css/profilePage.css" rel="stylesheet" />
    <script src="../assets/js/jquery-3.1.0.min.js" ></script>
    <script src="../assets/js/bootstrap.min.js" ></script>
    <script src="../assets/js/ajax/viewProfile.js" ></script>
    <script>
        function followUser(userID) // Usage : onClick='followUser(56)'
        {

            if(userID <0)

            else
            {
                $.ajax(
                    {
                        url:"../assets/backend/followUser/index.php",
                        method:"post",
                        data:{"userID":userID},

                        success:function (response) {
                            jsonData = JSON.parse(response);
                            if(jsonData.status == 1) {
                                $("#user-followUser").text("Following");
                                var followCount = parseInt($("#user-followerCount").text());
                                followCount += 1;
                                $("#user-followerCount").text(followCount);

                            }else if(jsonData.status == 2) {
                                $("#user-followUser").text("Follow");
                                var followCount = parseInt($("#user-followerCount").text());
                                followCount -= 1;
                                $("#user-followerCount").text(followCount);

                            }else
                                alert("There has been an error. ");
                        },
                        error:function (response) {
                            alert("fail");
                        }
                    });
            }
        }
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length,c.length);
                }
            }
            return "";
        }
        function likePost(postID)
        {

            $.ajax({
                url:"../assets/backend/likePost/index.php",
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
               url:"../assets/backend/sharePost/index.php",
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
<body>
<div class="container-fluid">
    <div class="row">
    <div class="col-lg-3 col-sm-12 text-md-center text-lg-center text-sm-center profile-sidebar">
        <div class="row profile-header">
        <div class="profile-head">
            <div class="profile-head-elements">
                <div class="overlay">
                <br />
            <p><img id="user-profilepic" src="../assets/images/sampleProfilePic.png" class="profile-image" /> </p>
            <h4 class="user-full-name" id="user-fullName">-</h4>
            <p class="user-handle" id="user-userName">-</p>
            <p><button class="btn btn-primary btn-sm" id="user-followUser" onclick="followUser(getCookie('viewProfileID'))">Follow</button> </p>
        <br />
            </div>
            </div>
        </div>
            <div class="row" >

                <div class="col-lg-12 col-sm-12 text-lg-center top7">
                    <div class="col-lg-4 col-sm-4 border-right"><h4 id="user-followerCount">-</h4><p>Followers</p></div>
                    <div class="col-lg-4 col-sm-4 border-right"><h4>-</h4><p>Projects</p></div>
                    <div class="col-lg-4 col-sm-4 "><h4>-</h4><p>Groups</p></div>
                <br />
                    <p><img src="../assets/images/pepbox_black.png" class="small-logo" /> </p>
                </div>
            </div>
            <div class="row">

            </div>

        </div>


    </div>
        <div class="col-lg-9 col-sm-12">
            <div class="row">
                <div class="col-lg-12 profile-main-header">
                    <nav class="nav navbar-sticky-top top-nav-bar">
                        <div class="row" style="background:#025aa5;">
                            <div class="col-lg-12"><div class="top2"></div> </div>

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
                        <div class="col-lg-5">
                            <ul class="list-inline">
                                <li class="list-inline-item"><button id="getNotifications" style="background: #013F73;border-color: #013F73;" class="btn btn-primary">Notifications <span id="notification-count" class="tag">0</span> </button> </li>
                                <li class="list-inline-item"><a href="../logout.php"> <button  style="color:#fff;background: #013F73;border-color: #013F73;"class="btn  btn-outline-primary">Logout</button></a> </li>
                            </ul>
                        </div>
                </div>
                </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 top4"></div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <p class="font-weight-bold small">User Posts</p>
                    <ul class="list-group" id="user-postList">
                        <li class="list-group-item" style="display:none;"></li>
                    </ul>
                </div>
            </div>

        </div>

</div>
</div>
</body>
</html>

