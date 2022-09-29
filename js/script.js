$(document).ready(function () {
    get_users();
    displatstaff();
    get_department();
    get_courses();
    get_department_list();
    accademic_session();
    session_data();
    get_allocated_staff();
    registered_staff();
    department_added();
    courses_added();
});
const toggleLevel = target => {
    var program = target.value,
    levels = {
        '0' : [
            {'id' : 1, 'title' : "Certificate"}
        ],
        '1' : [
            {'id' : 1, 'title' : "ND I"},
            {'id' : 2, 'title' : "ND II"}
        ],
        '2' : [
            {'id' : 1, 'title' : "HND I"},
            {'id' : 2, 'title' : "HND II"}
        ]
    }[program],
    
    form = document.getElementById('course_form') || document.getElementById('schedull_form'),
    levelSelect = form.querySelector('.level'),
    length = levelSelect.options.length;
    
    for(var i = length - 1; i >= 0; i--) {
        levelSelect.options[i] = null;
    }
    
    var opt = document.createElement("option");
    opt.appendChild(document.createTextNode("--Select Level--"));
    opt.value = "";
    levelSelect.appendChild(opt);
    
    levels.forEach(level => {
        var opt = document.createElement("option");
        opt.appendChild(document.createTextNode(level.title));
        opt.value = level.id; 
        
        levelSelect.appendChild(opt);
    });
};
function registered_staff() {
    $.ajax({
        type: "POST",
        url: "processor.php?registered_staff",
        success: function (result) {
            $('#registered_staff').html(result);

        }
    });
}
function department_added() {
    $.ajax({
        type: "POST",
        url: "processor.php?department_added",
        success: function (result) {
            $('#department_added').html(result);
        }
    });
}
function courses_added() {
    $.ajax({
        type: "POST",
        url: "processor.php?courses_added",
        success: function (result) {
            $('#courses_added').html(result);
        }
    });
}
function displatstaff() {
    $.ajax({
        url: "processor.php?get_staff",
        type: "POST",
        success: function (result) {
            $("#staff_display").html(result);
        }
    });
}


(function ($) {
    $.fn.extend({
        upperFirst: function () {
            $(this).keyup(function (event) {
                var box = event.target;
                var txt = $(this).val();
                var start = box.selectionStart;
                var end = box.selectionEnd;
                $(this).val(txt.toLowerCase().replace(/^(.)/g,
                        function (c) {
                            return c.toUpperCase();
                        }));
                box.setSelectionRange(start, end);
            });
            return this;
        }
    });
}(jQuery));
$(document).ready(function () {
    $('#sID').change(function () {
        var txt = $('#sID').val();
        $('#sID').val(txt.toUpperCase());
    });
    // save staff record 
    $('#form1').on('submit', function (e) {
        e.preventDefault();
        var staffID = $('#staffID').val();
        var sID = $('#sID').val();
        var surname = $('#surname').val();
        var first_name = $('#first_name').val();
        var middle_name = $('#middle_name').val();
        var department = $('#department').val();
        var rank = $('#rank').val();
        var gender = $('#gender').val();
        var dataset = 'staffID1=' + staffID + '&sID1=' + sID + '&surname1=' + surname + '&first_name1=' + first_name + '&middle_name1=' + middle_name + '&department1=' + department + '&rank1=' + rank + '&gender1=' + gender;
        var add = $('#add').val();
        if (add == "Add") {
            $.ajax({
                type: "POST",
                url: "processor.php?save_staff",
                data: dataset,
                success: function (result) {
                    if (result == "Error") {
                        $('#error').removeClass('w3-hide');
                    } else {
                    }
                    displatstaff();
                    $('#form1').load();
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "processor.php?update_staff",
                data: dataset,
                success: function (result) {
                    displatstaff();
                }
            });
        }
    });
    $('#cancel').click(function () {
        $('#add').val('Add');
        $('#cancel').val('Reset');
    });
    $('#yes').click(function () {
        var staffId = $('#staffIDtxt').val();
        $.ajax({
            type: "POST",
            url: "processor.php?delete_staff",
            data: {staffId: staffId},
            success: function (staID) {
                $('#delet_model').addClass('w3-hide');
                displatstaff();
            }
        });
    });
    $('#c_yes').click(function () {
        var cId = $('#cID').val();
        $.ajax({
            type: "POST",
            url: "processor.php?delete_course",
            data: {cId: cId},
            success: function (cs_r) {
                $('#delet_course_model').addClass('w3-hide');
                get_courses();
            }
        });
    });
    $('#dpt_form').on('submit', function () {
        var department = $('#department').val();
        var school = $('#school').val();
        var dptID = $('#dptID').val();
        var dpt_data = 'department1=' + department + '&school1=' + school + '&dptID1=' + dptID;
        var add = $('#btn_deparment').val();
        if (add == "Add") {
            $.ajax({
                type: "POST",
                url: "processor.php?add_department",
                data: dpt_data,
                success: function (dpt_result) {
                    if (dpt_result == "error") {
                        $('#error').removeClass('w3-hide');
                    } else {
                        get_department();
                    }
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "processor.php?update_department",
                data: dpt_data,
                success: function (dpt_upd_result) {
                    get_department();
                }
            });
        }
    });
    $('#user_form').on('submit', function () {
        var department = $('#department').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var user = 'department=' + department + '&username=' + username + '&password=' + password;
        $.ajax({
            type: "POST",
            url: "processor.php?save_user",
            data: user,
            success: function (response) {
                alert(response);
                window.location.reload();
            }
        });
    });
    $('#btn_department_cancel').click(function () {
        $('#btn_deparment').val('Add');
        $('#btn_course').val('Add');
    });
    $('#dpt_yes').click(function () {
        var dptID = $('#dptID').val();
        $.ajax({
            type: "POST",
            url: "processor.php?delete_department",
            data: {dptID: dptID},
            success: function (dptID_result) {
                $('#delet_dpt_model').addClass('w3-hide');
                get_department();
            }
        });
    });
    $('#alc_yes').click(function () {
        var aID = $('#aID').val();
        $.ajax({
            type: "POST",
            url: "processor.php?delete_allocated_course",
            data: {aID: aID},
            success: function (alc_result) {
                $('#delet_allocated_course_model').addClass('w3-hide');
                get_department_allocated_course();
            }
        });
    });
    $('#course_form').on('submit', function () {
        var formData = $(this).serializeArray();
        var saveData = {};
        var cID = null;
        for(var i = 0; i < formData.length; i++) {
            saveData[formData[i].name] = formData[i].value;
        }
        var add = $('#btn_course').val();
        if (add == "Add") {
            $.ajax({
                type: "POST",
                url: "processor.php?add_course",
                data: saveData,
                success: function (course_result) {
                    if (course_result == "error") {
                        $('#error').removeClass('w3-hide');
                    } else {
                        alert("New Course Added Successfull");
                        get_courses();
                    }
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "processor.php?update_course",
                data: saveData,
                success: function (course_upd_result) {
                    get_courses();
                }
            });
        }
    });
    $('#allocate_form').on('submit', function () {
        var aID = $('#aID').val();
        var dpt_id = $('#department').val();
        var c_id = $('#courses').val();
        var session = $('#session').val();
        var allocate = $('#btn_allocate').val();
        if (allocate == "Allocate") {
            $.ajax({
                type: "POST",
                url: "processor.php?allocate_course",
                data: {aID: aID, dpt_id: dpt_id, c_id: c_id, session: session},
                success: function (allocate_result) {
                    if (allocate_result == "error") {
                        $('#error').removeClass('w3-hide');
                    } else {
                        get_department_allocated_course();
                    }
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "processor.php?update_allocated_course",
                data: {aID: aID, dpt_id: dpt_id, c_id: c_id, session: session},
                success: function (allocate_upd_result) {
                    get_allocated_course();
                }
            });
        }
    });
    $('#schedull_form').on('submit', function (e) {
        e.preventDefault();
        var level = $('#level').val();
        var semester = $('#semester').val();
        var lecturer = $('#lecturer').val();
        var time_courses = $('#time_courses').val();
        var time = $('#time').val();
        var day = $('#day').val();
        var venue = $('#venue').val();
        var add = $('#save').val();
        if (add == "Save") {
            $.ajax({
                type: "POST",
                url: "processor.php?save_schedull",
                data: {level: level, semester: semester, lecturer: lecturer, time_courses: time_courses, time: time, day: day, venue: venue},
                success: function (result) {
                    var json = JSON.parse(result);
                    if (parseInt(json.status.toString()) < 1) {
                        $('#msgError').html(json.message);
                        $('#error').fadeIn().delay(10000).fadeOut();
                    } else {
                        $('#msgSuccess').html(json.message);
                        $('#divSuccess').fadeIn().delay(5000).fadeOut("slow");
                        time_table();
                    }
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: "processor.php?update_staff",
                data: dataset,
                success: function (result) {
                    time_table();
                }
            });
        }
    });
    $('#login_form').on('submit', function (e) {
        e.preventDefault();
        var userid = $('#userid').val();
        var password = $('#password').val();
        $.ajax({
            type: "POST",
            url: "processor.php?login_authentication",
            data: {userid: userid, password: password},
            success: function (login_result) {
                if (login_result == "error") {
                    $('#error').removeClass('w3-hide');
                } else {
                    window.location = "index.php";
                }
            }
        });
    });

    $('#alc_delete').click(function () {
        var record_id = $('#alcid').val();
        $.ajax({
            type: "POST",
            url: "processor.php?delete_schedul_course",
            data: {record_id: record_id},
            success: function (result) {
                $('#delet_schedul_course_model').addClass('w3-hide');
                time_table();
            }
        });
    });

    $('#form1 input').upperFirst();
    $('#dpt_form input').upperFirst();
});
function edit_staff(id) {
    var tr = document.getElementById('edit' + id);
    var staffID = tr.getElementsByTagName('td')[0].innerHTML;
    var sID = tr.getElementsByTagName('td')[1].innerHTML;
    var surname = tr.getElementsByTagName('td')[2].innerHTML;
    var first_name = tr.getElementsByTagName('td')[3].innerHTML;
    var middle_name = tr.getElementsByTagName('td')[4].innerHTML;
    var department = tr.getElementsByTagName('td')[8].innerHTML;
    var rank = tr.getElementsByTagName('td')[9].innerHTML;
    var gender = tr.getElementsByTagName('td')[10].innerHTML;
    $('#staffID').val(staffID);
    $('#sID').val(sID);
    $('#surname').val(surname);
    $('#first_name').val(first_name);
    $('#middle_name').val(middle_name);
    $('#department').val(department);
    $('#rank').val(rank);
    $('#gender').val(gender);
    $('#add').val('Update');
    $('#cancel').val('Cancel');
}
function delet_model(id) {
    var tr = document.getElementById('edit' + id);
    var name = tr.getElementsByTagName('td')[6].innerHTML;
    var staffIDtxt = tr.getElementsByTagName('td')[0].innerHTML;
    $('#sureDetail').html(name);
    $('#staffIDtxt').val(staffIDtxt);
    $('#delet_model').removeClass('w3-hide');
}
function get_department() {
    $.ajax({
        url: "processor.php?get_department",
        type: "POST",
        success: function (dpt_result) {
            $("#department_display").html(dpt_result);

        }
    });
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
}

function get_users() {
    $.ajax({
        url: "processor.php?get_users",
        type: "POST",
        success: function (response) {
            $("#userslist").html(response);

        }
    });
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
}

function edit_department(id) {
    var tr = document.getElementById('dpt_edit' + id);
    var dptID = tr.getElementsByTagName('td')[0].innerHTML;
    var dpt_name = tr.getElementsByTagName('td')[2].innerHTML;
    var dpt_school = tr.getElementsByTagName('td')[3].innerHTML;
    $('#dptID').val(dptID);
    $('#department').val(dpt_name);
    $('#school').val(dpt_school);
    $('#btn_deparment').val('Update');
    $('#btn_department_cancel').val('Cancel');
}
function delet_dpt_model(id) {
    var tr = document.getElementById('dpt_edit' + id);
    var name = tr.getElementsByTagName('td')[2].innerHTML;
    var staffIDtxt = tr.getElementsByTagName('td')[0].innerHTML;
    $('#sureDetail').html(name);
    $('#dptID').val(staffIDtxt);
    $('#delet_dpt_model').removeClass('w3-hide');
}
function get_courses() {
    $.ajax({
        url: "processor.php?get_course",
        type: "POST",
        success: function (cs_result) {
            $("#courses_display").html(cs_result);
        }
    });
}
function delet_course_model(id) {
    var tr = document.getElementById('course_edit' + id);
    var course_code = tr.getElementsByTagName('td')[2].innerHTML;
    var staffIDtxt = tr.getElementsByTagName('td')[0].innerHTML;
    $('#sureDetail').html(course_code);
    $('#cID').val(staffIDtxt);
    $('#delet_course_model').removeClass('w3-hide');
}
function edit_course(id) {
    // `department`, `program`, `ccode`, `ctitle`, `cunit`, `level`, `semester`
    var tr = document.getElementById('course_edit' + id);
    var cID = tr.getElementsByTagName('td')[0].innerHTML;
    var program =  tr.getElementsByTagName('td')[3].innerHTML;
    var ccode = tr.getElementsByTagName('td')[4].innerHTML;
    var ctitle = tr.getElementsByTagName('td')[5].innerHTML;
    var cunit = tr.getElementsByTagName('td')[6].innerHTML;
    var level = tr.getElementsByTagName('td')[8].innerHTML;
    var semester = tr.getElementsByTagName('td')[9].innerHTML;
    $('#cID').val(cID);
    $('#program').val(program);
    $('#ccode').val(ccode);
    $('#ctitle').val(ctitle);
    $('#cunit').val(cunit);
    var pElem = document.getElementById('program');
    toggleLevel(pElem);
    $('#level').val(level);
    $('#semester').val(semester);
    $('#btn_course').val('Update');
    $('#btn_department_cancel').val('Cancel');
   
}
function get_department_list() {
    $.ajax({
        type: "POST",
        url: "processor.php?get_dpt_list",
        success: function (dpt_list) {
            $('#department').html(dpt_list);
        }
    });
}
function courses_list() {
    var dpt_id = $('#department').val();
    $.ajax({
        type: "POST",
        url: "processor.php?courses_lists",
        data: {dpt_id: dpt_id},
        success: function (couses) {
            $('#courses').html(couses);
        }
    });
}
function get_department_allocated_course() {
    var dpt_id = $('#department').val();
    $.ajax({
        type: "POST",
        url: "processor.php?allocated_courses",
        data: {dpt_id: dpt_id},
        success: function (allocated_course) {
            $('#allocated_courses_display').html(allocated_course);
        }
    });
}
function delet_alc_model(id) {
    var tr = document.getElementById('alc_edit' + id);
    var name = tr.getElementsByTagName('td')[2].innerHTML;
    var aID = tr.getElementsByTagName('td')[0].innerHTML;
    $('#sureDetail').html(name);
    $('#aID').val(aID);
    $('#delet_allocated_course_model').removeClass('w3-hide');
}
function time_table() {
    var level = $('#level').val();
    var semester = $('#semester').val();
    $.ajax({
        type: "POST",
        url: "processor.php?time_table",
        data: {level: level, semester: semester},
        success: function (time_table_result) {
            $('#time_table_display').html(time_table_result);
        }
    });
}

var app = angular.module('download', []);
app.controller('myCtrl', function ($scope, $http) {
    
    $scope.downloadTimeTable = function () {
        var level = document.getElementById('level').value;
        var semester = document.getElementById('semester').value;
        var fd = new FormData();
        fd.append('level', level);
        fd.append('semester', semester);
        $http({
            method: "POST",
            url: 'processor.php?downloadTimetable',
            headers: {
                'Content-Type': undefined
            },
            responseType: 'blob',
            data: fd
        }).then(function (rs) {
            var blob = rs.data;
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'Time Table.pdf';
            link.click();
        });
    };
});

function accademic_session() {
    $.ajax({
        type: "POST",
        url: "processor.php?acd_session",
        success: function (session_r) {
            $('#session').val(session_r);
        }
    });
}
function session_data() {
    $.ajax({
        type: "POST",
        url: "processor.php?session_datas",
        success: function (session_datas) {
            $('#loger').html(session_datas);
        }
    });
}
function get_allocated_course() {
    var program = $('#program').val();
    var level = $('#level').val();
    var semester = $('#semester').val();
    $.ajax({
        type: "POST",
        url: "processor.php?allocated_coursess",
        data: {department : '', program : program, level: level, semester: semester},
        success: function (result) {
            $('#time_courses').html(result);
        }
    });
}
function get_allocated_staff() {
    $.ajax({
        type: "POST",
        url: "processor.php?allocated_staff",
        success: function (result) {
            $('#lecturer').html(result);
        }
    });
}
function delet_schedul_course_model(id) {
    $('#alcid').val(id);
    $('#delet_schedul_course_model').removeClass('w3-hide');
}
function chk_staff_schedul() {
    var time_courses = $('#time_courses').val();
    $.ajax({
        type: "POST",
        url: "processor.php?chk_staff_schedul",
        data: {time_courses: time_courses},
        success: function (result) {
            $('#lecturer').val(result);

        }
    });
}