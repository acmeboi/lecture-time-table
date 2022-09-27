<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>THE POLYTECHNIC BALI COURSE TIMETABLE</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="css/style.css" rel="stylesheet" type="text/css"></link>
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css"></link>
        <link href="bootstrap/dist/css/bootstrap.css" rel="stylesheet" type="text/css"></link>
        
    </head>

    <body class="" style="background-color: #D6D6D6 !important;">
        <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
            <div class="card col-12 col-lg-4">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-start">
                        <img src="Image/logo.png" class="m-3" style="width: 30px; height: 30px;" />
                        <h5 class="d-flex align-items-center justify-content-center m-0 p-0">
                            <span class="w-100 text-center">
                                The Federal Polytechnic Bali <br />
                                <small><i>Course Time Table</i></small>
                            </span>
                        </h5>
                    </div>
                </div>
                <form class="form-horizontal" method="post" action="login_process.php?login_authentication">
                    <div class="card-body py-3">
                        <h3 class="d-flex align-items-center justify-content-center py-3 p-1">
                            <span>Authentication</span>
                        </h3>
                        <div class="w3-container alert-danger w3-padding w3-margin w3-round w3-hide" id="error">
                            Wrong Username or Password
                            <div class="w3-large w3-closebtn" onclick="$('#error').addClass('w3-hide')">X</div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input class="form-control" name="username" placeholder="Username" type="text" required />
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-key"></i></span>
                            <input class="form-control" name="password" placeholder="Password" type="password" required />
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success" value="Save" id="save"><i class="fa fa-sign-in"></i>&nbsp;Login</button>
                        <button type="reset" class="btn btn-danger" value="Reset"><i class="fa fa-repeat"></i>&nbsp;Reset</button>
                    </div>
                </form>
            </div>
        </div>
<!--        <div class="w3-container w3-margin">
            <div id="" class="w3-modal w3-animate-opacity">
                <div class="w3-modal-content w3-card-8 w3-col l3 w3-round" style="left:40%;">
                    <div class=" w3-center" style="top:3%;">
                        <h3>--- System Login ---</h3>
                        <hr />
                        <div class="w3-container alert-danger w3-padding w3-margin w3-round w3-hide" id="error">
                            Wrong StaffID or Password
                            <div class="w3-large w3-closebtn" onclick="$('#error').addClass('w3-hide')">X</div>
                        </div>
                        <form class="w3-form" id="login_form" action="javascript:void(0)">
                            <div class="w3-container">
                                <div class="w3-col l2 w3-padding">
                                    <i class="fa fa-user w3-xlarge"></i>
                                </div>
                                <div class="w3-col l9">
                                    <input type="text" class="w3-input" id="userid" placeholder="User ID" required  />
                                </div>
                            </div>
                            <br />
                            <div class=" w3-container">
                                <div class="w3-col l2 w3-padding">
                                    <i class="fa fa-key w3-xlarge"></i>
                                </div>
                                <div class="w3-col l9">
                                    <input type="password" class="w3-input" id="password" placeholder="Password" required  />
                                </div>
                            </div>

                            <hr />

                            <button type="submit" class="btn btn-success" value="Save" id="save"><i class="fa fa-sign-in"></i>&nbsp;Login</button>
                            <button type="reset" class="btn btn-danger" value="Reset"><i class="fa fa-repeat"></i>&nbsp;Reset</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>-->
    </body>
    <script src="js/jquery.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/loginscript.js"></script>
</html>