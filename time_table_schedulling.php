<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>THE POLYTECHNIC BALI COURSE TIMETABLE</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="css/dataTables.responsive.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <style>
            .sidebarwidth{
                width:250px;
            }
            .margin_top{
                margin-top:20%;
            }
        </style>
    </head>

    <body class="" ng-app="download" ng-controller="myCtrl">
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
                        <span  class="w3-hide-large w3-left" style="font-size:16px;">THE POLYTECHNICH BALI</span>
                        <span class="w3-opennav w3-xxlarge w3-hide-large w3-right" onclick="w3_open()">&#9776;</span>
                        <h5 class="w3-left"><span id="header_text">THE POLYTECHNIC BALI COURSE TIMETABLE</span></h5>
                    </p>   
                </div>   
            </header>

            <div class="w3-container w3-margin w3-padding-12 w3-border w3-border-green w3-round alert-success">
                <div class="w3-container w3-col l7"><i class="fa fa-calendar w3-xlarge"></i> &nbsp;Time Table Schedulling</div>
                <div class="w3-container w3-col l5 w3-center" style="font-size:20px;" id="loger">&nbsp;</div>
            </div>

            <div class="w3-container" style="margin-bottom:3%;">
                <div class="w3-col l3 s12" style="padding: 10px 10px">
                    <div class="my-card" style="padding: 10px 10px">
                    <div class="alert-danger w3-padding w3-margin w3-round" style="display: none;" id="error"><span id="msgError">Record Exist</span>
                        <!--                        <div class="w3-large w3-closebtn" onclick="$('#error').addClass('w3-hide')">X</div>-->
                    </div>
                    <div class="alert-success w3-padding w3-margin w3-round" style="display: none;" id="divSuccess"><span id="msgSuccess">Record Exist</span>
                        <!--                        <div class="w3-large w3-closebtn" onclick="$('#error').addClass('w3-hide')">X</div>-->
                    </div>
                    <form class="w3-form" action="javascript:void(0)" id="schedull_form">
                        <select class="w3-select" id="program" name="program" onchange="toggleLevel(this)" required>
                            <option selected="selected" value="">--Select Program--</option>
                            <option value="0">PRE ND</option>
                            <option value="0">CERTIFICATE</option>
                            <option value="1">ND</option>
                            <option value="2">HND</option>
                        </select>
                        <select class="w3-select level" id="level" required>
                            <option selected="selected" value="">--Level--</option>
                        </select>
                        <select class="w3-select" id="semester" onchange="get_allocated_course(), time_table()" required>
                            <option selected="selected" value="select">--Select Semester--</option>
                            <option value="First">First</option>
                            <option value="Second">Second</option>
                            <option value="Third">Third</option>
                            <option value="Fourth">Fourth</option>
                        </select>
                        <hr class="w3-border-green w3-bottombar" />
                        <h3>Schedule Time Table</h3>
                        <select class="w3-select" id="time_courses" onchange="chk_staff_schedul()" required>
                        </select>
                        <select class="w3-select" id="lecturer" required>
                        </select>
                        <select class="w3-select" id="time" required>
                            <option selected="selected" value="">--Select Time--</option>
                            <option value="08:00 - 10:00">08:00 - 10:00</option>
                            <option value="10:00 - 12:00">10:00 - 12:00</option>
                            <option value="12:00 - 02:00">12:00 - 02:00</option>
                            <option value="02:00 - 04:00">02:00 - 04:00</option>
                        </select>
                        <select class="w3-select" id="day" required>
                            <option selected="selected" value="">--Select Day--</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                        </select>
                        <select class="w3-select" id="venue" required>
                            <option selected="selected" value="">--Select Venue--</option>
                            <option value="LAB 1">LAB 1</option>
                            <option value="LAB 2">LAB 2</option>
                            <option value="LAB 3">LAB 3</option>
                            <option value="Theater 1">Theater 1</option>
                        </select>
                        <br /><br />
                        <button type="submit" class="w3-green btn" value="Save" id="save"><i class="fa fa-save"></i>&nbsp;Save</button>
                        <button type="reset" class="btn btn-danger" value="Reset" id="btn_department_cancel"><i class="fa fa-repeat"></i>&nbsp;Cancel</button>
                    </form>
                    </div>
                </div>


                <div class="w3-col w3-margin l8" style="min-height: 65vh; padding: 10px 10px; overflow:scroll;" onclick="$("#delet_model").">
                    <!--                    <a href="processor.php?delete_user" onclick="return confirm('Are you sure to delete this user')">Delete</a>-->
                    <div class="my-card" style="padding: 10px 10px">
                        
                    <div class="w3-row">
                        <div class="w3-col l12">
                            <button class="btn w3-blue w3-right" ng-click="downloadTimeTable()">
                                <i class="fa fa-download"></i>
                            </button>
                        </div>
                    </div>
                    <div class="w3-row">
                        <div class="w3-col l12">
                            <div id="time_table_display">
                                <img src="Image/NoRecordFound.png" style="max-width:66.66666%; min-width:20%;" />
                            </div>
                        </div>
                    </div>
                    </div>

                </div>
            </div>

            <footer class="w3-container w3-bottom alert-success w3-border-green w3-border-top">
                <h5>By ST/CS/HND/20/002</h5>

            </footer>

        </div>

        <div id="delet_schedul_course_model" class="w3-modal w3-hide w3-animate-opacity">
            <div class="w3-modal-content w3-card-14 w3-round w3-col l3" style="left:40%; top:20%;">
                <div class="w3-container">
                    <p class="w3-center"><i class="fa fa-trash-o w3-xxxlarge w3-text-red"></i></p>
                    <p class="w3-center"><h4 class="alert-danger w3-round w3-padding w3-center">Delete<big class="w3-closebtn">!</big></h4></p>

                    <p>
                        <h4 class="w3-center" id="sureDetail"></h4>
                        <input type="text" id="alcid" class=" w3-hide" />
                    </p>
                    <p class="w3-center"><button id="alc_delete" class="w3-btn w3-round">Yes</button>&nbsp;&nbsp;<button id="no" class="w3-btn w3-round" onclick="$('#delet_schedul_course_model').addClass('w3-hide')">No</button>
                </div>
            </div>
        </div>
        <script src="js/jquery.min.js"></script>
        <script src="angularjs/angular.min.js"></script>
        <script src="js/download.js"></script>
        <script src="js/script.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap.js"></script>
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