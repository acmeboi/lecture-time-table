<!DOCTYPE>
<?php
include('session.php');
include('classes.php');
$db = new newclass();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>THE POLYTECHNIC BALI COURSE TIMETABLE</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css"></link>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"></link>
        <style>
            .sidebarwidth{
                width:250px;
            }
            .margin_top{
                margin-top:20%;
            }
        </style>
    </head>

    <body class="">

        <nav class="w3-sidenav w3-collapse w3-white  w3-animate-left sidebarwidth w3-border-right" id="mySidenav">
            <a href="#" class=" w3-container w3-center w3-padding w3-green" id="banner">
                <p class="d-flex align-items-center justify-content-center">
                    <span style="font-size: 14px; font-weight: 700; line-height: 10px">THE POLYTECHNIC BALI</span>
                    <span class="w3-opennav w3-large w3-hide-large w3-right" onclick="w3_open()">X</span>
                </p> 
                <img class="w3-white w3-round-jumbo" src="Image/logo.png" style=" margin-bottom:-15%; padding: 10px 10px;" />
            </a>
            <br /><br />
            <div class="side-menu">
                <?php include './menu_list.php'; ?>
            </div>
        </nav>

        <div class="w3-main" style="margin-left:250px">
            <header class="w3-container w3-green">
                <div class="w3-container w3-center w3-padding w3-green" >
                    <p id="header">
                        <span  class="w3-hide-large w3-left" style="font-size:16px;">THE POLYTECHNIC BALI</span>
                        <span class="w3-opennav w3-xxlarge w3-hide-large w3-right" onclick="w3_open()">&#9776;</span>
                        <h5 class="w3-left"><span id="header_text">THE POLYTECHNIC BALI COURSE TIMETABLE</span></h5>
                    </p>   
                </div>   
            </header>

            <div class="w3-container w3-margin w3-padding-12 w3-border w3-border-green w3-round alert-success">
                <i class="fa fa-file w3-xlarge"></i> &nbsp; Add/View Staff
            </div>

            <div class="w3-container" style="margin-bottom:3%;">
                <div class="w3-col l4 s12" style="padding: 10px 10px">
                    <div class="my-card" style="padding: 10px 10px">
                        <h3 class="w3-center">New Staff Form</h3>
                        <div class="w3-container alert-danger w3-padding w3-margin w3-round w3-hide" id="error">Record Exist
                            <div class="w3-large w3-closebtn" onclick="$('#error').addClass('w3-hide')">X</div>
                        </div>
                        <form class="w3-form" action="javascript:void(0)" id="form1">
                            <input type="text" id="staffID" class=" w3-hide" />
                            <input type="text" class="w3-input" pattern="^((FPB/)?(S/P/)?\d{3})+$" id="sID" placeholder="Staff ID" required  />
                            <input type="text" class="w3-input" id="surname" pattern="^[a-zA-Z]+$" placeholder="Surname" required  />
                            <input type="text" class="w3-input" id="first_name" pattern="^[a-zA-Z]+$" placeholder="First Name" required  />
                            <input type="text" class="w3-input" id="middle_name" pattern="^[a-zA-Z]+$" placeholder="Middle Name" required  />
<!--                            <select class="w3-select" id="department" required>
                            </select>-->
                            <input type="text" value="<?= $department_id ?>" id="department" class=" w3-hide" />
                            <select class="w3-select" id="rank" required>
                                <option selected="selected" value="">--Select Rank--</option>
                                <option value="HOD">HOD</option>
                                <option value="HOD">DEO</option>
                                <option value="HOD">Lecturer</option>
                            </select>
                            <select class="w3-select" id="gender" required>
                                <option selected="selected" value="">--Select Gender--</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <br /><br />
                            <input type="submit" class="w3-green w3-round w3-btn" value="Add" id="add" />
                            <input type="reset" value="Reset" class="w3-btn w3-round w3-red" id="cancel" />
                        </form>
                    </div>
                </div>
                
                <div class="w3-col l8" style="min-height: 65vh; overflow-y:hidden; overflow-x: hidden; padding: 10px 10px;">
<!--                    <a href="processor.php?delete_user" onclick="return confirm('Are you sure to delete this user')">Delete</a>-->
                    <div class="my-card" id="staff_display" style="padding: 10px 10px">
                        
                    </div>
                </div>
            </div>

            <footer class="w3-container w3-bottom alert-success w3-border-green w3-border-top">
                <h5>By ST/CS/HND/20/002</h5>

            </footer>

        </div>

        <div id="delet_model" class="w3-modal w3-hide w3-animate-opacity">
            <div class="w3-modal-content w3-card-8 w3-col l3" style="left:40%; top:20%;">
                <div class="w3-container">
                    <p class="w3-center"><i class="fa fa-trash w3-xxxlarge w3-text-red"></i></p>
                    <p class="w3-center"><h4 class="alert-danger w3-round w3-padding">Delete This Record <big class="w3-closebtn">!</big></h4></p>
                    <p>
                        <h4 class="w3-center" id="sureDetail"></h4>
                        <input type="text" id="staffIDtxt" class="w3-hide" />
                    </p>
                    <p class="w3-center"><button id="yes" class="w3-btn w3-round">Yes</button>&nbsp;&nbsp;<button id="no" class="w3-btn w3-round" onclick="$('#delet_model').addClass('w3-hide')">No</button>
                </div>
            </div>
        </div>
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/script.js"></script>
        <script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script>
                function w3_open() {
                    $('#mySidenav').slideToggle();
                    $('#header').slideToggle('w3-text-green');
                    $('#header_text').slideToggle('w3-text-green')
                }
        </script>
    </body>
</html>