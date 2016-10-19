<?php
/**
 * Created by PhpStorm.
 * User: jude
 * Date: 26/9/16
 * Time: 10:50 AM
 */
?>
<!Doctype html>
<html>
<head>
    <title>PepBox Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../../assets/css/extraStyleSheet.css" rel="stylesheet" />
    <link href="../../../assets/css/loginPage.css" rel="stylesheet" />
    <script src="../../../assets/js/jquery-3.1.0.min.js" ></script>
    <script src="../../../assets/js/bootstrap.min.js" ></script>
    <script src="../../../assets/js/ajax/password.js" ></script>
</head>

<body style="background: #F9F9F9;">
<div class="container">
    <div class="row">
        <div class="col-lg-12 top5 "></div>
        <div class="col-lg-4"></div>
        <div class="col-lg-4 text-lg-center">
            <p><A href="../../../index.php"> <img src="../../../assets/images/pepbox_black.png" class="small-logo" /> </A></p>
            <h3>Reset your password</h3>
            <div class="card text-lg-center">
                <div class="reset-box-content" style="padding: 5%;">
                    <form id="reset-password-form">
                        <input class="form-control" id="password" placeholder="Enter your new password" type="password" />
                        <input  class="form-control top3" type="password" id="conf-password" placeholder="Confirm your new password" />
                        <button id="change-password"  type="submit" class="btn btn-primary btn-sm top3" >Change password</button>
                    </form>
                </div>

            </div>
            <p class="small">Setting a strong password can help your account from being compromised. Follow
            the <a href="">password guidlines</a>.</p>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>
</body>
</html>
