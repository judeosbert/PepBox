
/**
 * Created by jude on 28/9/16.
 */
function initializePage()
{
    $("#dashboard-group-content").hide();
    $("#dashboard-forum-content").hide();
    $("#dashboard-getUserGroups").click(function()
    {
        $("#dashboard-group-content").slideToggle();
    });
    $("#dashboard-getUserForum").click(function()
    {
        $("#dashboard-forum-content").slideToggle();
    });
}
function getBasicUserDetails() {
    $.ajax({

        url:"../assets/backend/dashboard/index.php",
        success:function(response)
        {
                jsonData = JSON.parse(response);
            $("#dashboard-followerCount").text(jsonData.followerCount);
            $("#notification-count").text(jsonData.notificationCount);
        },
        error:function(response)
        {
            alert("Failed");
        }
    });

}
function getDashboardPosts()
{


    $.ajax({
        url:"../assets/backend/dashboard/getDashboardPosts.php",
        success:function(response)
        {
            jsonData = JSON.parse(response);
            postCount = jsonData.postCount;
            posts = jsonData.data;
            if(postCount == -1)
            {

                    $("#user-postList").html("<li class='list-group-item'><p style='text-align: center;font-size: 30px; color:grey'>There is no post so far<br /><span style='font-size:15px;'>Please check back later </span></p></li>");
                    return;

            }
            for(var i = 1;i<=postCount;i++)
            {
                var index = "post"+i.toString();
                postParticular = posts[index];

                $("#user-postList").prepend("<li style='background: whitesmoke;' class='list-group-item'><div class='row'> <div class='col-lg-12 box-shadow no-border  card '><br /> <div class='card-content'> <div class=''> <div class='row'> <div class='col-lg-6'> <p> <img src='"+postParticular.userProfilePic+"' class='tile-img' alt='image'/> <a href='../view/?pid="+postParticular.postOwner+"'> <span>"+postParticular.userFullName+"</span> </a></p></div><div class='col-lg-6 text-lg-right'> <p class='small'><span id='dashboard-post-time'></span>&nbsp;<span id='dashboard-post-date'>"+postParticular.postCreationTime+"</span> </p></div><div class='col-lg-12'> <p id='dashboard-postContent'>"+postParticular.postContent+"</p></div></div></div></div><div class='card-user-action'> <p id='post-status' class='small'><span id='post-status-like-count-"+postParticular.postID+"'>"+postParticular.likes+"</span> Likes &nbsp; <span id='post-status-comment-count-"+postParticular.postID+"' class='post-status-comment-count'>"+postParticular.shares+"</span> Shares</p><ul class='list-inline'> <li class='list-inline-item'><button onClick='likePost("+postParticular.postID+")' class='btn btn-sm btn-primary'>Like</button> </li><li class='list-inline-item'><button onClick='sharePost("+postParticular.postID+")' class='btn btn-sm btn-primary'>Share</button></li><li class='list-inline-item'></li></ul> </div><br /></div></div></li>");

            }
        },
        error:function () {
            alert("Error");

        }
    });
}
function getUserGroups() {
    $.ajax({
       url:"../assets/backend/dashboard/getUserGroups/index.php",
        success:function(response)
        {
            jsonData = JSON.parse(response);
            var resultCount = jsonData.resultCount;
            $("#dashboard-groupCount").text(resultCount);
            for(var i =1 ; i<=resultCount;i++)
            {
                var index = "group"+String(i);
                var index2 = "groupID"+String(i);

                $("#user-group-list").append('<li class="list-group-item"><a href="../group/?groupID='+jsonData[index2]+'">'+jsonData[index]+'</a></li>');
            }
        },
        error:function()
    {
            alert("Error");
    }
    });
}
$(document).ready(function()
{
    // $("#search-bar").click(function()
    // {
    //    $("#search-modal").modal('toggle');
    // });

    $("#getNotifications").click(function () {
        $("#notificationList").html("<li class='list-group-item'></li>");

       $("#notification-modal").modal('toggle');
        $.ajax({
         url:"../assets/backend/getNotifications/index.php",
           success:function (response) {
            jsonData = JSON.parse(response);
               count = jsonData.resultCount;
               notifs = jsonData.data;
                if(count == 0)
                {
                    $("#notificationList").html('<li class="list-group-item text-lg-center"><h4>All Caught Up</h4><p class="small">We\'ll update you on any new notification</p></li>')
                }
               for(var i=1;i<=count;i++)
               {
                    index = "notif"+String(i);
                   notif = notifs[index];
                   $("#notificationList").append('<li class="list-group-item card"><div class="card-content"><p>'+notif.content+'@<span class="small"> '+notif.creationTime+'</span></p></div></li>')
               }
           },
           error:function()
           {
               alert("Error");
           }
       });

    });
    $("#group-subject").click(function()
    {


        $.ajax({
           url:"../assets/backend/getSubjects/index.php",
            success:function(response)
            {
                jsonData = JSON.parse(response);
                var subjectCount = jsonData.subjectCount;
                postData = jsonData.data;
                for(var i =1;i<=subjectCount;i++)
                {
                    var index="subject"+String(i);
                    subject = postData[index];
                    $("#group-subject").append($('<option>',{
                        value:subject.subjectID,
                        text:subject.subjectName
                    }));
                }
            },
            error:function(response)
            {
                alert("Error");
            }
        });
    });

    $("#createGroup").submit(function(e)
    {
       e.preventDefault();
        var groupName = $("#group-name").val();
        var subjectID = $("#group-subject").val();
        if(groupName.length == 0)
        {
            $("#error-msg").text("Please name your new group");

        }
        else
        {
            $.ajax( {
                url:"../assets/backend/dashboard/createGroup/index.php",
                method:"post",
                data:{"groupName":groupName,
                        "subjectID":subjectID},
                success:function(response)
                {
                    jsonData = JSON.parse(response);
                    if(jsonData.status == 1)
                    {
                        alert("Your group has been created");
                        $("#create-group").modal('hide');

                    }
                    else

                    {
                        alert("The grouo could not be created");
                    }
                },
                error:function()
                {
                    alert("Error");
                }
            });
        }
    });
$("#post-postBtn").click(function()
{

   var userPost= $("#user-post").val();
    if(userPost.length == 0 )
    {
        alert("Zero");
        return;
    }
    $.ajax({
       url:"../assets/backend/dashboard/addpost/index.php",
        method:"post",
        data:{"userPost":userPost},
        success:function(response)
        {
            jsonData = JSON.parse(response);
            if(jsonData.status == 1) {
                alert("Your status has been updated");
                $("#user-post").val("");
            }
            else
            {
                alert("Your status could not be updated");
            }
        },
        error:function(response)
        {
            alert("error");
        }
    });
});


    initializePage();
    getBasicUserDetails();
    getDashboardPosts();
    getUserGroups();
    setInterval(getDashboardPosts,5000);
    setInterval(getBasicUserDetails,5000);


});
