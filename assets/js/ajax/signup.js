/**
 * Created by jude on 7/9/16.
 */
$(document).ready(function()
{
    $("#signup_form").submit(function(e) {
        e.preventDefault();

   var userFullName = $("#userFullName").val();
    var accountType = $("#accountType").val();
    var userEmail = $("#userEmail").val();
    var userPassword = $("#userPassword").val();
    var userPasswordConf = $("#userPasswordConf").val();
        if(userPassword != userPasswordConf)
        {
            $("#error-msg").text("Password and Confirmation Password should be the same.");
            return;
        }
    if(userPassword.length<8)
    {
        $("#error-msg").text("Password should be atleast 8 chars");
        return;
    }
    //Sending data to ajax
        $("#submit-button").text("Signing up");
        $.ajax({
           method:"post",
            url:"../assets/backend/signup/index.php",
            data:{"userFullName":userFullName,
                    "accountType":accountType,
                    "userEmail":userEmail,
                    "userPassword":userPassword},
            success:function(result)
            {
                jsonData = JSON.parse(result);
                var status = jsonData.status;
                if(status == 1)
                {
                    location.replace("../");
                }
                else if(status == 2)
                {
                    $("#error-msg").html("The Email is already taken&nbsp;<a href='../'>Login</a>");
                    $("#submit-button").text("Sign Up");
                }
                else if(status == 3)
                {
                    $("#error-msg").text("Your college is not registered with us.");
                    $("#submit-button").text("Sign Up");
                }
                else
                {

                    $("#error-msg").text("An error has occured. Please try again");
                    $("#submit-button").text("Sign Up");
                }
            },
            error:function()
            {
                $("#submit-button").text("Try Again");
                alert("Failed");
            }
        });
    });
});
