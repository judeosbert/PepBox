<!doctype html>
<html>
<head>
    <title>Pepbox Signup</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/extraStyleSheet.css" rel="stylesheet" />
    <link href="../assets/css/signup.css" rel="stylesheet" />
    <script src="../assets/js/jquery-3.1.0.min.js" ></script>
    <script src="../assets/js/bootstrap.min.js" ></script>
    <script src="../assets/js/ajax/signup.js"></script>
</head>
<body  >
    <div class="container-fluid">
        <div class="row ">
            <div class="overlay">
            <div class="col-lg-6 text-lg-center  col-sm-12 text-sm-center bg_img">

                <div class="top35 ">
                <p ><img style="height:150px;" src="../assets/images/pepbox_white.png"></p>
                </div>
                <div class="top43"></div>

            </div>
            </div>
        
            <div class="col-lg-6 col-sm-12 text-sm-center signup-form">
                <h2 class="top25">Create your Account</h2>
                <form id="signup_form">
                    <p id="error-msg"></p>
                    <input required type="text" id="userFullName" class="form-control top7" placeholder="Full Name" />
                    <select required class="form-control top3" id="accountType">
                    <option value="" disabled selected>Type of account</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    </select>
                    <input required type="email" class="form-control top3" id="userEmail" placeholder="Email ID" />
                    <input required type="password" class="form-control top3" id="userPassword" placeholder="Password" />
                    <input required type="password" class="form-control top3" id="userPasswordConf" placeholder="Confirm Password" />

                    <div class="text-lg-center">   
                    <button class="btn btn-primary top7" type="submit">Signup</button>
                            <br /><br />
                        <a href="../"> <button class="btn btn-outline-primary btn-sm">Already on PepBox? Sign In</button></a>
                    </div>                
                </form>
                <div class="col-lg-12 top12">
            </div>

        </div>
    </div>
</body>
</html>