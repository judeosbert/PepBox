/**
 * Created by jude on 15/10/16.
 */
$(document).ready(function()
{

    function initializePage()
    {


        $.ajax({

            url:"../assets/backend/view/index.php",
            method:"post",
            success:function(response)
            {

                jsonData = JSON.parse(response);
                $("#user-fullName").text(jsonData.userFullName);
                userFullNameV = jsonData.userFullName;


                $(document).prop('title',jsonData.userFullName+" - PepBox");
                $("#user-userName").text(jsonData.userName);
                $("#user-profilepic").attr('src',jsonData.userProfilePic);
                userProfilePicV = jsonData.userProfilePic;
                $("#user-followerCount").text(jsonData.followerCount);
                if(jsonData.isFollowing == 1)
                {
                    $("#user-followUser").text("Following");
                }
                else
                {
                    $("#user-followUser").text("Follow");
                }

            },
            error:function (response) {
             alert("Error");
            }
        });

        getUserPosts();
    }


    function getUserPosts()
    {


            $.ajax({
               url:"../assets/backend/view/getUserPosts.php",
                success:function(response)
                {
                    jsonData = JSON.parse(response);
                    postCount = jsonData.postCount;
                    posts = jsonData.data;
                    if(postCount == 0)
                    {
                        $("#user-postList").append("<li class='list-group-item'><p style='text-align: center;font-size: 30px; color:grey'>There is no post so far<br /><span style='font-size:15px;'>Please check back later </span></p></li>");
                        return;
                    }
                    for(var i = 1;i<=postCount;i++)
                    {
                        var index = "post"+i.toString();
                        postParticular = posts[index];
                        // postParticular.postContent
                    $("#user-postList").append("<li class='list-group-item'><div class='row'> <div class='col-lg-12 box-shadow maincontent-area card no-border'> <br /><div class='card-content'> <div class=''> <div class='row'> <div class='col-lg-6'> <p> <img src='"+$("#user-profilepic").attr('src')+"' class='tile-img' alt='image'/> <span>"+$("#user-fullName").text()+"</span> </p></div><div class='col-lg-6 text-lg-right'> <p class='small'><span id='dashboard-post-time'></span>&nbsp;<span id='dashboard-post-date'>"+postParticular.postCreationTime+"</span> </p></div><div class='col-lg-12'> <p id='dashboard-postContent'>"+postParticular.postContent+"</p></div></div></div></div><div class='card-user-action'> <p id='post-status' class='small'><span id='post-status-like-count-"+postParticular.postID+"'>"+postParticular.likes+"</span> Likes &nbsp; <span id='post-status-comment-count-"+postParticular.postID+"' class='post-status-comment-count'>"+postParticular.shares+"</span> Shares</p><ul class='list-inline'> <li class='list-inline-item'><button onClick='likePost("+postParticular.postID+")' class='btn btn-sm btn-primary'>Like</button> </li><li class='list-inline-item'><button onClick='sharePost("+postParticular.postID+")' class='btn btn-sm btn-primary'>Share</button></li><li class='list-inline-item'></li></ul> </div><br /></div></li>");

                    }
                },
                error:function () {
                    alert("Error");

                }
            });
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
    initializePage();
});