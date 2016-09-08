/**
 * Created by jude on 7/9/16.
 */
$(document).ready(function()
{
   $("#login-form").submit(function(e)
   {
    e.preventDefault();
       var email = $("#loginemail").val();
       var password = $("#loginpassword").val();
       if(password.length <8)
       {
           $("#error-msg").text("Password should be atleast 8 chars");
           return;
       }
       //Sending data for user login
       $.ajax(
           {
            method:"post",
               url:"assets/backend/signin/index.php",
               data:{"email":email,
                    "password":password},
               success:function(result)
               {
                   jsonData = JSON.parse(result);
                   status = jsonData.status;
                   if(status == 1)
                   {
                       location.replace("dashboard/");
                   }
                   else
                   {
                       $("#error-msg").text("Please check your Email and Password");
                   }
               },
               error:function(result)
               {

               }
           }
       );
   });
});