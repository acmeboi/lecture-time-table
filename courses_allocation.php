<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Semester Time Table Scheduling System</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/script.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap.js"></script>
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
                <p><small>FEDERAL POLYTECHNICH BALI</small><span class="w3-opennav w3-large w3-hide-large w3-right" onclick="w3_open()">X</span></p> 
                <img class="w3-white w3-round-jumbo" src="Image/logo.png" style=" margin-bottom:-15%;" />
            </a>
            <br /><br />
            <a href="index.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green" >Dashboard</a>
            <a href="add_view_department.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Add Department</a>
            <a href="reg_view_staff.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green" >Register/View Staff</a>
            <a href="add_view_courses.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Add/View Courses</a>
            <a href="courses_allocation.php" class="w3-padding w3-border-bottom w3-border-green alert-success">Courses Allocation</a>
            <a href="time_table_schedulling.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Schedul Time Table</a>
            <a href="print_timetable.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Print Time Table</a>
            <a href="logout.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Logout</a>
        </nav>

        <div class="w3-main" style="margin-left:250px">
            <header class="w3-container w3-green">
                <div class="w3-container w3-center w3-padding w3-green" >
                    <p id="header">
                        <span  class="w3-hide-large w3-left" style="font-size:16px;">FEDERAL POLYTECHNICH BALI</span>
                        <span class="w3-opennav w3-xxlarge w3-hide-large w3-right" onclick="w3_open()">&#9776;</span>
                        <h5 class="w3-left"><span id="header_text">Semester Time Table Scheduling System</span></h5>
                    </p>   
                </div>   
            </header>

            <div class="w3-container w3-margin w3-padding-12 w3-border w3-border-green w3-round alert-success">
                <i class="fa fa-share w3-xlarge"></i> &nbsp; Course Allocation
            </div>

            <div class="w3-container" style="margin-bottom:3%;">
                <div class="w3-col l3 w3-border-green w3-rightbar">

                    <div class="w3-container alert-danger w3-padding w3-margin w3-round w3-hide" id="error">Record Exist
                        <div class="w3-large w3-closebtn" onclick="$('#error').addClass('w3-hide')">X</div>
                    </div>
                    <form class="w3-form" action="javascript:void(0)" id="allocate_form">
                        <input type="text" id="aID" class="w3-hide"  />
                        <select class="w3-select" id="department" onchange="courses_list(), get_allocated_course(), get_department_allocated_course()" required>
                            <option selected="selected" value="">--Select Department--</option>
                        </select>
                        <hr class="w3-border-green w3-bottombar" />
                        <h3>Allocate Course</h3>
                        <select class="w3-select" id="courses" required>
                            <option selected="selected" value="">--Select Course--</option>
                        </select>
                        <input type="text" class="w3-input" pattern="^[0-9,'/',0-9]+$" id="session" placeholder="Academic Session" required  />
                        <br /><br />
                        <input type="submit" class="w3-green w3-round w3-btn" value="Allocate" id="btn_allocate" />
                        <input type="reset" value="Reset" class="w3-btn w3-round w3-red" id="btn_department_cancel" />
                    </form>
                </div>


                <div class="w3-col w3-margin l8" id="allocated_courses_display" style="max-height:10%; height:450px; overflow:scroll;" onclick="$("#delet_model").">
                    <img src="Image/allocated_course_NoRecordFound.png" style="max-width:66.66666%; min-width:20%;" />
                </div>
            </div>

            <footer class="w3-container w3-bottom alert-success w3-border-green w3-border-top">
                <h5>Design By COM/ND/15/002</h5>

            </footer>

        </div>

        <div id="delet_allocated_course_model" class="w3-modal w3-hide w3-animate-opacity">
            <div class="w3-modal-content w3-card-16 w3-round w3-col l3" style="left:40%; top:20%;">
                <div class="w3-container">
                    <p class="w3-center"><i class="fa fa-trash w3-xxxlarge w3-text-red"></i></p>
                    <p class="w3-center"><h4 class="alert-danger w3-round w3-padding">Delete This Record <big class="w3-closebtn">!</big></h4></p>

                    <p>
                        <h4 class="w3-center" id="sureDetail"></h4>
                        <input type="text" id="aID" class="w3-hide" />
                    </p>
                    <p class="w3-center"><button id="alc_yes" class="w3-btn w3-round">Yes</button>&nbsp;&nbsp;<button id="no" class="w3-btn w3-round" onclick="$('#delet_allocated_course_model').addClass('w3-hide')">No</button>
                </div>
            </div>
        </div>
        <script src="js/jquery.dataTables.min.js"></script>
        <script src="js/dataTables.bootstrap.min.js"></script>
        <script src="js/dataTables.bootstrap.js"></script>
        <script>
                    function w3_open() {
                        $('#mySidenav').slideToggle();
                        $('#header').slideToggle('w3-text-green');
                        $('#header_text').slideToggle('w3-text-green')
                    }
                    $(document).ready(function () {
                        $('#dataTables-courses').DataTable({
                            responsive: true
                        });
                    });
        </script>

    </body>
</html>