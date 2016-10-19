<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 6/9/16
 * Time: 10:52 AM
 */
require ("assets/backend/dbconnect/index.php");
if($_SESSION["loggedIn"])
{
    header("Location:dashboard/");
}

?>
<!Doctype html>
    <html>
<head>
    <title>PepBox Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/extraStyleSheet.css" rel="stylesheet" />
    <link href="assets/css/loginPage.css" rel="stylesheet" />
    <script src="assets/js/jquery-3.1.0.min.js" ></script>
    <script src="assets/js/bootstrap.min.js" ></script>
    <script src="assets/js/ajax/signin.js" ></script>
</head>
<body style="background: #F9F9F9;">
<div class="container " >
    <div class="row">
        <div class="col-lg-12 col-sm-12 text-sm-center text-lg-left text-md-center">
            <p><img style="margin-left: -50px;" class=" top1 logo-img" src="assets/images/pepbox_black.png" /></p>
        </div>
    </div>
    <div class="row " style="margin-top: -20px;">

        <div class="col-lg-8 col-sm-12 text-lg-center text-md-center text-sm-center" style="margin-top: -20px;background:url(assets/images/singinPage.jpg)no-repeat center center fixed;background-size: contain;">

            <div class="signup-text top11" style="color:white">
                <br />
            <h1 class="text-lg-left promote-head">Connecting students and teachers</h1>
                <p class="text-lg-left promote-text" >An integrated platform for student and teachers to build personal projects, get guidance, exchange ideas and work together.</p>
                <a href="signup/"><button class="btn btn-primary" title="Signup to PepBox">New to Pepbox?</button></a>
            </div>

            <div class="top28"></div>
        </div>

        <div class="col-lg-4 col-sm-12  " style="background: white;margin-top: -20px;">
            <div class="login-form top30 text-lg-center">
                <h1>Welcome!</h1>
                <p id="error-msg"></p>
                <div class="form-elements top7">
                <form id="login-form">
                    <input type="email" required id="loginemail" class="form-control rounded-input" placeholder="Email ID" />
                    <input type="password" required id="loginpassword" class=" top5 form-control rounded-input" placeholder="Password" />
                    <p>
                        <ul class="list-inline">
                        <li class="list-inline-item"><button class=" top7 btn btn-primary" title="Signup to PepBox">Log in</button></li>

                    </ul>
                    </p>

                    <a href="help/password/index.php" class="btn btn-link">Forgot Password</a>
                </form>
                </div>

            </div>
            <div class="col-lg-12 top12">
        </div>
        <div class="col-lg-12 top33">
    </div>





    </div>
</div>
</body>
</html>
