/**
 * Created by jude on 26/9/16.
 */
$(document).ready(function()
{
$("#requestResetCode").submit(function(e)
{
    e.preventDefault();

    var userEmail = $("#userEmail").val();
    if(userEmail.length ==0)
    {
        $("#error-msg").text("Please enter a valid email ID");
        return;
    }
    $.ajax({
       url:"../../assets/backend/help/password/index.php",
        method:"post",
        data:{"userEmail":userEmail},
        success:function(response)
        {
            jsonData = JSON.parse(response);
            var result = jsonData.status;

            if(result == 3) {
                $(".reset-box-content").html("<h3>Reset code has been sent to your email.</h3>")
            }
            else if (result == 1)
            {
                $("#error-msg").text("Invalid Email Provided");
            }
            else if(result == 2)
            {
                $("#error-msg").text("This email ID is not registered with us");

            }
            else
            {
                $("#error-msg").text("An error has occured");
                //Notify developer of the error
            }
        },
        error:function(response)
        {
            $("#error-msg").text("Request Failed due to connection error");
        }
    });
});
});
