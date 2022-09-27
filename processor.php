<?php
header("Access-Control-Allow-Origin: *");
include('session.php');
include('classes.php');
require './mpdf/vendor/autoload.php';
$db = new newclass();
$pdf = new \Mpdf\Mpdf(['format' => 'A4']);

die("Ok");

if (isset($_GET['login_authentication'])) {
    $userid = $_POST['userid'];
    $password = $_POST['password'];
    $login = $db->login($userid, $password);
    die("Why");
//    echo json_encode($login);
//    if (!$login['status']) {
//        echo false;
//    } else {
//        session_start();
//        $_SESSION['loger'] = $login['record'];
//        echo true;
//    }
}
if (isset($_GET['get_staff'])) {
    echo $db->get_staffs();
}
if (isset($_GET['save_staff'])) {
    $sID = $_POST['sID1'];
    $surname = $_POST['surname1'];
    $first_name = $_POST['first_name1'];
    $middle_name = $_POST['middle_name1'];
    $department = $_POST['department1'];
    $rank = $_POST['rank1'];
    $gender = $_POST['gender1'];
    if ($db->che_staff($sID) > 0) {
        echo "Error";
    } else {
        $db->add_staff($sID, $surname, $first_name, $middle_name, $department, $rank, $gender);
    }
}
if (isset($_GET['delete_staff'])) {
    $id = $_POST['staffId'];
    $db->delet_staff($id);
    json_encode($id);
}
if (isset($_GET['update_staff'])) {
    $staffID = $_POST['staffID1'];
    $surname = $_POST['surname1'];
    $first_name = $_POST['first_name1'];
    $middle_name = $_POST['middle_name1'];
    $department = $_POST['department1'];
    $rank = $_POST['rank1'];
    $gender = $_POST['gender1'];
    $db->update_staff($staffID, $surname, $first_name, $middle_name, $department, $rank, $gender);
}
if (isset($_GET['get_department'])) {
    echo $db->get_department();
}
if (isset($_GET['add_department'])) {
    $dpt_name = $_POST['department1'];
    $dpt_school = $_POST['school1'];
    if ($db->chk_dpartment($dpt_name) > 0) {
        echo "error";
    } else {
        $db->add_department($dpt_name, $dpt_school);
    }
}
if (isset($_GET['update_department'])) {
    $dptID = $_POST['dptID1'];
    $dpt_name = $_POST['department1'];
    $dpt_school = $_POST['school1'];
    $db->update_department($dpt_name, $dpt_school, $dptID);
}
if (isset($_GET['delete_department'])) {
    $dptID = $_POST['dptID'];
    $db->delet_department($dptID);
}
if (isset($_GET['get_course'])) {
    echo $db->get_courses();
}
if (isset($_GET['delete_course'])) {
    $c_id = $_POST['cId'];
    $db->delet_course($c_id);
}
if (isset($_GET['add_course'])) {
    $cID = $_POST['cID1'];
    $ccode = $_POST['ccode1'];
    $ctitle = $_POST['ctitle1'];
    $cunit = $_POST['cunit1'];
    $level = $_POST['level1'];
    $semester = $_POST['semester1'];
    if ($db->chk_course($ccode) > 0) {
        echo "error";
    } else {
        $db->add_course($ccode, $ctitle, $cunit, $level, $semester);
    }
}
if (isset($_GET['update_course'])) {
    $cID = $_POST['cID1'];
    $ccode = $_POST['ccode1'];
    $ctitle = $_POST['ctitle1'];
    $cunit = $_POST['cunit1'];
    $level = $_POST['level1'];
    $semester = $_POST['semester1'];
    $db->upd_course($cID, $ccode, $ctitle, $cunit, $level, $semester);
}
if (isset($_GET['get_dpt_list'])) {
    $result = $db->get_dpartment_list();
    echo '<option selected="selected" value="">--Select Department--</option>';
    foreach ($result as $rs) {
        echo '<option value="' . $rs['id'] . '">' . $rs['dpt_name'] . '</option>';
    }
}
if (isset($_GET['courses_lists'])) {
    $course_id = $db->courses_list();
    echo '<option selected="selected" value="">--Select Course--</option>';
    foreach ($course_id as $rc) {
        echo '<option value="' . $rc['id'] . '">' . $rc['ccode'] . '</option>';
    }
}
if (isset($_GET['allocated_courses'])) {
    $dpt_id = $_POST['dpt_id'];
    echo $db->get_allocated_course($dpt_id, $academic_session);
}
if (isset($_GET['allocate_course'])) {
    $c_id = $_POST['c_id'];
    $dpt_id = $_POST['dpt_id'];
    $session = $_POST['session'];
    if ($db->chk_allocated_course($c_id, $dpt_id, $session) > 0) {
        echo "error";
    } else {
        $db->allocate_course($c_id, $dpt_id, $session);
    }
}
if (isset($_GET['delete_allocated_course'])) {
    $aID = $_POST['aID'];
    $db->delet_allocated_course($aID);
}
if (isset($_GET['time_table'])) {
    $level_t = $_POST['level'];
    $semester_t = $_POST['semester'];
    echo $db->time_table($level_t, $semester_t, $academic_session, $department_id);
}

if(isset($_GET['downloadTimetable'])){
    
    $level_t = $_POST['level'];
    $semester_t = $_POST['semester'];
    $result = $db->time_table_dowload($level_t, $semester_t, $academic_session, $department_id);
    $style = file_get_contents('./css/style.css');
    $pdf->WriteHTML($style, 1);
    $pdf->SetWatermarkText("THE FEDERAL POLYTECHNIC BALI");
    $pdf->showWatermarkText = TRUE;
    $pdf->AddPage('L');
    $pdf->WriteHTML($result, 2);
    $file = $pdf->Output('Time Table.pdf', 'S');
    echo $file;
    
}
if (isset($_GET['acd_session'])) {
    $c_session = date('Y');
    $n_session = date('Y') + 1;
    echo $c_session . "/" . $n_session;
}
if (isset($_GET['allocated_coursess'])) {
    $lve = $_POST['level'];
    $smt = $_POST['semester'];
    $rec = $db->get_allocated_courses($department_id, $academic_session, $lve, $smt);
    echo '<option selected="selected" value="">--Select Course--</option>';
    foreach ($rec as $r) {
        echo '<option value="' . $r['id'] . '">' . $r['ccode'] . '</option>';
    }
}
if (isset($_GET['allocated_staff'])) {
    $staff = $db->get_allocated_staff($department_id);
    echo '<option selected="selected" value="">--Select Lecturer--</option>';
    foreach ($staff as $n) {
        echo '<option value="' . $n['id'] . '">' . $n['surname'] . " " . $n['first_name'], " " . $n['middle_name'] . '</option>';
    }
}
if (isset($_GET['save_schedull'])) {
    $level_s = $_POST['level'];
    $semester_s = $_POST['semester'];
    $lecturer_id = $_POST['lecturer'];
    $time_courses = $_POST['time_courses'];
    $time = $_POST['time'];
    $day = $_POST['day'];
    $venue = $_POST['venue'];
    if ($db->chk_schedull($department_id, $academic_session, $time, $day, $level_s, $semester_s) > 0) {
        echo json_encode(array('status'=>0, 'message'=>"Sorry Allready Scheduled"));
    } else if ($db->chk_venue($academic_session, $time, $day, $venue) > 0) {
        echo json_encode(array('status'=>0, 'message'=>"Sorry Venue Allready Scheduled For This Time"));
    } else if($db->chk_staff_timetable_allocation($academic_session, $time, $day, $lecturer_id)) {
        echo json_encode(array('status'=>0, 'message'=>"Sorry This Lecturer Allready Scheduled For This Time"));
    } else {
        echo json_encode(array('status'=>1, 'message'=>"Scheduled Successfully!"));
        $db->save_schedull($department_id, $academic_session, $level_s, $semester_s, $lecturer_id, $time_courses, $time, $day, $venue);
    }
}
if (isset($_GET['delete_schedul_course'])) {
    $id = $_POST['record_id'];
    $db->delet_schedul_course($id);
}
if (isset($_GET['registered_staff'])) {
    echo '(' . $db->registered_staff() . ')';
}
if (isset($_GET['department_added'])) {
    echo '(' . $db->department_added() . ')';
}
if (isset($_GET['courses_added'])) {
    echo '(' . $db->courses_added() . ')';
}
if (isset($_GET['chk_staff_schedul'])) {
    $course_id = $_POST['time_courses'];
    $record = $db->chk_staff_schedull_name($course_id);
    foreach ($record as $name) {
        echo $name['staff_id'];
    }
}
?>