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