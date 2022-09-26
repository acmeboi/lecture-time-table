var app = angular.module('rms', ['datatables','ui.router','ui.bootstrap','checklist-model']);
//============================================================================//
//                        FILE DIRECTORY                                      //
//============================================================================//

app.directive('fileModel', ['$parse', function ($parse){
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };    
}]);

var url = $(location).attr('pathname');
var len = url.length;
var maint = url.substr(5, len - 5);
var urlPath = {
    curentUrl : maint
};

app.controller('myCtrl', function ($scope, $filter, $http) {
    $scope.urlopt = urlPath;
    
    $scope.autocopilete = function (info) {
        var min_length = 1;
        if (info.regNo.length > min_length) {
            $('#tblAuto').show();
            $http.post('./plugins/appSvr/api.php?autocopilete', info).then(function (rs) {
                $scope.stdRegNo = rs.data;
            });
        } else {
            $('#tblAuto').hide();
        }
    };
    
    $scope.setData = function(info){
       $scope.model.id = info.id;
       $scope.model.regNo = info.regNo;
       $('#tblAuto').hide();
    };
//============================================================================//
//              UPLOAD RESULT EXCEL FILE                                      //
//============================================================================//
    $scope.saveResuleUpload = function (model) {
        $('#loader_process').fadeIn();
        $scope.loadingMsg = {LoadMsg : "Uploading Result"};
        var myData = new FormData();
        var filePath = $('#file').val();
        myData.append('file', model.myFile);
        myData.append('session', model.session);
        myData.append('semester', model.semester);
        myData.append('course', model.course);
        myData.append('type', model.type);
        myData.append('location', filePath);
        $http({
            method: 'post',
            url: './plugins/appSvr/api.php?saveResuleUpload',
            data: myData,
            headers: {'Content-Type': undefined}
        }).then(function (response) {
            $scope.invalidScores = response.data.invalidScores;
            $scope.rsExist = response.data.rsExist;
            $scope.notRegCourse = response.data.notRegCourse;
            $scope.stdNotExist = response.data.stdNotExist;
            
            $scope.invalidScoresCount = response.data.invalidScoresCount;
            $scope.rsExistCount = response.data.rsExistCount;
            $scope.nRegCourseCount = response.data.notRegCourseCount;
            $scope.stdNRegCount = response.data.stdNotExistCount;
            if(response.data.totalStatistic > 0){
                alert("Result Not Uploaded Successfully");
                $('#loader_process').fadeOut();
                $('#alertModal').modal('show');
                
                $scope.getScores(model);
            }else{
                alert(response.data.msg);
                $('#loader_process').fadeOut();
                $('#rsModal').modal('hide');
                $scope.getScores(model);
            }
        });
    };
    
    $scope.saveResuleUploadSingle = function (model) {
        $http.post('./plugins/appSvr/api.php?saveResuleUploadSingle', model).then(function (rs) {
            alert(rs.data.msg);
            $scope.getScores(model);
        });
    };
    
    $scope.removeResuleUpload = function (model) {
        if (confirm("You are about to remove a result of this course")) {
            $http.post('./plugins/appSvr/api.php?removeResuleUpload', model).then(function (rs) {
                alert(rs.data);
                $scope.getScores(model);
            });
        }
    };
//============================================================================//
//                      CURRENT SYSTEM SETTING                                //
//============================================================================//
    $scope.allSession = function () {
        $http.post('./plugins/appSvr/api.php?allSession').then(function (rs) {
            $scope.allSession = rs.data;
//            alert(rs.data.session);
        });
    };
    $scope.allSession();
    
    $scope.settings = function () {
        $http.post('./plugins/appSvr/api.php?settings').then(function (rs) {
            $scope.settings = rs.data;
//            alert(rs.data.session);
        });
    };
    $scope.settings();
    
    $scope.levels = function (info) {
       $scope.level = []; 
       $http.post('./plugins/appSvr/api.php?levels', info).then(function (rs) {
           $scope.level = rs.data;
//            alert(rs.data);
        }); 
    };
//    $scope.levels();
    
    $scope.rs_summary = function (info) {
       $http.post('./plugins/appSvr/api.php?rs_summary', info).then(function (rs) {
            $scope.result_summary = rs.data;
//            alert(rs.data.sp);
        }); 
    };
    
    $scope.getSemesters = function(info){
        if (info.session === undefined) {
            $scope.semesters = [];
            return false;
        }
        $http.post('./plugins/appSvr/api.php?getSemesters').then(function (rs) {
            $scope.semesters = rs.data;
        }); 
    };
    
    $scope.gsc = function(info){
        $http.post('./plugins/appSvr/api.php?gsc', info).then(function (rs) {
            $scope.semesterCourses = rs.data;
            $scope.rs_summary(info);
            if(!((info.semester === undefined) || (info.session === undefined))){
                $scope.getScores(info);
                
            }
        });
    };
    
//============================================================================//
//                              RESULT SHEET                                  //
//============================================================================//
    
    $scope.fetchCourses = function () {
        $http.post('./plugins/appSvr/api.php?fetchCourses').then(function (rs) {
            $scope.courses = rs.data.courses;
//            $scope.grades = rs.data.scores;
            $scope.std = rs.data.std;
//            alert(rs.data.std);
        });
    };
    
    $scope.getScores = function (info) {
       $('#loader_process').fadeIn();
       $scope.loadingMsg = {LoadMsg : "Loading Result"};
       $http.post('./plugins/appSvr/api.php?fetchCourses', info).then(function (rs) {
            $scope.courses = rs.data.courses;
//            $scope.grades = rs.data.scores;
            $scope.current_session = rs.data.session;
            $scope.std = rs.data.std;
//            $scope.rs = rs.data.result;
//            $scope.myco = rs.data.myco;
//            $scope.dpt = r;
            $('#loader_process').delay(10000).fadeOut("slow");
        }); 
    };

//============================================================================//
//                             COMPILE RESULT                                 //
//============================================================================//

    $scope.compileResult = function(info){
       $('#loader_process').fadeIn();
       $scope.loadingMsg = {LoadMsg : "Compiling Result"};
        $http.post('./plugins/appSvr/api.php?compileResult',info).then(function (rs) {
            alert(rs.data);
            $scope.getScores(info);
            $('#loader_process').delay(10000).fadeOut("slow");
        });
    };

//============================================================================//
//                        RESULT CONTROL TESTER                               //
//============================================================================//
    $scope.rsControl = function(){
       $http.post('./plugins/appSvr/api.php?rsControl').then(function (rs) {
            $scope.clength = rs.data;
//            alert(rs.data.cScrSheetLength);
        });  
    };
    $scope.rsControl();

//============================================================================//
//                               CODE TESTER                                  //
//============================================================================//
    $scope.codeTester = function(){
        $http.post('./plugins/appSvr/api.php?codeTester').then(function (rs) {
//            $scope.clength = rs.data;
//            alert(rs.data.remark);
        });
    };
    $scope.codeTester();
});

app.controller('myCtrlAdmin', function ($scope, $http) {
    $scope.urlopt = urlPath;
    
    $scope.getDptList = function () {
       $http.get('../plugins/appSvr/apiAdmin.php?getDptList').then(function (rs) {
            $scope.dpt = rs.data.dpt;
        }); 
    };
    $scope.getDptList();
    
    $scope.levels = function (info) {
        $scope.level = [];
       $http.post('../plugins/appSvr/apiAdmin.php?levels', info).then(function (rs) {
            $scope.level = rs.data;
        }); 
    };
//    $scope.levels();
    
    $scope.rs_summary = function (info) {
        $http.post('../plugins/appSvr/apiAdmin.php?rs_summary', info).then(function (rs) {
            $scope.result_summary = rs.data;
        });
    };
    
    $scope.getSemesters = function(info){
        if (info.session === undefined) {
            $scope.semesters = [];
            return false;
        }
        $http.post('../plugins/appSvr/apiAdmin.php?getSemesters').then(function (rs) {
            $scope.semesters = rs.data;
        }); 
    };
    
    $scope.gsc = function(info){
        $http.post('../plugins/appSvr/apiAdmin.php?gsc', info).then(function (rs) {
            $scope.dptName = rs.data.dName;
            $scope.semesterCourses = rs.data.sc;
            $scope.rs_summary(info);
            
            if(!((info.semester === undefined) || (info.session === undefined))){
                $scope.getScores(info);
                
            }
        });
    };
    
    $scope.getScores = function (info) {
       $('#loader_process').fadeIn();
       $scope.loadingMsg = {LoadMsg : "Loading Result"};
       $http.post('../plugins/appSvr/apiAdmin.php?fetchCourses', info).then(function (rs) {
            $scope.courses = rs.data.courses;
            $scope.grades = rs.data.scores;
            $scope.std = rs.data.std;
//            $scope.dpt = r;
            $('#loader_process').delay(10000).fadeOut("slow");
        }); 
    };
});

//============================================================================//
//============================================================================//
//======================MANAGE SCHOOL/DEPARTMENT CONTROLLER===================//
//============================================================================//
//============================================================================//

app.controller('manageSchDpt', function ($scope, $http) {
    $scope.urlopt = urlPath;
    
    $scope.processStart = function (){
        $('#process').removeClass('hide');
        $('#btnSave').attr('disabled',true);
    };
    
    $scope.processStop = function () {
       $('#process').addClass('hide');
       $('#btnSave').attr('disabled',false); 
    };
    
//============================================================================//
//                                  MANAGE SCHOOL                             //
//============================================================================//
    $scope.createSchool = function(info){
        var btnCtrl = $('#schBtnSave').html();
        $scope.processStart();
        $http.post('../plugins/appSvr/apiAdmin.php?createSchool', {'info' : info, 'Ctrl' : btnCtrl}).then(function (rs) {
            alert(rs.data.msg);
            $('#schBtnSave').html("Save");
            $scope.getSchList();
            $scope.processStop();
        });
    };
    
    $scope.getSchList = function () {
        $http.get('../plugins/appSvr/apiAdmin.php?getSchList').then(function (rs) {
            $scope.schools = rs.data.schools;
        });
    };
    $scope.getSchList();
    
    $scope.delSch = function (id) {
        if (confirm("This School Will Be Deleted Click Ok To Continue")) {
            $http.post('../plugins/appSvr/apiAdmin.php?delSch', {'id': id}).then(function (rs) {
                alert(rs.data.msg);
                $scope.getSchList();
            });
        }
    };
    
    $scope.editSch = function(id){
        $('#schoolModal').modal('show');
        $('#schBtnSave').html("Update");
       $http.post('../plugins/appSvr/apiAdmin.php?editSch', {'id' : id}).then(function (rs) {
            $scope.model = rs.data;
        }); 
    };

//============================================================================//
//                              MANAGE DEPARTMENT                             //
//============================================================================//

    $scope.createDepartment = function(info){
        var btnCtrl = $('#dptBtnSave').html();
        $scope.processStart();
        $http.post('../plugins/appSvr/apiAdmin.php?createDepartment', {'info' : info, 'Ctrl' : btnCtrl}).then(function (rs) {
            alert(rs.data.msg);
            $scope.getDptList();
            $scope.processStop();
        });
    };
    
    $scope.getDptList = function () {
       $http.get('../plugins/appSvr/apiAdmin.php?getDptList').then(function (rs) {
            $scope.dpt = rs.data.dpt;
        }); 
    };
    $scope.getDptList();
    
    $scope.delDpt = function (id) {
        if (confirm("This School Will Be Deleted Click Ok To Continue")) {
            $http.post('../plugins/appSvr/apiAdmin.php?delDpt', {'id': id}).then(function (rs) {
                alert(rs.data.msg);
                $scope.getDptList();
            });
        }
    };
    
    $scope.editDpt = function(id){
        $('#departmentModal').modal('show');
        $('#dptBtnSave').html("Update");
       $http.post('../plugins/appSvr/apiAdmin.php?editDpt', {'id' : id}).then(function (rs) {
            $scope.model = rs.data;
        }); 
    };
   
});

//============================================================================//
//============================================================================//
//===========================MANAGE STUDENT CONTROLLER========================//
//============================================================================//
//============================================================================//

app.controller('manageStudent', function ($scope, $http) {
    $scope.urlopt = urlPath;
    
    $scope.createStudent = function (info) {
        if (!validator.checkAll($('#studentForm'))) {
            return false;
        } else {
            var btnCtrl = $('#stdBtnSave').html();
            $http.post('./plugins/appSvr/api.php?createStudent', {'info': info, 'Ctrl': btnCtrl}).then(function (rs) {
                alert(rs.data.msg);
                $scope.getStudentList();
            });
        }

    };

    $scope.editStudent = function (id) {
        $('#stdBtnSave').html("Update");
        $('#studentModal').modal('show');
        $http.post('./plugins/appSvr/api.php?editStudent', {'id': id}).then(function (rs) {
            $scope.model = rs.data;
        });
    };

    $scope.getStudentList = function () {
        $http.get('./plugins/appSvr/api.php?getStudentList').then(function (rs) {
            $scope.students = rs.data;
        });
    };
    $scope.getStudentList();

    $scope.getDepartmentList = function () {
        $http.get('./plugins/appSvr/api.php?getDepartmentList').then(function (rs) {
            $scope.schDpt = rs.data.dpt;
        });
    };
    $scope.getDepartmentList();

    $scope.getSession = function () {
        $http.post('./plugins/appSvr/api.php?getSession').then(function (rs) {
            $scope.sessions = rs.data;
        });
    };
    $scope.getSession();
});

//============================================================================//
//============================================================================//
//===========================MANAGE COURSES CONTROLLER========================//
//============================================================================//
//============================================================================//

app.controller('manageCourses', function ($scope, $http) {
    $scope.urlopt = urlPath; 
    
    $scope.createCourse = function (info) {
        if (!validator.checkAll($('#courseModal'))) {
            return false;
        } else {
            var btnCtrl = $('#cBtnSave').html();
            $http.post('./plugins/appSvr/api.php?createCourse', {'info': info, 'Ctrl': btnCtrl}).then(function (rs) {
                alert(rs.data.msg);
                $scope.getCoursesList();
                $('#courseModal').modal('hide');
                $('#cBtnSave').html("Save");
            });
        }
    };
    
    $scope.editCourse = function (id) {
        $('#cBtnSave').html("Update");
        $http.post('./plugins/appSvr/api.php?editCourse', {'id': id}).then(function (rs) {
            $scope.model = rs.data;
            $('#courseModal').modal('show');
        });
    };
    
    $scope.getpre_requisite = function () {
        $http.get('./plugins/appSvr/api.php?getpre_requisite').then(function (rs) {
            $scope.pre_requisites = rs.data;
        });
    };
    $scope.getpre_requisite();
    
    $scope.getCoursesList = function () {
        $http.get('./plugins/appSvr/api.php?getCoursesList').then(function (rs) {
            $scope.courses = rs.data;
        });
    };
    $scope.getCoursesList();

    
    $scope.getDepartmentList = function () {
        $http.get('./plugins/appSvr/api.php?getDepartmentList').then(function (rs) {
            $scope.schDpt = rs.data.dpt;
        });
    };
    $scope.getDepartmentList();
    
    
    $scope.checkAll = function () {
        $scope.info.courses = angular.copy($scope.courses);
    };
    
    $scope.display = function () {
        alert(info);
    };
});

//============================================================================//
//============================================================================//
//==========================COURSES REGISTRATIO CONTROLLER====================//
//============================================================================//
//============================================================================//

app.controller('Ctrl3', function ($scope, $http) {
    $scope.urlopt = urlPath;
    $scope.courses = [];
    $scope.info = {};
    
    $scope.autocopilete = function (info) {
        var min_length = 1;
        if (info.regNo.length > min_length) {
            $('#tblAuto').show();
            $http.post('./plugins/appSvr/api.php?autocopilete', info).then(function (rs) {
                $scope.stdRegNo = rs.data;
            });
        } else {
            $('#tblAuto').hide();
        }
    };
    
    $scope.setData = function(info){
       
       $scope.model = info;
       $('#tblAuto').hide();
       $scope.getStdCourses(info);
    };
    
    $scope.getStdCourses = function (info) {
        $('#loader_process').fadeIn();
        $scope.loadingMsg = {LoadMsg : "Loading Courses"};
        $scope.info.courses = [];
//        $scope.courses = [];
        $http.post('./plugins/appSvr/api.php?getStdCourses', info).then(function (rs) {
            $('#loader_process').delay(1000).fadeOut("slow");
            if(rs.data.stdStatus == 10){
                alert("This Student graduated Successfully");
                $scope.registed = [];
                $scope.courses = [];
                return false;
            }
            if(rs.data.stdStatus == 0){
                 alert("This Student is withdrawn");
                $scope.registed = [];
                $scope.courses = [];
                return false;
            }
            if(rs.data.chk >= 0){
               $scope.courses = [];
               $scope.info.courses = rs.data.registered;
               $scope.registed = $scope.info.courses;
               $scope.courses = rs.data.cList; 
               $scope.record = rs.data.chk;
            }
            $scope.totalUnits = rs.data.tcu;
            $scope.maxu = rs.data.maxunit;
            $scope.stdTsu = {mytsu : rs.data.stdTsu};
            $scope.rCount = {rNum : rs.data.rCount};
            $scope.totalCourses = {total : rs.data.totalCoursesRegistered};
//            alert(rs.data.msg);
        });
    };
    
    $scope.saveCourseRegisted = function (model) {
        var Allcourses = $scope.info.courses;
        $http.post('./plugins/appSvr/api.php?saveCourseRegisted', {'id': model.id, 'info': Allcourses}).then(function (rs) {
            alert(rs.data.msg);
            $scope.getStdCourses(model);
        });
    };
    
    $scope.remove_course = function (c_id, info) {
        if (confirm("Are you sure to drop this course")) {
            $http.post('./plugins/appSvr/api.php?remove_course', {c_id: c_id, std_id: info.id}).then(function (rs) {
                alert(rs.data.msg);
                $scope.getStdCourses(info);
            });
        }
    };
    
    $scope.display = function (unitalow) {
        $scope.registed = $scope.info.courses;
        var sum = 0;
        for(var i in $scope.info.courses){
            sum += parseInt($scope.info.courses[i].cu);
        }
        if(sum > unitalow){
            alert("Sorry You are not allowed to register above Max Unit");
            $scope.info.courses.pop($scope.courses[2]);
            return false;
        }
        $scope.totalUnit = sum;
    };
    
    $scope.checkAll = function () {
        $scope.info.courses = angular.copy($scope.courses);
    };
    
    $scope.uncheckAll = function () {
        $scope.info.courses = [];
    };

});

//============================================================================//
//============================================================================//
//=============================GRADE SCHEME CONTROLLER========================//
//============================================================================//
//============================================================================//
app.controller('gradeSchemeCtrl', function($scope, $http){
    $scope.urlopt = urlPath;
    $scope.newScheme = [];
    
    $scope.addScheme = function(){
        var scheme = [];
        var from;
        var to;
        var grade;
        var gp;
        var remark;
        if(!validator.checkAll($('#gradeSchemeForm'))){
            return false;
        }
        angular.forEach($scope.newScheme, function (value) {
            from = value.from;
            to = value.to;
            grade = value.grade;
            gp = value.gp;
            remark = value.remark;
        });
        if (from === $scope.from && to === $scope.to) {
            $('#scoreAlert').fadeIn(1000).delay(3000).fadeOut(1000);
            return false;
        }
        if(grade === $scope.grade){
           $('#scoreAlert').html("Sorry this Grade already use in the Scheme");
           $('#scoreAlert').fadeIn(1000).delay(3000).fadeOut(1000);
            return false; 
        }
        if(gp === $scope.gp){
           $('#scoreAlert').html("Sorry this Grade Point already use in the Scheme");
           $('#scoreAlert').fadeIn(1000).delay(3000).fadeOut(1000);
            return false; 
        }
        scheme.from = $scope.from;
        scheme.to = $scope.to;
        scheme.grade = $scope.grade;
        scheme.gp = $scope.gp;
        scheme.remark = $scope.remark;
        $scope.newScheme.push(scheme);
        
    };
    
    $scope.removeScheme = function(){
       var arrScheme = [];
       angular.forEach($scope.newScheme, function(value){
           if(!value.remove){
               arrScheme.push(value);
           }
       });
       $scope.newScheme = arrScheme;
    };
    
    $scope.saveScheme = function(){
        var obj;
        var newSchemeList = [];
        angular.forEach($scope.newScheme, function(vals){
            obj = {
               'from'   : vals.from,
               'to'     : vals.to,
               'grade'  : vals.grade,
               'gp'     : vals.gp,
               'remark' : vals.remark
            };
            newSchemeList.push(obj);
        });
        if(confirm("Are you sure to create this scheme")){
            $http.post('../plugins/appSvr/apiAdmin.php?saveScheme', newSchemeList).then(function (rs) {
                $scope.getGradeSchemeList();
                $scope.newScheme = [];
                $('#schemeList').trigger('click');
                $('#btnReset').trigger('click');
                alert(rs.data.msg);
            });
        }
    };
    
    $scope.allSession = function () {
        $http.post('../plugins/appSvr/apiAdmin.php?allSession').then(function (rs) {
            $scope.allSession = rs.data;
        });
    };
    $scope.allSession();
    
    $scope.getGradeSchemeList = function () {
        $http.get('../plugins/appSvr/apiAdmin.php?getGradeSchemeList').then(function (rs) {
            $scope.gradeScheme = rs.data.gradeScheme;
        });
    };
    $scope.getGradeSchemeList();
    
    $scope.setGradeSchemeEffect = function(info){
        $http.post('../plugins/appSvr/apiAdmin.php?setGradeSchemeEffect', info).then(function (rs) {
            $scope.getGradeSchemeList();
            alert(rs.data.msg);
        });
    };
    
    $scope.viewGradeScheme = function (scheme_code) {
        $scope.viewScheme = [];
        $http.post('../plugins/appSvr/apiAdmin.php?viewGradeScheme', {'scheme_code': scheme_code}).then(function (rs) {
            $('#viewGradeSchemeModal').modal('show');
            $scope.viewScheme = rs.data;
        });
    };
});

//============================================================================//
//============================================================================//
//===========================CLASS/REMARK SCHEME CONTROLLER===================//
//============================================================================//
//============================================================================//
app.controller('classRemarkSchemeCtrl', function($scope, $http){
    $scope.urlopt = urlPath;
    $scope.newScheme = [];
    $scope.newRemarkSchem = [];
    
    //<!-- REMARK SCHEME -->
    $scope.addSchemeRemark = function (){
        var scheme = [];
        var remarkGpaFrom;
        var remarkGpaTo;
        var remark;
        
        if(!validator.checkAll($('#remarkSchemeForm'))){
            return false;
        }
        
        angular.forEach($scope.newRemarkSchem, function (value) {
            remarkGpaFrom = value.remarkGpaFrom;
            remarkGpaTo = value.remarkGpaTo;
            remark = value.remark;
        });
        
        if (remarkGpaFrom === $scope.remarkGpaFrom && remarkGpaTo === $scope.remarkGpaTo) {
            $('#scoreAlert2').html("GPA/CGPA Range Already Added To The List");
            $('#scoreAlert2').fadeIn(1000).delay(3000).fadeOut(1000);
            return false;
        }
        if(remark === $scope.remark){
           $('#scoreAlert2').html("Sorry this Remark already use in the Scheme");
           $('#scoreAlert2').fadeIn(1000).delay(3000).fadeOut(1000);
            return false; 
        }
        
        scheme.remarkGpaFrom = $scope.remarkGpaFrom;
        scheme.remarkGpaTo = $scope.remarkGpaTo;
        scheme.remark = $scope.remark;
        $scope.newRemarkSchem.push(scheme);
    };
    
    $scope.removeSchemeRemark = function(){
       var arrSchemeRemark = [];
       
       angular.forEach($scope.newRemarkSchem, function(value){
           if(!value.removeRemark){
               arrSchemeRemark.push(value);
           }
       });
       $scope.newRemarkSchem = arrSchemeRemark;
    };
    
    $scope.saveSchemeRemark = function(){
        var obj;
        var newSchemeList = [];
        angular.forEach($scope.newRemarkSchem, function(vals){
            obj = {
               'from'   : vals.remarkGpaFrom,
               'to'     : vals.remarkGpaTo,
               'remark'  : vals.remark
            };
            newSchemeList.push(obj);
        });
        if(confirm("Are you sure to create this scheme")){
            $http.post('../plugins/appSvr/apiAdmin.php?saveSchemeRemark', newSchemeList).then(function (rs) {
                $scope.newRemarkSchem = [];
                $('#scheme_remark_list').trigger('click');
                $('#btnReset').trigger('click');
                $scope.getRemarkSchemeList();
                alert(rs.data.msg);
            });
        }
    };
    
     $scope.getRemarkSchemeList = function () {
        $http.get('../plugins/appSvr/apiAdmin.php?getRemarkSchemeList').then(function (rs) {
            $scope.remarkScheme = rs.data;
        });
    };
    $scope.getRemarkSchemeList();
    
    $scope.viewRemarkScheme = function (myscheme) {
        $('#viewRemarkSchemeModal').modal('show');
        $scope.vrScheme = myscheme;
    };
    
    $scope.closeModel = function () {
        $('#viewRemarkSchemeModal').modal('hide');
//        window.location = "";
    };
    
    $scope.setRemarkSchemeEffect = function(info){
        $http.post('../plugins/appSvr/apiAdmin.php?setRemarkSchemeEffect', info).then(function (rs) {
            $scope.getRemarkSchemeList();
            alert(rs.data.msg);
        });
    };
    //<!-- / .REMARK SCHEME -->
    
    $scope.addSchemeClassRemark = function(){
        var scheme = [];
        var from;
        var to;
        var classRemark;
        if(!validator.checkAll($('#gradeSchemeForm'))){
            return false;
        }
        angular.forEach($scope.newScheme, function (value) {
            from = value.from;
            to = value.to;
            classRemark = value.classRemark;
        });
        if (from === $scope.from && to === $scope.to) {
            $('#scoreAlert').html("GPA Range Already Added To The List");
            $('#scoreAlert').fadeIn(1000).delay(3000).fadeOut(1000);
            return false;
        }
        if(classRemark === $scope.classRemark){
           $('#scoreAlert').html("Sorry this Remark already use in the Scheme");
           $('#scoreAlert').fadeIn(1000).delay(3000).fadeOut(1000);
            return false; 
        }
        scheme.from = $scope.from;
        scheme.to = $scope.to;
        scheme.classRemark = $scope.classRemark;
        $scope.newScheme.push(scheme);
        
    };
    
    $scope.removeScheme = function(){
       var arrScheme = [];
       angular.forEach($scope.newScheme, function(value){
           if(!value.remove){
               arrScheme.push(value);
           }
       });
       $scope.newScheme = arrScheme;
    };
    
    $scope.saveSchemeClass = function(){
        var obj;
        var newSchemeList = [];
        angular.forEach($scope.newScheme, function(vals){
            obj = {
               'from'   : vals.from,
               'to'     : vals.to,
               'class' : vals.classRemark
            };
            newSchemeList.push(obj);
        });
        if(confirm("Are you sure to create this scheme")){
            $http.post('../plugins/appSvr/apiAdmin.php?saveSchemeClass', newSchemeList).then(function (rs) {
                $scope.getClassSchemeList();
                $scope.newScheme = [];
                $('#scheme_list').trigger('click');
                $('#btnReset').trigger('click');
                alert(rs.data.msg);
            });
        }
    };
    
    $scope.getClassSchemeList = function () {
        $http.get('../plugins/appSvr/apiAdmin.php?getClassSchemeList').then(function (rs) {
            $scope.classScheme = rs.data.classScheme;
        });
    };
    $scope.getClassSchemeList();
    
    $scope.viewClassScheme = function (class_code) {
        $http.post('../plugins/appSvr/apiAdmin.php?viewClassScheme', {'class_code': class_code}).then(function (rs) {
            $('#viewClassSchemeModal').modal('show');
            $scope.vcScheme = rs.data;
        });
    };
    
    $scope.setClassSchemeEffect = function(info){
        $http.post('../plugins/appSvr/apiAdmin.php?setClassSchemeEffect', info).then(function (rs) {
            $scope.getClassSchemeList();
            alert(rs.data.msg);
        });
    };
});

app.controller('systemSettingsCtrl', function ($scope, $http){
    $scope.urlopt = urlPath;
    
    $scope.myLinks = [];
    $scope.linksToRemove = [];
    $scope.info = {};
    
    $scope.setCurrentSettings = function (info) {

        if (!validator.checkAll($('#setCurrentSettings'))) {
            return false;
        }
        $http.post('./plugins/appSvr/api.php?setCurrentSettings', info).then(function (rs) {
            $scope.getCurrentSettings();
            alert(rs.data.msg);
        });
    };
    
    $scope.getCurrentSettings = function () {
        $http.post('./plugins/appSvr/api.php?getCurrentSettings').then(function (rs) {
            $scope.model = rs.data;
        }); 
    };
    $scope.getCurrentSettings();
    
    $scope.getUsersList = function(){
        $http.post('./plugins/appSvr/api.php?getUsersList').then(function (rs) {
            $scope.usersList = rs.data;
        });
    };
    $scope.getUsersList();
    
    $scope.createUsers = function (model) {
        $http.post('./plugins/appSvr/api.php?createUsers', model).then(function (rs) {
            alert(rs.data.msg);
            $scope.getUsersList();
        });
    };
    
    $scope.removeUserAdmin = function (id) {
        if(confirm("Are you sure to delete this user")){
            $http.post('./plugins/appSvr/api.php?removeUserAdmin', {id: id}).then(function (rs) {
                alert(rs.data.msg);
                $scope.getUsersList();
            });
        }
    };
    
    $scope.getMyLinks = function (info) {
        $scope.myLinks = info;
        $('#permissionModal').modal('show');
    };
    
    $scope.getLinksToRemove = function (info) {
        $scope.linksToRemoveIn = info;
        $('#permissionRemoveModal').modal('show');
    };
    
    $scope.saveNewPermission = function () {
        var upermission = $scope.info.myLinks;
        $http.post('./plugins/appSvr/api.php?saveNewPermission', upermission).then(function (rs) {
            alert(rs.data.msg);
            $('#permissionModal').modal('hide');
            $scope.myLinks = [];
            $scope.getUsersList();
        });
    };
    
    $scope.removePermission = function () {
        var upermission = $scope.info.linksToRemove;
        $http.post('./plugins/appSvr/api.php?removePermission', upermission).then(function (rs) {
            alert(rs.data.msg);
            $scope.linksToRemoveIn = [];
            $('#permissionRemoveModal').modal('hide');
            $scope.getUsersList();
        });
    };
});

app.controller('systemSettingsCtrlAdmin', function ($scope, $http){
    $scope.urlopt = urlPath;
    
    $scope.myLinks = [];
    $scope.linksToRemove = [];
    $scope.info = {};
    
    $scope.getDptList = function () {
       $http.get('../plugins/appSvr/apiAdmin.php?getDptList').then(function (rs) {
            $scope.dpt = rs.data.dpt;
        }); 
    };
    $scope.getDptList();
    
    $scope.setCurrentSettings = function (info) {

        if (!validator.checkAll($('#setCurrentSettings'))) {
            return false;
        }
        $http.post('../plugins/appSvr/apiAdmin.php?setCurrentSettings', info).then(function (rs) {
            $scope.getCurrentSettings();
            alert(rs.data.msg);
        });
    };
    
    $scope.getCurrentSettings = function () {
        $http.post('../plugins/appSvr/apiAdmin.php?getCurrentSettings').then(function (rs) {
            $scope.model = rs.data;
        }); 
    };
    $scope.getCurrentSettings();
    
    $scope.getUsersList = function(){
        $http.post('../plugins/appSvr/apiAdmin.php?getUsersList').then(function (rs) {
            $scope.usersList = rs.data;
        });
    };
    $scope.getUsersList();
    
    $scope.createUsers = function (model) {
        $http.post('../plugins/appSvr/apiAdmin.php?createUsers', model).then(function (rs) {
            alert(rs.data.msg);
            $scope.getUsersList();
        });
    };
    
    $scope.removeUserAdmin = function (id) {
        if(confirm("Are you sure to delete this user")){
            $http.post('../plugins/appSvr/apiAdmin.php?removeUserAdmin', {id: id}).then(function (rs) {
                alert(rs.data.msg);
                $scope.getUsersList();
            });
        }
    };
    
    $scope.getMyLinks = function (info) {
        $scope.myLinks = info;
        $('#permissionModal').modal('show');
    };
    
    $scope.getLinksToRemove = function (info) {
        $scope.linksToRemoveIn = info;
        $('#permissionRemoveModal').modal('show');
    };
    
    $scope.saveNewPermission = function () {
        var upermission = $scope.info.myLinks;
        $http.post('../plugins/appSvr/apiAdmin.php?saveNewPermission', upermission).then(function (rs) {
            alert(rs.data.msg);
            $('#permissionModal').modal('hide');
            $scope.myLinks = [];
            $scope.getUsersList();
        });
    };
    
    $scope.removePermission = function () {
        var upermission = $scope.info.linksToRemove;
        $http.post('../plugins/appSvr/apiAdmin.php?removePermission', upermission).then(function (rs) {
            alert(rs.data.msg);
            $scope.linksToRemoveIn = [];
            $('#permissionRemoveModal').modal('hide');
            $scope.getUsersList();
        });
    };
});

app.controller('transcriptCtrl', function ($scope, $http){
    $scope.urlopt = urlPath;
    
    $scope.autocopilete = function (info) {
        var min_length = 1;
        if (info.regNo.length > min_length) {
            $('#tblAuto').show();
            $http.post('./plugins/appSvr/api.php?autocopilete', info).then(function (rs) {
                $scope.stdRegNo = rs.data;
            });
        } else {
            $('#tblAuto').hide();
        }
    };
    
    $scope.setData = function(info){
       
       $scope.model = info;
       $('#tblAuto').hide();
    };
    
    $scope.get_transcript = function(model){
        $('#loader_process').fadeIn();
        $scope.loadingMsg = {LoadMsg : "Proccessing Transcript"};
        $http.post('./plugins/appSvr/api.php?get_transcript', model).then(function (rs) {
            $scope.transcriptModel = rs.data.raw_marks;
            $scope.myGrade = rs.data.rs_grade;
            $scope.stdsession = rs.data.mysession;
             $('#loader_process').delay(10000).fadeOut("slow");
//            alert(rs.data.msg);
        });
    };
    
});

app.controller('transcriptCtrlAdmin', function ($scope, $http){
    $scope.urlopt = urlPath;
    
    $scope.getDptList = function () {
       $http.get('../plugins/appSvr/apiAdmin.php?getDptList').then(function (rs) {
            $scope.dpt = rs.data.dpt;
        }); 
    };
    $scope.getDptList();
    
    $scope.autocopilete = function (info) {
        var min_length = 1;
        if (info.regNo.length > min_length) {
            $('#tblAuto').show();
            $http.post('../plugins/appSvr/apiAdmin.php?autocopilete', info).then(function (rs) {
                $scope.stdRegNo = rs.data;
            });
        } else {
            $('#tblAuto').hide();
        }
    };
    
    $scope.setData = function(info){
       $scope.model = info;
       
       $('#tblAuto').hide();
    };
    
    $scope.get_transcript = function(model){
        $('#loader_process').fadeIn();
        $scope.loadingMsg = {LoadMsg : "Proccessing Transcript"};
        $http.post('../plugins/appSvr/apiAdmin.php?get_transcript', model).then(function (rs) {
            $scope.transcriptModel = rs.data.raw_marks;
            $scope.myGrade = rs.data.rs_grade;
            $scope.stdsession = rs.data.mysession;
            $scope.dptName = rs.data.dName;
             $('#loader_process').delay(10000).fadeOut("slow");
//            alert(rs.data.msg);
        });
    };
    
});

app.controller('myGraduationList',  function ($scope, $http){
    $scope.urlopt = urlPath;
    
    $scope.getGraduationList = function (model) {
        $('#loader_process').fadeIn();
        $scope.loadingMsg = {LoadMsg : "Loading List"};
        $http.post('./plugins/appSvr/api.php?getGraduationList', model).then(function (rs) {
            $scope.gList = rs.data;
            $('#loader_process').delay(5000).fadeOut("slow");
        });
    };
});

app.controller('myGraduationListAdmin',  function ($scope, $http){
    $scope.urlopt = urlPath;
    
    $scope.getDptList = function () {
       $http.get('../plugins/appSvr/apiAdmin.php?getDptList').then(function (rs) {
            $scope.dpt = rs.data.dpt;
        }); 
    };
    $scope.getDptList();
    
    $scope.getGraduationList = function (model) {
        $('#loader_process').fadeIn();
        $scope.loadingMsg = {LoadMsg : "Loading List"};
        $http.post('../plugins/appSvr/apiAdmin.php?getGraduationList', model).then(function (rs) {
            $scope.dptName = rs.data.dName;
            $scope.gList = rs.data.getList;
            $('#loader_process').delay(1000).fadeOut("slow");
        });
    };
});