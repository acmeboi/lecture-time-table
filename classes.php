<?php

class newclass {

    private $pdo;

    function __construct() {
        return $this->pdo = new PDO('mysql:host=localhost;dbname=tbs_2015', 'root', '');
    }

    function login($userid, $password) {
        $qrt = $this->pdo->prepare("SELECT * FROM users WHERE staffid=:staffid AND password=:password");
        $qrt->bindParam(':staffid', $userid, PDO::PARAM_STR);
        $qrt->bindParam(':password', $password, PDO::PARAM_STR);
        $qrt->execute();
        $result = $qrt->rowCount();
        return $result;
    }

    function get_staffs() {
        $result = '';
        $qrt = $this->pdo->prepare("SELECT s.id, s.staffid, s.surname, s.first_name, s.middle_name, d.dpt_name, s.department, s.rank, s.gender FROM 
		staff s JOIN department d ON s.department=d.id");
        $qrt->execute();
        $num = 0;
        $res = $qrt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <script>
            $(document).ready(function () {
                $('#dataTables-staff').DataTable({
                    responsive: true
                });
            });
        </script>
        <?php

        echo
        $result .='<div class="dataTable_wrapper">';
        $result .='<h3>Staff List</h3>';
        $result .='<table class="w3-table w3-border" border="1" id="dataTables-staff">';
        $result .='<thead class="w3-green">';
        $result .='<th class="w3-hide"></th>';
        $result .='<th class="w3-hide"></th>';
        $result .='<th class="w3-hide"></th>';
        $result .='<th class="w3-hide"></th>';
        $result .='<th class="w3-hide"></th>';
        $result .='<th>S/N</th>';
        $result .='<th>Name</th>';
        $result .='<th>Department</th>';
        $result .='<th class="w3-hide"></th>';
        $result .='<th>Rank</th>';
        $result .='<th>Gender</th>';
        $result .='<th>Option</th>';
        $result .='</thead>';
        $result .='<tbody>';
        foreach ($res as $rec) {
            (int) $num += 1;
            $result .='<tr id="edit' . $rec['id'] . '">';
            $result .='<td class="w3-hide" >' . $rec['id'] . '</td>';
            $result .='<td class="w3-hide">' . $rec['staffid'] . '</td>';
            $result .='<td class="w3-hide">' . $rec['surname'] . '</td>';
            $result .='<td class="w3-hide">' . $rec['first_name'] . '</td>';
            $result .='<td class="w3-hide">' . $rec['middle_name'] . '</td>';
            $result .='<td><b>' . $num . '</b></td>';
            $result .='<td>' . $rec['surname'] . " " . $rec['first_name'] . " " . $rec['middle_name'] . '</td>';
            $result .='<td>' . $rec['dpt_name'] . '</td>';
            $result .='<td class="w3-hide">' . $rec['department'] . '</td>';
            $result .='<td>' . $rec['rank'] . '</td>';
            $result .='<td>' . $rec['gender'] . '</td>';
            $result .='<td class="w3-center"><a href="javascript:void(0)" onclick="edit_staff(' . $rec['id'] . ')"><i class="w3-text-green fa fa-edit 
		w3-xlarge"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delet_model(' . $rec['id'] . ')")"><i class="w3-text-red fa fa-trash 
		w3-xlarge"></i></a></td>';
            $result .='</tr>';
        }
        $result .='</tbody>';
        $result .='</table>';
        $result .='</div>';
        return $result;
    }

    function che_staff($sID) {
        $qrt = $this->pdo->prepare("SELECT staffid FROM staff WHERE staffid=:staffid");
        $qrt->bindParam(":staffid", $sID, PDO::PARAM_STR);
        $qrt->execute();
        $result = $qrt->rowCount();
        return $result;
    }

    function add_staff($sID, $surname, $first_name, $middle_name, $department, $rank, $gender) {
        $qrt = $this->pdo->prepare("INSERT INTO staff(staffid,surname,first_name,middle_name,department,rank,gender)
		Values(:staffid,:surname,:first_name,:middle_name,:department,:rank,:gender)");
        $qrt->bindParam(':staffid', $sID, PDO::PARAM_STR);
        $qrt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $qrt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $qrt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
        $qrt->bindParam(':department', $department, PDO::PARAM_STR);
        $qrt->bindParam(':rank', $rank, PDO::PARAM_STR);
        $qrt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $qrt->execute();
        return true;
    }

    function delet_staff($id) {
        $qrt = $this->pdo->prepare("DELETE FROM staff WHERE id=:id");
        $qrt->bindParam(':id', $id, PDO::PARAM_INT);
        $qrt->execute();
        return true;
    }

    function update_staff($staffID, $surname, $first_name, $middle_name, $department, $rank, $gender) {
        $qrt = $this->pdo->prepare("UPDATE staff SET surname=:surname,first_name=:first_name,middle_name=:middle_name,
		department=:department,rank=:rank,gender=:gender WHERE id=:id");
        $qrt->bindParam(':id', $staffID, PDO::PARAM_INT);
        $qrt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $qrt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $qrt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
        $qrt->bindParam(':department', $department, PDO::PARAM_STR);
        $qrt->bindParam(':rank', $rank, PDO::PARAM_STR);
        $qrt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $qrt->execute();
        return true;
    }

    function get_department() {
        $result = '';
        $qrt = $this->pdo->prepare("SELECT * FROM department");
        $qrt->execute();
        $num = 0;
        $res = $qrt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });
        </script>
        <?php

        echo
        $result .='<div class="dataTable_wrapper">';
        $result .='<h3>Department List</h3>';
        $result .='<table class="w3-table w3-border" border="1" id="dataTables-example">';
        $result .='<thead class="w3-green">';
        $result .='<tr>';
        $result .='<th class="w3-hide"></th>';
        $result .='<th>S/N</th>';
        $result .='<th>Name</th>';
        $result .='<th>School</th>';
        $result .='<th>Options</th>';
        $result .='</tr>';
        $result .='</thead>';
        $result .='<tbody>';
        foreach ($res as $rec) {
            (int) $num += 1;
            $result .='<tr id="dpt_edit' . $rec['id'] . '">';
            $result .='<td class="w3-hide">' . $rec['id'] . '</td>';
            $result .='<td><b>' . $num . '</b></td>';
            $result .='<td>' . $rec['dpt_name'] . '</td>';
            $result .='<td>' . $rec['dpt_school'] . '</td>';
            $result .='<td class="w3-center"><a href="javascript:void(0)" onclick="edit_department(' . $rec['id'] . ')"><i class="w3-text-green fa fa-edit w3-xlarge"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="delet_dpt_model(' . $rec['id'] . ')")"><i class="w3-text-red fa fa-trash w3-xlarge"></i></a></td>';
            $result .='</tr>';
        }
        $result .='</tbody>';
        $result .='</table>';
        $result .='</div>';
        return $result;
    }

    function get_courses() {
        $result = '';
        $level = '';
        $qrt = $this->pdo->prepare("SELECT * FROM courses");
        $qrt->execute();
        $num = 0;
        $res = $qrt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <script>
            $(document).ready(function () {
                $('#dataTables-courses').DataTable({
                    responsive: true
                });
            });
        </script>
        <?php

        echo
        $result .='<div class="dataTable_wrapper">';
        $result .='<h3>Course List</h3>';
        $result .='<table class="w3-table w3-border" border="1" id="dataTables-courses">';
        $result .='<thead class="w3-green">';
        $result .='<th class="w3-hide"></th>';
        $result .='<th>S/N</th>';
        $result .='<th>Course Code</th>';
        $result .='<th>Course Title</th>';
        $result .='<th>Course Unit</th>';
        $result .='<th>Level</th>';
        $result .='<th class="w3-hide"></th>';
        $result .='<th>Semester</th>';
        $result .='<th>Option</th>';
        $result .='</thead>';
        $result .='<tbody>';
        foreach ($res as $rec) {
            (int) $num += 1;
            if ($rec['level'] == 1) {
                $level = "ND 1";
            } else {
                $level = "ND 2";
            }
            $result .='<tr id="course_edit' . $rec['id'] . '">';
            $result .='<td class="w3-hide">' . $rec['id'] . '</td>';
            $result .='<td><b>' . $num . '</b></td>';
            $result .='<td>' . $rec['ccode'] . '</td>';
            $result .='<td>' . $rec['ctitle'] . '</td>';
            $result .='<td>' . $rec['cunit'] . '</td>';
            $result .='<td>' . $level . '</td>';
            $result .='<td class="w3-hide">' . $rec['level'] . '</td>';
            $result .='<td>' . $rec['semester'] . '</td>';
            $result .='<td><a href="javascript:void(0)" onclick="edit_course(' . $rec['id'] . ')"><i class="w3-text-green fa fa-edit w3-xlarge"></i></a>
		&nbsp;&nbsp;
		<a href="javascript:void(0)" onclick="delet_course_model(' . $rec['id'] . ')")"><i class="w3-text-red fa fa-trash w3-xlarge"></i></a></td>';
            $result .='</tr>';
        }
        $result .='</tbody>';
        $result .='</table>';
        $result .='</div>';
        return $result;
    }

    function chk_dpartment($dpt_name) {
        $qrt = $this->pdo->prepare("SELECT dpt_name FROM department WHERE dpt_name=:dpt_name");
        $qrt->bindParam(':dpt_name', $dpt_name, PDO::PARAM_STR);
        $qrt->execute();
        $result = $qrt->rowCount();
        return $result;
    }

    function add_department($dpt_name, $dpt_school) {
        $qrt = $this->pdo->prepare("INSERT INTO department(dpt_name,dpt_school) Values(:dpt_name,:dpt_school)");
        $qrt->bindParam(':dpt_name', $dpt_name, PDO::PARAM_STR);
        $qrt->bindParam(':dpt_school', $dpt_school, PDO::PARAM_STR);
        $qrt->execute();
        return true;
    }

    function update_department($dpt_name, $dpt_school, $dptID) {
        $qrt = $this->pdo->prepare("UPDATE department SET dpt_name=:dpt_name,dpt_school=:dpt_school WHERE id=:id");
        $qrt->bindParam(':dpt_name', $dpt_name, PDO::PARAM_STR);
        $qrt->bindParam(':dpt_school', $dpt_school, PDO::PARAM_STR);
        $qrt->bindParam(':id', $dptID, PDO::PARAM_INT);
        $qrt->execute();
        return true;
    }

    function delet_department($id) {
        $qrt = $this->pdo->prepare("DELETE FROM department WHERE id=:id");
        $qrt->bindParam(':id', $id, PDO::PARAM_INT);
        $qrt->execute();
        return true;
    }

    function delet_course($id) {
        $qrt = $this->pdo->prepare("DELETE FROM courses WHERE id=:id");
        $qrt->bindParam(':id', $id, PDO::PARAM_INT);
        $qrt->execute();
        return true;
    }

    function chk_course($ccode) {
        $qrt = $this->pdo->prepare("SELECT ccode FROM courses WHERE ccode=:ccode");
        $qrt->bindParam(':ccode', $ccode, PDO::PARAM_STR);
        $qrt->execute();
        $result = $qrt->rowCount();
        return $result;
    }

    function add_course($ccode, $ctitle, $cunit, $level, $semester) {
        $qrt = $this->pdo->prepare("INSERT INTO courses(ccode,ctitle,cunit,level,semester) Values(:ccode,:ctitle,:cunit,:level,:semester)");
        $qrt->bindParam(':ccode', $ccode, PDO::PARAM_STR);
        $qrt->bindParam(':ctitle', $ctitle, PDO::PARAM_STR);
        $qrt->bindParam(':cunit', $cunit, PDO::PARAM_STR);
        $qrt->bindParam(':level', $level, PDO::PARAM_STR);
        $qrt->bindParam(':semester', $semester, PDO::PARAM_STR);
        $qrt->execute();
        return true;
    }

    function upd_course($cID, $ccode, $ctitle, $cunit, $level, $semester) {
        $qrt = $this->pdo->prepare("UPDATE courses SET ccode=:ccode,ctitle=:ctitle,cunit=:cunit,level=:level,semester=:semester WHERE id=:id");
        $qrt->bindParam(':id', $cID, PDO::PARAM_STR);
        $qrt->bindParam(':ccode', $ccode, PDO::PARAM_STR);
        $qrt->bindParam(':ctitle', $ctitle, PDO::PARAM_STR);
        $qrt->bindParam(':cunit', $cunit, PDO::PARAM_STR);
        $qrt->bindParam(':level', $level, PDO::PARAM_STR);
        $qrt->bindParam(':semester', $semester, PDO::PARAM_STR);
        $qrt->execute();
        return true;
    }

    function get_dpartment_list() {
        $qrt = $this->pdo->prepare("SELECT * FROM department");
        $qrt->execute();
        $result = $qrt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function courses_list() {
        $qrt = $this->pdo->prepare("SELECT * FROM courses");
        $qrt->execute();
        $result = $qrt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function get_allocated_course($dpt_id, $session) {
        $result = '';
        $qrt = $this->pdo->prepare("SELECT cl.id, c.ccode, c.ctitle, c.cunit, cl.academic_session FROM courses c JOIN course_allocation cl ON 
		c.id=cl.c_id WHERE
		cl.dpt_id=:dpt_id AND cl.academic_session=:academic_session");
        $qrt->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $qrt->bindParam(':academic_session', $session, PDO::PARAM_INT);
        $qrt->execute();
        (int) $num = 0;
        $res = $qrt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <script>
            $(document).ready(function () {
                $('#dataTables-allocateddpt').DataTable({
                    responsive: true
                });
            });
        </script>
        <?php

        echo
        $result .='<div class="dataTable_wrapper">';
        $result .='<h3>Allocated List</h3>';
        $result .='<table class="w3-table w3-responsive w3-border" border="1" id="dataTables-allocateddpt">';
        $result .='<thead class="w3-green">';
        $result .='<th class="w3-hide"></th>';
        $result .='<th>S/N</th>';
        $result .='<th>Course Code</th>';
        $result .='<th>Course Title</th>';
        $result .='<th>Course Unit</th>';
        $result .='<th>Session</th>';
        $result .='<th>Option</th>';
        $result .='</thead>';
        $result .='<tbody>';
        foreach ($res as $rec) {
            (int) $num += 1;
            $result .='<tr id="alc_edit' . $rec['id'] . '">';
            $result .='<td class="w3-hide">' . $rec['id'] . '</td>';
            $result .='<td><b>' . $num . '</b></td>';
            $result .='<td>' . $rec['ccode'] . '</td>';
            $result .='<td>' . $rec['ctitle'] . '</td>';
            $result .='<td>' . $rec['cunit'] . '</td>';
            $result .='<td>' . $rec['academic_session'] . '</td>';
            $result .='<td><a href="javascript:void(0)" onclick="delet_alc_model(' . $rec['id'] . ')")"><i class="w3-text-red fa fa-trash w3-xlarge"></i>
		</a></td>';
            $result .='</tr>';
        }
        $result .='</tbody>';
        $result .='</table>';
        $result .='</div>';
        return $result;
    }

    function chk_allocated_course($c_id, $dpt_id, $academic_session) {
        $qrt = $this->pdo->prepare("SELECT * FROM course_allocation WHERE c_id=:c_id AND dpt_id=:dpt_id AND academic_session=:academic_session");
        $qrt->bindParam(':c_id', $c_id, PDO::PARAM_INT);
        $qrt->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $qrt->bindParam(':academic_session', $academic_session, PDO::PARAM_STR);
        $qrt->execute();
        $result = $qrt->rowCount();
        return $result;
    }

    function allocate_course($c_id, $dpt_id, $academic_session) {
        $qrt = $this->pdo->prepare("INSERT INTO course_allocation(c_id,dpt_id,academic_session) Values(:c_id,:dpt_id,:academic_session)");
        $qrt->bindParam(':c_id', $c_id, PDO::PARAM_INT);
        $qrt->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $qrt->bindParam(':academic_session', $academic_session, PDO::PARAM_STR);
        $qrt->execute();
        return true;
    }

    function delet_allocated_course($id) {
        $qrt = $this->pdo->prepare("DELETE FROM course_allocation WHERE id=:id");
        $qrt->bindParam(':id', $id, PDO::PARAM_INT);
        $qrt->execute();
        return true;
    }
    
    function table(){
        $result = '';
        $result .='<table class="w3-table w3-responsive w3-border" border="1" style="font-size:10px;">';
        $result .='<caption><h3>TIME TABLE</h3></caption>';
        $result .='<thead class="w3-green">';
        $result .='<th>Time/Day</th>';
        $result .='<th>08:00<sub>am</sub>&nbsp;-&nbsp;10:00<sub>am</sub></th>';
        $result .='<th>10:00<sub>am</sub>&nbsp;-&nbsp;12:00<sub>pm</sub></th>';
        $result .='<th>12:00<sub>pm</sub>&nbsp;-&nbsp;02:00<sub>pm</sub></th>';
        $result .='<th>02:00<sub>pm</sub>&nbsp;-&nbsp;04:00<sub>pm</sub></th>';
        $result .='</thead>';
        $result .='<tbody>';
        $result .='<td>Monday</b></td>';
        return $result;
    }

    function time_table($level, $semester, $session, $dpt_id) {
        $result = '';
        $num = 0;
        echo
        $result .='<table class="w3-table w3-responsive w3-border" border="1" style="font-size:10px;">';
        $result .='<caption><h3>TIME TABLE</h3></caption>';
        $result .='<thead class="w3-green">';
        $result .='<th>Time Day</th>';
        $result .='<th>08:00<sub>am</sub>&nbsp;-&nbsp;10:00<sub>am</sub></th>';
        $result .='<th>10:00<sub>am</sub>&nbsp;-&nbsp;12:00<sub>pm</sub></th>';
        $result .='<th>12:00<sub>pm</sub>&nbsp;-&nbsp;02:00<sub>pm</sub></th>';
        $result .='<th>02:00<sub>pm</sub>&nbsp;-&nbsp;04:00<sub>pm</sub></th>';
        $result .='</thead>';
        $result .='<tr>';
        $result .='<td>Monday</b></td>';
        $m = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Monday' AND tb.dpt_id=:dpt_id");
        $m->bindParam(':level', $level, PDO::PARAM_INT);
        $m->bindParam(':semester', $semester, PDO::PARAM_INT);
        $m->bindParam(':session', $session, PDO::PARAM_STR);
        $m->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $m->execute();
        $mrow = $m->rowCount();
        $mr = $m->fetchAll(PDO::FETCH_ASSOC);
        if ($mrow > 0) {
            foreach ($mr as $mrr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $mrr['id'] . ')">
					<b>' . $mrr['ccode'] . '</b><br />(' . $mrr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $m2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Monday' AND tb.dpt_id=:dpt_id");
        $m2->bindParam(':level', $level, PDO::PARAM_INT);
        $m2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $m2->bindParam(':session', $session, PDO::PARAM_STR);
        $m2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $m2->execute();
        $mrow2 = $m2->rowCount();
        $mr2 = $m2->fetchAll(PDO::FETCH_ASSOC);
        if ($mrow2 > 0) {
            foreach ($mr2 as $mrr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $mrr2['id'] . ')">
					<b>' . $mrr2['ccode'] . '</b><br />(' . $mrr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $m3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Monday' AND tb.dpt_id=:dpt_id");
        $m3->bindParam(':level', $level, PDO::PARAM_INT);
        $m3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $m3->bindParam(':session', $session, PDO::PARAM_STR);
        $m3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $m3->execute();
        $mrow3 = $m3->rowCount();
        $mr3 = $m3->fetchAll(PDO::FETCH_ASSOC);
        if ($mrow3 > 0) {
            foreach ($mr3 as $mrr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $mrr3['id'] . ')">
					<b>' . $mrr3['ccode'] . '</b><br />(' . $mrr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $m4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Monday' AND tb.dpt_id=:dpt_id");
        $m4->bindParam(':level', $level, PDO::PARAM_INT);
        $m4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $m4->bindParam(':session', $session, PDO::PARAM_STR);
        $m4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $m4->execute();
        $mrow4 = $m4->rowCount();
        $mr4 = $m4->fetchAll(PDO::FETCH_ASSOC);
        if ($mrow4 > 0) {
            foreach ($mr4 as $mrr4) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $mrr4['id'] . ')">
					<b>' . $mrr4['ccode'] . '</b><br />(' . $mrr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='<tr>';
        $result .='<td>Tuesday</b></td>';
        $t = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Tuesday' AND tb.dpt_id=:dpt_id");
        $t->bindParam(':level', $level, PDO::PARAM_INT);
        $t->bindParam(':semester', $semester, PDO::PARAM_INT);
        $t->bindParam(':session', $session, PDO::PARAM_STR);
        $t->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $t->execute();
        $trow = $t->rowCount();
        $tr = $t->fetchAll(PDO::FETCH_ASSOC);
        if ($trow > 0) {
            foreach ($tr as $trr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $trr['id'] . ')">
					<b>' . $trr['ccode'] . '</b><br />(' . $trr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $t2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Tuesday' AND tb.dpt_id=:dpt_id");
        $t2->bindParam(':level', $level, PDO::PARAM_INT);
        $t2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $t2->bindParam(':session', $session, PDO::PARAM_STR);
        $t2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $t2->execute();
        $trow2 = $t2->rowCount();
        $tr2 = $t2->fetchAll(PDO::FETCH_ASSOC);
        if ($trow2 > 0) {
            foreach ($tr2 as $trr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $trr2['id'] . ')">
					<b>' . $trr2['ccode'] . '</b><br />(' . $trr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $t3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Tuesday' AND tb.dpt_id=:dpt_id");
        $t3->bindParam(':level', $level, PDO::PARAM_INT);
        $t3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $t3->bindParam(':session', $session, PDO::PARAM_STR);
        $t3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $t3->execute();
        $trow3 = $t3->rowCount();
        $tr3 = $t3->fetchAll(PDO::FETCH_ASSOC);
        if ($trow3 > 0) {
            foreach ($tr3 as $trr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $trr3['id'] . ')">
					<b>' . $trr3['ccode'] . '</b><br />(' . $trr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $t4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Tuesday' AND tb.dpt_id=:dpt_id");
        $t4->bindParam(':level', $level, PDO::PARAM_INT);
        $t4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $t4->bindParam(':session', $session, PDO::PARAM_STR);
        $t4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $t4->execute();
        $trow4 = $t4->rowCount();
        $tr4 = $t4->fetchAll(PDO::FETCH_ASSOC);
        if ($trow4 > 0) {
            foreach ($tr4 as $trr4) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $trr4['id'] . ')">
					<b>' . $trr4['ccode'] . '</b><br />(' . $trr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='<tr>';
        $result .='<td>Wednesday</b></td>';
        $w = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Wednesday' AND tb.dpt_id=:dpt_id");
        $w->bindParam(':level', $level, PDO::PARAM_INT);
        $w->bindParam(':semester', $semester, PDO::PARAM_INT);
        $w->bindParam(':session', $session, PDO::PARAM_STR);
        $w->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $w->execute();
        $wrow = $w->rowCount();
        $wr = $w->fetchAll(PDO::FETCH_ASSOC);
        if ($wrow > 0) {
            foreach ($wr as $wrr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $wrr['id'] . ')">
					<b>' . $wrr['ccode'] . '</b><br />(' . $wrr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $w2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Wednesday' AND tb.dpt_id=:dpt_id");
        $w2->bindParam(':level', $level, PDO::PARAM_INT);
        $w2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $w2->bindParam(':session', $session, PDO::PARAM_STR);
        $w2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $w2->execute();
        $wrow2 = $w2->rowCount();
        $wr2 = $w2->fetchAll(PDO::FETCH_ASSOC);
        if ($wrow2 > 0) {
            foreach ($wr2 as $wrr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $wrr2['id'] . ')">
					<b>' . $wrr2['ccode'] . '</b><br />(' . $wrr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $w3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Wednesday' AND tb.dpt_id=:dpt_id");
        $w3->bindParam(':level', $level, PDO::PARAM_INT);
        $w3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $w3->bindParam(':session', $session, PDO::PARAM_STR);
        $w3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $w3->execute();
        $wrow3 = $w3->rowCount();
        $wr3 = $w3->fetchAll(PDO::FETCH_ASSOC);
        if ($wrow3 > 0) {
            foreach ($wr3 as $wrr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $wrr3['id'] . ')">
					<b>' . $wrr3['ccode'] . '</b><br />(' . $wrr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $w4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Wednesday' AND tb.dpt_id=:dpt_id");
        $w4->bindParam(':level', $level, PDO::PARAM_INT);
        $w4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $w4->bindParam(':session', $session, PDO::PARAM_STR);
        $w4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $w4->execute();
        $wrow4 = $w4->rowCount();
        $wr4 = $w4->fetchAll(PDO::FETCH_ASSOC);
        if ($wrow4 > 0) {
            foreach ($wr4 as $wrr4) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $wrr4['id'] . ')">
					<b>' . $wrr4['ccode'] . '</b><br />(' . $wrr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='<tr>';
        $result .='<td>Thursday</b></td>';
        $th = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Thursday' AND tb.dpt_id=:dpt_id");
        $th->bindParam(':level', $level, PDO::PARAM_INT);
        $th->bindParam(':semester', $semester, PDO::PARAM_INT);
        $th->bindParam(':session', $session, PDO::PARAM_STR);
        $th->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $th->execute();
        $throw = $th->rowCount();
        $thr = $th->fetchAll(PDO::FETCH_ASSOC);
        if ($throw > 0) {
            foreach ($thr as $thrr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $thrr['id'] . ')">
					<b>' . $thrr['ccode'] . '</b><br />(' . $thrr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $th2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Thursday' AND tb.dpt_id=:dpt_id");
        $th2->bindParam(':level', $level, PDO::PARAM_INT);
        $th2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $th2->bindParam(':session', $session, PDO::PARAM_STR);
        $th2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $th2->execute();
        $throw2 = $th2->rowCount();
        $thr2 = $th2->fetchAll(PDO::FETCH_ASSOC);
        if ($throw2 > 0) {
            foreach ($thr2 as $thrr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $thrr2['id'] . ')">
					<b>' . $thrr2['ccode'] . '</b><br />(' . $thrr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $th3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Thursday' AND tb.dpt_id=:dpt_id");
        $th3->bindParam(':level', $level, PDO::PARAM_INT);
        $th3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $th3->bindParam(':session', $session, PDO::PARAM_STR);
        $th3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $th3->execute();
        $throw3 = $th3->rowCount();
        $thr3 = $th3->fetchAll(PDO::FETCH_ASSOC);
        if ($throw3 > 0) {
            foreach ($thr3 as $thrr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $thrr3['id'] . ')">
					<b>' . $thrr3['ccode'] . '</b><br />(' . $thrr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $th4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Thursday' AND tb.dpt_id=:dpt_id");
        $th4->bindParam(':level', $level, PDO::PARAM_INT);
        $th4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $th4->bindParam(':session', $session, PDO::PARAM_STR);
        $th4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $th4->execute();
        $throw4 = $th4->rowCount();
        $thr4 = $th4->fetchAll(PDO::FETCH_ASSOC);
        if ($throw4 > 0) {
            foreach ($thr4 as $thrr4) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $thrr4['id'] . ')">
					<b>' . $thrr4['ccode'] . '</b><br />(' . $thrr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='<tr>';
        $result .='<td>Friday</b></td>';
        $f = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.course_id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Friday' AND tb.dpt_id=:dpt_id");
        $f->bindParam(':level', $level, PDO::PARAM_INT);
        $f->bindParam(':semester', $semester, PDO::PARAM_INT);
        $f->bindParam(':session', $session, PDO::PARAM_STR);
        $f->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $f->execute();
        $frow = $f->rowCount();
        $fr = $f->fetchAll(PDO::FETCH_ASSOC);
        if ($frow > 0) {
            foreach ($fr as $frr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $frr['id'] . ')">
					<b>' . $frr['ccode'] . '</b><br />(' . $frr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $f2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Friday' AND tb.dpt_id=:dpt_id");
        $f2->bindParam(':level', $level, PDO::PARAM_INT);
        $f2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $f2->bindParam(':session', $session, PDO::PARAM_STR);
        $f2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $f2->execute();
        $frow2 = $f2->rowCount();
        $fr2 = $f2->fetchAll(PDO::FETCH_ASSOC);
        if ($frow2 > 0) {
            foreach ($fr2 as $frr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $frr2['id'] . ')">
					<b>' . $frr2['ccode'] . '</b><br />(' . $frr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $f3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Friday' AND tb.dpt_id=:dpt_id");
        $f3->bindParam(':level', $level, PDO::PARAM_INT);
        $f3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $f3->bindParam(':session', $session, PDO::PARAM_STR);
        $f3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $f3->execute();
        $frow3 = $f3->rowCount();
        $fr3 = $f3->fetchAll(PDO::FETCH_ASSOC);
        if ($frow3 > 0) {
            foreach ($fr3 as $frr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $frr3['id'] . ')">
					<b>' . $frr3['ccode'] . '</b><br />(' . $frr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $f4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Friday' AND tb.dpt_id=:dpt_id");
        $f4->bindParam(':level', $level, PDO::PARAM_INT);
        $f4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $f4->bindParam(':session', $session, PDO::PARAM_STR);
        $f4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $f4->execute();
        $frow4 = $f4->rowCount();
        $fr4 = $f4->fetchAll(PDO::FETCH_ASSOC);
        if ($frow4 > 0) {
            foreach ($fr4 as $frr4) {
                $result .='<td class="w3-center w3-hover-green" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $frr4['id'] . ')">
					<b>' . $frr4['ccode'] . '</b><br />(' . $frr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='</table>';

        $result .='<table class="w3-table w3-margin-0 w3-responsive w3-border-0" style="font-size:10px;">';
        $result .='<thead style="style="font-size:10px;">';
        $result .='<th class="w3-border-bottom w3-border-left">S/N</th>';
        $result .='<th class="w3-border-bottom">Lecturer</th>';
        $result .='<th class="w3-border-bottom">Courses Code</th>';
        $result .='<th class="w3-border-bottom">Course Title</th>';
        $result .='<th class="w3-border-bottom">Classes</th>';
        $result .='<th class="w3-border-bottom">Unit</th>';
        $result .='</thead>';
        $st = $this->pdo->prepare("SELECT COUNT(tt.course_id) tunit, s.surname, s.first_name, s.middle_name, c.ccode, c.ctitle, c.cunit FROM 
		staff s JOIN time_table_schedule tt ON s.id=tt.staff_id JOIN courses c ON c.id=tt.course_id 
		WHERE tt.dpt_id=:dpt_id AND tt.session=:session AND tt.level=:level AND tt.semester=:semester GROUP BY tt.course_id");
        $st->bindParam(':session', $session, PDO::PARAM_STR);
        $st->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $st->bindParam(':level', $level, PDO::PARAM_INT);
        $st->bindParam(':semester', $semester, PDO::PARAM_INT);
        $st->execute();
        $str = $st->fetchAll(PDO::FETCH_ASSOC);
        foreach ($str as $strr) {
            (int) $num += 1;
            $result .='<tr class="w3-margin-0">';
            $result .='<td class="w3-border-right w3-border-left w3-border-bottom">' . $num . '</td>';
            $result .='<td class="w3-border-right w3-border-bottom">' . $strr['surname'] . " " . $strr['first_name'] . " " . $strr['middle_name'] . '</b></td>';
            $result .='<td class="w3-border-right w3-border-bottom">' . $strr['ccode'] . '</td>';
            $result .='<td class="w3-border-right w3-border-bottom">' . $strr['ctitle'] . '</td>';
            $result .='<td class="w3-border-right w3-border-bottom">(' . $strr['tunit'] . ')&nbsp;Per Week</td>';
            $result .='<td class="w3-border-right w3-border-bottom">' . $strr['cunit'] . '</b></td>';
            $result .='</tr>';
        }
        $result .='<tr>';
        $result .='<td class="w3-border-top"></b></td>';
        $result .='<td class="w3-border-top"></b></td>';
        $result .='<td class="w3-border-top"></td>';
        $result .='<td class="w3-border-top"></td>';
        $result .='<td class="w3-border-top w3-right-align" style="font-size:14px;"><b>Total Unit</b></b></td>';
        $tunit = $this->pdo->prepare("SELECT SUM(c.cunit) total FROM courses c JOIN course_allocation ca ON c.id=ca.c_id WHERE 
		ca.dpt_id=:dpt_id AND ca.academic_session=:academic_session AND c.level=:level AND c.semester=:semester");
        $tunit->bindParam(':academic_session', $session, PDO::PARAM_STR);
        $tunit->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $tunit->bindParam(':level', $level, PDO::PARAM_INT);
        $tunit->bindParam(':semester', $semester, PDO::PARAM_INT);
        $tunit->execute();
        $tresult = $tunit->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tresult as $tur) {
            $result .='<td class="w3-border" style="font-size:14px;"><b>' . $tur['total'] . '</b></b></td>';
        }
        $result .='</tr>';
        $result .='</table>';
        return $result;
    }
    
    function time_table_dowload($level, $semester, $session, $dpt_id) {
        $result = '';
        $num = 0;
        
        $result .='<div>';
        $result .='<table class="w3-table w3-border" border="1">';
        $result .='<caption><h3>TIME TABLE</h3></caption>';
        $result .='<tr class="w3-green" >';
        $result .='<th style="color: #FFFFFF;">Time/Day</th>';
        $result .='<th style="color: #FFFFFF; text-align: center;">08:00<sub>am</sub>&nbsp;-&nbsp;10:00<sub>am</sub></th>';
        $result .='<th style="color: #FFFFFF; text-align: center;">10:00<sub>am</sub>&nbsp;-&nbsp;12:00<sub>pm</sub></th>';
        $result .='<th style="color: #FFFFFF; text-align: center;">12:00<sub>pm</sub>&nbsp;-&nbsp;02:00<sub>pm</sub></th>';
        $result .='<th style="color: #FFFFFF; text-align: center;">02:00<sub>pm</sub>&nbsp;-&nbsp;04:00<sub>pm</sub></th>';
        $result .='</tr>';
        $result .='<tr>';
        $result .='<td>Monday</b></td>';
        $m = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Monday' AND tb.dpt_id=:dpt_id");
        $m->bindParam(':level', $level, PDO::PARAM_INT);
        $m->bindParam(':semester', $semester, PDO::PARAM_INT);
        $m->bindParam(':session', $session, PDO::PARAM_STR);
        $m->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $m->execute();
        $mrow = $m->rowCount();
        $mr = $m->fetchAll(PDO::FETCH_ASSOC);
        if ($mrow > 0) {
            foreach ($mr as $mrr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $mrr['id'] . ')">
					<b>' . $mrr['ccode'] . '</b><br />(' . $mrr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $m2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Monday' AND tb.dpt_id=:dpt_id");
        $m2->bindParam(':level', $level, PDO::PARAM_INT);
        $m2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $m2->bindParam(':session', $session, PDO::PARAM_STR);
        $m2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $m2->execute();
        $mrow2 = $m2->rowCount();
        $mr2 = $m2->fetchAll(PDO::FETCH_ASSOC);
        if ($mrow2 > 0) {
            foreach ($mr2 as $mrr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $mrr2['id'] . ')">
					<b>' . $mrr2['ccode'] . '</b><br />(' . $mrr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $m3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Monday' AND tb.dpt_id=:dpt_id");
        $m3->bindParam(':level', $level, PDO::PARAM_INT);
        $m3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $m3->bindParam(':session', $session, PDO::PARAM_STR);
        $m3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $m3->execute();
        $mrow3 = $m3->rowCount();
        $mr3 = $m3->fetchAll(PDO::FETCH_ASSOC);
        if ($mrow3 > 0) {
            foreach ($mr3 as $mrr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $mrr3['id'] . ')">
					<b>' . $mrr3['ccode'] . '</b><br />(' . $mrr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $m4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Monday' AND tb.dpt_id=:dpt_id");
        $m4->bindParam(':level', $level, PDO::PARAM_INT);
        $m4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $m4->bindParam(':session', $session, PDO::PARAM_STR);
        $m4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $m4->execute();
        $mrow4 = $m4->rowCount();
        $mr4 = $m4->fetchAll(PDO::FETCH_ASSOC);
        if ($mrow4 > 0) {
            foreach ($mr4 as $mrr4) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $mrr4['id'] . ')">
					<b>' . $mrr4['ccode'] . '</b><br />(' . $mrr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='<tr>';
        $result .='<td>Tuesday</b></td>';
        $t = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Tuesday' AND tb.dpt_id=:dpt_id");
        $t->bindParam(':level', $level, PDO::PARAM_INT);
        $t->bindParam(':semester', $semester, PDO::PARAM_INT);
        $t->bindParam(':session', $session, PDO::PARAM_STR);
        $t->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $t->execute();
        $trow = $t->rowCount();
        $tr = $t->fetchAll(PDO::FETCH_ASSOC);
        if ($trow > 0) {
            foreach ($tr as $trr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $trr['id'] . ')">
					<b>' . $trr['ccode'] . '</b><br />(' . $trr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $t2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Tuesday' AND tb.dpt_id=:dpt_id");
        $t2->bindParam(':level', $level, PDO::PARAM_INT);
        $t2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $t2->bindParam(':session', $session, PDO::PARAM_STR);
        $t2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $t2->execute();
        $trow2 = $t2->rowCount();
        $tr2 = $t2->fetchAll(PDO::FETCH_ASSOC);
        if ($trow2 > 0) {
            foreach ($tr2 as $trr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $trr2['id'] . ')">
					<b>' . $trr2['ccode'] . '</b><br />(' . $trr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $t3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Tuesday' AND tb.dpt_id=:dpt_id");
        $t3->bindParam(':level', $level, PDO::PARAM_INT);
        $t3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $t3->bindParam(':session', $session, PDO::PARAM_STR);
        $t3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $t3->execute();
        $trow3 = $t3->rowCount();
        $tr3 = $t3->fetchAll(PDO::FETCH_ASSOC);
        if ($trow3 > 0) {
            foreach ($tr3 as $trr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $trr3['id'] . ')">
					<b>' . $trr3['ccode'] . '</b><br />(' . $trr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $t4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Tuesday' AND tb.dpt_id=:dpt_id");
        $t4->bindParam(':level', $level, PDO::PARAM_INT);
        $t4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $t4->bindParam(':session', $session, PDO::PARAM_STR);
        $t4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $t4->execute();
        $trow4 = $t4->rowCount();
        $tr4 = $t4->fetchAll(PDO::FETCH_ASSOC);
        if ($trow4 > 0) {
            foreach ($tr4 as $trr4) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $trr4['id'] . ')">
					<b>' . $trr4['ccode'] . '</b><br />(' . $trr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='<tr>';
        $result .='<td>Wednesday</b></td>';
        $w = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Wednesday' AND tb.dpt_id=:dpt_id");
        $w->bindParam(':level', $level, PDO::PARAM_INT);
        $w->bindParam(':semester', $semester, PDO::PARAM_INT);
        $w->bindParam(':session', $session, PDO::PARAM_STR);
        $w->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $w->execute();
        $wrow = $w->rowCount();
        $wr = $w->fetchAll(PDO::FETCH_ASSOC);
        if ($wrow > 0) {
            foreach ($wr as $wrr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $wrr['id'] . ')">
					<b>' . $wrr['ccode'] . '</b><br />(' . $wrr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $w2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Wednesday' AND tb.dpt_id=:dpt_id");
        $w2->bindParam(':level', $level, PDO::PARAM_INT);
        $w2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $w2->bindParam(':session', $session, PDO::PARAM_STR);
        $w2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $w2->execute();
        $wrow2 = $w2->rowCount();
        $wr2 = $w2->fetchAll(PDO::FETCH_ASSOC);
        if ($wrow2 > 0) {
            foreach ($wr2 as $wrr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $wrr2['id'] . ')">
					<b>' . $wrr2['ccode'] . '</b><br />(' . $wrr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $w3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Wednesday' AND tb.dpt_id=:dpt_id");
        $w3->bindParam(':level', $level, PDO::PARAM_INT);
        $w3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $w3->bindParam(':session', $session, PDO::PARAM_STR);
        $w3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $w3->execute();
        $wrow3 = $w3->rowCount();
        $wr3 = $w3->fetchAll(PDO::FETCH_ASSOC);
        if ($wrow3 > 0) {
            foreach ($wr3 as $wrr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $wrr3['id'] . ')">
					<b>' . $wrr3['ccode'] . '</b><br />(' . $wrr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $w4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Wednesday' AND tb.dpt_id=:dpt_id");
        $w4->bindParam(':level', $level, PDO::PARAM_INT);
        $w4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $w4->bindParam(':session', $session, PDO::PARAM_STR);
        $w4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $w4->execute();
        $wrow4 = $w4->rowCount();
        $wr4 = $w4->fetchAll(PDO::FETCH_ASSOC);
        if ($wrow4 > 0) {
            foreach ($wr4 as $wrr4) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $wrr4['id'] . ')">
					<b>' . $wrr4['ccode'] . '</b><br />(' . $wrr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='<tr>';
        $result .='<td>Thursday</b></td>';
        $th = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Thursday' AND tb.dpt_id=:dpt_id");
        $th->bindParam(':level', $level, PDO::PARAM_INT);
        $th->bindParam(':semester', $semester, PDO::PARAM_INT);
        $th->bindParam(':session', $session, PDO::PARAM_STR);
        $th->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $th->execute();
        $throw = $th->rowCount();
        $thr = $th->fetchAll(PDO::FETCH_ASSOC);
        if ($throw > 0) {
            foreach ($thr as $thrr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $thrr['id'] . ')">
					<b>' . $thrr['ccode'] . '</b><br />(' . $thrr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $th2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Thursday' AND tb.dpt_id=:dpt_id");
        $th2->bindParam(':level', $level, PDO::PARAM_INT);
        $th2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $th2->bindParam(':session', $session, PDO::PARAM_STR);
        $th2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $th2->execute();
        $throw2 = $th2->rowCount();
        $thr2 = $th2->fetchAll(PDO::FETCH_ASSOC);
        if ($throw2 > 0) {
            foreach ($thr2 as $thrr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $thrr2['id'] . ')">
					<b>' . $thrr2['ccode'] . '</b><br />(' . $thrr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $th3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Thursday' AND tb.dpt_id=:dpt_id");
        $th3->bindParam(':level', $level, PDO::PARAM_INT);
        $th3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $th3->bindParam(':session', $session, PDO::PARAM_STR);
        $th3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $th3->execute();
        $throw3 = $th3->rowCount();
        $thr3 = $th3->fetchAll(PDO::FETCH_ASSOC);
        if ($throw3 > 0) {
            foreach ($thr3 as $thrr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $thrr3['id'] . ')">
					<b>' . $thrr3['ccode'] . '</b><br />(' . $thrr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $th4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Thursday' AND tb.dpt_id=:dpt_id");
        $th4->bindParam(':level', $level, PDO::PARAM_INT);
        $th4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $th4->bindParam(':session', $session, PDO::PARAM_STR);
        $th4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $th4->execute();
        $throw4 = $th4->rowCount();
        $thr4 = $th4->fetchAll(PDO::FETCH_ASSOC);
        if ($throw4 > 0) {
            foreach ($thr4 as $thrr4) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $thrr4['id'] . ')">
					<b>' . $thrr4['ccode'] . '</b><br />(' . $thrr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='<tr>';
        $result .='<td>Friday</b></td>';
        $f = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.course_id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='08:00 - 10:00' AND tb.day='Friday' AND tb.dpt_id=:dpt_id");
        $f->bindParam(':level', $level, PDO::PARAM_INT);
        $f->bindParam(':semester', $semester, PDO::PARAM_INT);
        $f->bindParam(':session', $session, PDO::PARAM_STR);
        $f->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $f->execute();
        $frow = $f->rowCount();
        $fr = $f->fetchAll(PDO::FETCH_ASSOC);
        if ($frow > 0) {
            foreach ($fr as $frr) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $frr['id'] . ')">
					<b>' . $frr['ccode'] . '</b><br />(' . $frr['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $f2 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='10:00 - 12:00' AND tb.day='Friday' AND tb.dpt_id=:dpt_id");
        $f2->bindParam(':level', $level, PDO::PARAM_INT);
        $f2->bindParam(':semester', $semester, PDO::PARAM_INT);
        $f2->bindParam(':session', $session, PDO::PARAM_STR);
        $f2->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $f2->execute();
        $frow2 = $f2->rowCount();
        $fr2 = $f2->fetchAll(PDO::FETCH_ASSOC);
        if ($frow2 > 0) {
            foreach ($fr2 as $frr2) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $frr2['id'] . ')">
					<b>' . $frr2['ccode'] . '</b><br />(' . $frr2['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $f3 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='12:00 - 02:00' AND tb.day='Friday' AND tb.dpt_id=:dpt_id");
        $f3->bindParam(':level', $level, PDO::PARAM_INT);
        $f3->bindParam(':semester', $semester, PDO::PARAM_INT);
        $f3->bindParam(':session', $session, PDO::PARAM_STR);
        $f3->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $f3->execute();
        $frow3 = $f3->rowCount();
        $fr3 = $f3->fetchAll(PDO::FETCH_ASSOC);
        if ($frow3 > 0) {
            foreach ($fr3 as $frr3) {
                $result .='<td class="w3-center" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $frr3['id'] . ')">
					<b>' . $frr3['ccode'] . '</b><br />(' . $frr3['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $f4 = $this->pdo->prepare("SELECT c.ccode, tb.id, tb.venue FROM courses c JOIN time_table_schedule tb ON c.id=tb.course_id
		WHERE tb.level=:level AND tb.semester=:semester AND tb.session=:session 
		AND tb.time='02:00 - 04:00' AND tb.day='Friday' AND tb.dpt_id=:dpt_id");
        $f4->bindParam(':level', $level, PDO::PARAM_INT);
        $f4->bindParam(':semester', $semester, PDO::PARAM_INT);
        $f4->bindParam(':session', $session, PDO::PARAM_STR);
        $f4->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $f4->execute();
        $frow4 = $f4->rowCount();
        $fr4 = $f4->fetchAll(PDO::FETCH_ASSOC);
        if ($frow4 > 0) {
            foreach ($fr4 as $frr4) {
                $result .='<td class="w3-center w3-hover-green" title="Click To Perform an action" onclick="delet_schedul_course_model(' . $frr4['id'] . ')">
					<b>' . $frr4['ccode'] . '</b><br />(' . $frr4['venue'] . ')</td>';
            }
        } else {
            $result .='<td class="w3-center">----</td>';
        }
        $result .='</tr>';
        $result .='</table>';
        
        $result .='<table class="w3-table">';
        $result .='<tr style="font-size:10px;">';
        $result .='<th class="w3-border-bottom w3-border-left">S/N</th>';
        $result .='<th class="w3-border-bottom">Lecturer</th>';
        $result .='<th class="w3-border-bottom">Courses Code</th>';
        $result .='<th class="w3-border-bottom">Course Title</th>';
        $result .='<th class="w3-border-bottom">Classes</th>';
        $result .='<th class="w3-border-bottom">Unit</th>';
        $result .='</tr>';
        $st = $this->pdo->prepare("SELECT COUNT(tt.course_id) tunit, s.surname, s.first_name, s.middle_name, c.ccode, c.ctitle, c.cunit FROM 
		staff s JOIN time_table_schedule tt ON s.id=tt.staff_id JOIN courses c ON c.id=tt.course_id 
		WHERE tt.dpt_id=:dpt_id AND tt.session=:session AND tt.level=:level AND tt.semester=:semester GROUP BY tt.course_id");
        $st->bindParam(':session', $session, PDO::PARAM_STR);
        $st->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $st->bindParam(':level', $level, PDO::PARAM_INT);
        $st->bindParam(':semester', $semester, PDO::PARAM_INT);
        $st->execute();
        $str = $st->fetchAll(PDO::FETCH_ASSOC);
        foreach ($str as $strr) {
            (int) $num += 1;
            $result .='<tr class="w3-margin-0">';
            $result .='<td class="w3-border-right w3-border-left w3-border-bottom">' . $num . '</td>';
            $result .='<td class="w3-border-right w3-border-bottom">' . $strr['surname'] . " " . $strr['first_name'] . " " . $strr['middle_name'] . '</b></td>';
            $result .='<td class="w3-border-right w3-border-bottom">' . $strr['ccode'] . '</td>';
            $result .='<td class="w3-border-right w3-border-bottom">' . $strr['ctitle'] . '</td>';
            $result .='<td class="w3-border-right w3-border-bottom">(' . $strr['tunit'] . ')&nbsp;Per Week</td>';
            $result .='<td class="w3-border-right w3-border-bottom">' . $strr['cunit'] . '</b></td>';
            $result .='</tr>';
        }
        $result .='<tr>';
        $result .='<td class="w3-border-top"></b></td>';
        $result .='<td class="w3-border-top"></b></td>';
        $result .='<td class="w3-border-top"></td>';
        $result .='<td class="w3-border-top"></td>';
        $result .='<td class="w3-border-top w3-right-align" style="font-size:14px;"><b>Total Unit</b></b></td>';
        $tunit = $this->pdo->prepare("SELECT SUM(c.cunit) total FROM courses c JOIN course_allocation ca ON c.id=ca.c_id WHERE 
		ca.dpt_id=:dpt_id AND ca.academic_session=:academic_session AND c.level=:level AND c.semester=:semester");
        $tunit->bindParam(':academic_session', $session, PDO::PARAM_STR);
        $tunit->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $tunit->bindParam(':level', $level, PDO::PARAM_INT);
        $tunit->bindParam(':semester', $semester, PDO::PARAM_INT);
        $tunit->execute();
        $tresult = $tunit->fetchAll(PDO::FETCH_ASSOC);
        foreach ($tresult as $tur) {
            $result .='<td class="w3-border" style="font-size:14px;"><b>' . $tur['total'] . '</b></b></td>';
        }
        $result .='</tr>';
        $result .='</table>';
        $result .='</div>';
        return $result;
    }

    function get_allocated_courses($dpt_id, $session, $lve, $sme) {
        $qrt = $this->pdo->prepare("SELECT c.id, c.ccode FROM courses c JOIN course_allocation ca ON c.id=ca.c_id WHERE 
		ca.dpt_id=:dpt_id AND ca.academic_session=:academic_session AND c.level=:level AND c.semester=:semester");
        $qrt->bindParam(':dpt_id', $dpt_id, PDO::PARAM_INT);
        $qrt->bindParam(':academic_session', $session, PDO::PARAM_STR);
        $qrt->bindParam(':level', $lve, PDO::PARAM_INT);
        $qrt->bindParam(':semester', $sme, PDO::PARAM_STR);
        $qrt->execute();
        $result = $qrt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function get_allocated_staff($dpt_id) {
        $qrt = $this->pdo->prepare("SELECT * FROM staff WHERE department=:department");
        $qrt->bindParam(':department', $dpt_id, PDO::PARAM_INT);
        $qrt->execute();
        $result = $qrt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function chk_schedull($department_id, $academic_session, $time, $day, $level_s, $semester_s) {
        $qrt = $this->pdo->prepare("SELECT * FROM time_table_schedule WHERE 
		dpt_id=:dpt_id AND level=:level AND semester=:semester AND session=:session AND time=:time AND day=:day");
        $qrt->bindParam(':dpt_id', $department_id, PDO::PARAM_INT);
        $qrt->bindParam(':session', $academic_session, PDO::PARAM_STR);
        $qrt->bindParam(':time', $time, PDO::PARAM_STR);
        $qrt->bindParam(':day', $day, PDO::PARAM_STR);
        $qrt->bindParam(':level', $level_s, PDO::PARAM_INT);
        $qrt->bindParam(':semester', $semester_s, PDO::PARAM_STR);
        $qrt->execute();
        $nrows = $qrt->rowCount();
        return $nrows;
    }

    function chk_venue($academic_session, $time, $day, $venu) {
        $qrt = $this->pdo->prepare("SELECT * FROM time_table_schedule WHERE "
                . "session=:session AND time=:time AND day=:day AND venue=:venue");
        $qrt->bindParam(':session', $academic_session, PDO::PARAM_STR);
        $qrt->bindParam(':time', $time, PDO::PARAM_STR);
        $qrt->bindParam(':day', $day, PDO::PARAM_STR);
        $qrt->bindParam(':venue', $venu, PDO::PARAM_STR);
        $qrt->execute();
        $nrows = $qrt->rowCount();
        return $nrows;
    }
    
    function chk_staff_timetable_allocation($academic_session, $time, $day, $staffId) {
        $qrt = $this->pdo->prepare("SELECT * FROM time_table_schedule WHERE "
                . "session=:session AND time=:time AND day=:day AND staff_id=:staff_id");
        $qrt->bindParam(':session', $academic_session, PDO::PARAM_STR);
        $qrt->bindParam(':time', $time, PDO::PARAM_STR);
        $qrt->bindParam(':day', $day, PDO::PARAM_STR);
        $qrt->bindParam(':staff_id', $staffId, PDO::PARAM_INT);
        $qrt->execute();
        $nrows = $qrt->rowCount();
        return $nrows;
    }

    function save_schedull($department_id, $academic_session, $level_s, $semester_s, $lecturer_id, $time_courses, $time, $day, $venue) {
        $qrt = $this->pdo->prepare("INSERT INTO time_table_schedule(dpt_id,staff_id,course_id,level,semester,session,time,day,venue) 
		Values(:dpt_id,:staff_id,:course_id,:level,:semester,:session,:time,:day,:venue)");
        $qrt->bindParam(':dpt_id', $department_id, PDO::PARAM_INT);
        $qrt->bindParam(':staff_id', $lecturer_id, PDO::PARAM_INT);
        $qrt->bindParam(':course_id', $time_courses, PDO::PARAM_INT);
        $qrt->bindParam(':level', $level_s, PDO::PARAM_INT);
        $qrt->bindParam(':semester', $semester_s, PDO::PARAM_STR);
        $qrt->bindParam(':session', $academic_session, PDO::PARAM_STR);
        $qrt->bindParam(':time', $time, PDO::PARAM_STR);
        $qrt->bindParam(':day', $day, PDO::PARAM_STR);
        $qrt->bindParam(':venue', $venue, PDO::PARAM_STR);
        $qrt->execute();
        return true;
    }

    function delet_schedul_course($id) {
        $qrt = $this->pdo->prepare("DELETE FROM time_table_schedule WHERE id=:id");
        $qrt->bindParam(':id', $id, PDO::PARAM_INT);
        $qrt->execute();
        return true;
    }

    function registered_staff() {
        $qrt = $this->pdo->prepare("SELECT * FROM staff");
        $qrt->execute();
        $result = $qrt->rowCount();
        return $result;
    }

    function department_added() {
        $qrt = $this->pdo->prepare("SELECT * FROM department");
        $qrt->execute();
        $result = $qrt->rowCount();
        return $result;
    }

    function courses_added() {
        $qrt = $this->pdo->prepare("SELECT * FROM courses");
        $qrt->execute();
        $result = $qrt->rowCount();
        return $result;
    }

    function chk_staff_schedull_name($course_id) {
        $qrt = $this->pdo->prepare("SELECT * FROM time_table_schedule WHERE course_id=:course_id GROUP BY course_id");
        $qrt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $qrt->execute();
        $result = $qrt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}
?>
