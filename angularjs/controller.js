var app = angular.module('controller', ['datatables','ui.router','ui.bootstrap','checklist-model','ngStorage']);

var url = $(location).attr('pathname');
var len = url.length;
var maint = url.substr(5, len - 5);
var urlPath = {
    curentUrl : maint
};

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

app.directive('accessLink', ['getData', function (getData){
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            
            element.hide();
            
            var permissions = attrs.accessLink.split(",");
            for (var i = 0; i < permissions.length; i++){
                permissions[i] = permissions[i].trim();
            }
            
                getData.sessionData().then(function (rs) {
                    var json = JSON.parse(rs);
                    for (var j = 0; j < permissions.length; j++) {
                        if (json.logerType === permissions[j]) {
                            element.show();
                        }
                    }
                    
                });
            
            getData.userPermission().then(function (userPermissions) {
                var json = JSON.parse(userPermissions);
                    for (var i = 0; i < json.length; i++) {
                        for (var j = 0; j < permissions.length; j++) {
                            if(json[i] === permissions[j]){
                                element.show();
                            }
                        }
                    }
            });
        }
    };    
}]);

function requestLinks(method, link, datas) {
    var req = {
        method: method,
        url: 'http://localhost/RMS_CONTROLLER/controller.php?' + link,
        headers: {
            'Content-Type': undefined
        },
        data: datas
    };
    return req;
}

function downloadLinks(method, link, datas) {
    var req = {
        method: method,
        url: 'http://localhost/RMS_CONTROLLER/download.php?' + link,
        headers: {
            'Content-Type': undefined
        },
        responseType: 'blob',
        data: datas
    };
    return req;
}

function requestSessionData(method, link, datas) {
    var req = {
        method: method,
        url: './plugins/appSvr/api.php?' + link,
        headers: {
            'Content-Type': undefined
        },
        data: datas
    };
    return req;
}

app.factory("getData", function ($http, $q){
    
    return {
        
        loader: function (){
            return {
                start: function() {
                    $('#loader_process').fadeIn();
                },
                stop: function(){
                    $('#loader_process').delay(500).fadeOut("slow"); 
                }
            };
        },
        startSession: function (info) {
            
            var deferred = $q.defer();
            $.post('./plugins/appSvr/api.php?startSession', info, function (rs) {
                deferred.resolve(rs);
            }).catch(function (rs) {
                deferred.reject(rs);
            });
            return deferred.promise;
            
        },
        sessionData: function () {
            
            var deferred = $q.defer();
            $.post('./plugins/appSvr/api.php?getDepartmentId', function (rs) {
                deferred.resolve(rs);
            }).catch(function (rs) {
                deferred.reject(rs);
            });
            return deferred.promise;
            
        },
        userPermission: function () {
            
            var deferred = $q.defer();
            $.post('./plugins/appSvr/api.php?userPermission', function (rs) {
                deferred.resolve(rs);
            }).catch(function (rs) {
                deferred.reject(rs);
            });
            return deferred.promise;
        },
        userLogin: function (info) {
            
            var deferred = $q.defer();
            $http(requestLinks('POST', 'login', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        coursesToRegister: function (list) {
            var coursesList = [];
            var deferred = $q.defer();
            angular.forEach(list, function(x){
                if(x.Selected){
                    coursesList.push(x);
                }
                setTimeout(function(){
                    if(coursesList.length > 0){
                        deferred.resolve(coursesList);
                    }else{
                        deferred.reject("Please Select From The Courses List");
                    }
                }, 100);
            });
            return deferred.promise;
        },
        validateGradeScheme: function (scheme, obj) {
            var deferred = $q.defer();
            var results = {
                success: true,
                message: '',
                items:
                        {'from': obj.from, 'to': obj.to, 'grade': obj.grade,
                            'gp': obj.gp, 'remark': obj.remark
                        }
            };
            if(scheme.length === 0){
                 deferred.resolve(results.items);
            }
            angular.forEach(scheme, function(x){
                if(x.gp === obj.gp){
                    results.success = false;
                    results.message = "Grade Point Allready Added";
                }
                if(x.grade === obj.grade){
                    results.success = false;
                    results.message = "Grade Allready Added";
                }
                if(x.from === obj.from && x.to === obj.to){
                    results.success = false;
                    results.message = "Score Range Allready Added";
                }
                setTimeout(function(){
                    if(results.success){
                        deferred.resolve(results.items);
                    }else{
                        deferred.reject(results.message);
                    }
                }, 100);
            });
            return deferred.promise;
        },
        validateClassScheme: function (scheme, obj) {
            var deferred = $q.defer();
            var results = {
                success: true,
                message: '',
                items: {
                    'from': obj.from,
                    'to': obj.to,
                    'remark': obj.classRemark
                }
            };
            if(scheme.length === 0){
                 deferred.resolve(results.items);
            }
            angular.forEach(scheme, function(x){
                if(x.remark === obj.classRemark){
                    results.success = false;
                    results.message = "Rmark Already Added";
                }
                if(x.from === obj.from && x.to === obj.to){
                    results.success = false;
                    results.message = "GPA/CGPA Range Already Added";
                }
                setTimeout(function(){
                    if(results.success){
                        deferred.resolve(results.items);
                    }else{
                        deferred.reject(results.message);
                    }
                }, 100);
            });
            return deferred.promise;
        },
        validateResultRemarkScheme: function (scheme, obj) {
            var deferred = $q.defer();
            var results = {
                success: true,
                message: '',
                items: {
                    'remarkGpaFrom': obj.remarkGpaFrom,
                    'remarkGpaTo': obj.remarkGpaTo,
                    'remark': obj.remark
                }
            };
            if(scheme.length === 0){
                 deferred.resolve(results.items);
            }
            angular.forEach(scheme, function(x){
                if(x.remark === obj.remark){
                    results.success = false;
                    results.message = "Rmark Already Added";
                }
                if(x.remarkGpaFrom === obj.remarkGpaFrom && x.remarkGpaTo === obj.remarkGpaTo){
                    results.success = false;
                    results.message = "GPA/CGPA Range Already Added";
                }
                setTimeout(function(){
                    if(results.success){
                        deferred.resolve(results.items);
                    }else{
                        deferred.reject(results.message);
                    }
                }, 100);
            });
            return deferred.promise;
        },
        compileResult: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'compileResult', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        graduatedSession: function (info) {

            var deferred = $q.defer();
            $http(requestLinks('POST', 'graduatedSession', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;

        },
        newChildPermissions: function (list, id) {
            var permissions = [];
            var deferred = $q.defer();
            angular.forEach(list, function(x){
                if(x.Selected){
                    var datas = {
                        'userId' : id,
                        'linkId' : x.id
                    }
                    permissions.push(datas);
                }
                setTimeout(function(){
                    if(permissions.length > 0){
                        deferred.resolve(permissions);
                    }else{
                        deferred.reject("Please Select From The Permission List");
                    }
                }, 100);
            });
            return deferred.promise;
        },
        childPermissionsToRemove: function (list, id) {
            var permissions = [];
            var deferred = $q.defer();
            angular.forEach(list, function(x){
                if(x.Selected){
                    var datas = {
                        'userId' : id,
                        'linkId' : x.id
                    }
                    permissions.push(datas);
                }
                setTimeout(function(){
                    if(permissions.length > 0){
                        deferred.resolve(permissions);
                    }else{
                        deferred.reject("Please Select From The Permission List");
                    }
                }, 100);
            });
            return deferred.promise;
        }
    };
});

app.factory("Save", function ($http, $q) {
    
    return {
        school: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveSchool', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        department: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveDepartment', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        student: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveStudent', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        course: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveCourse', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        gradeScheme: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveGradeScheme', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        classScheme: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveClassScheme', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        remarkScheme: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveRemarkScheme', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        coursesRegistered: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveCourseRegisted', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        resultUpload: function (info) {
            var fd = new FormData();
            fd.append('file', info.myFile);
            fd.append('programs', info.programs);
            fd.append('level', info.level);
            fd.append('semesterUpload', info.semesterUpload);
            fd.append('courseId', info.courseId);
            var deferred = $q.defer();
            $http(requestLinks('POST', 'resultUpload', fd))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        resultUploadSingle: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'resultUploadSingle', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        childPermission: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveChildPermission', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        systemUser: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'saveSystemUser', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        }
    };
});

app.factory("Update", function ($http, $q) {

    return {
        school: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'updateSchool', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        department: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'updateDepartment', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        student: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'updateStudent', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        course: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'updateCourse', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        gradeSchemeActive: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'updateGradeSchemeActive', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        classSchemeActive: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'updateClassSchemeActive', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        remarkSchemeActive: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'updateRemarkSchemeActive', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        systemSettings: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'updateSystemSettings', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        }
    };
});

app.factory("fetch", function ($http, $q) {
    
    return {
        autocopileteStudent: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'filterStudent', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        autocopileteStudentTranscript: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'filterStudentTranscript', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        schools: function () {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getSchools', {}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        department: function () {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getDepartment', {}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        students: function (departmentId) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getStudents', {departmentId : departmentId}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        courses: function (departmentId) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getCourses', {departmentId : departmentId}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        gradeScheme: function () {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getGradeScheme', {}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        gradeSchemeItems: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getGradeSchemeItems', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        classScheme: function () {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getClassScheme', {}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        classSchemeItems: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getClassSchemeItems', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        remarkScheme: function () {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getRemarkScheme', {}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        remarkSchemeItems: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getRemarkSchemeItems', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        levels: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getLvels', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        semesters: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getSemesters', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        semesterCourses: function (info) {
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getSemesterCourses', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        Result: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getResult', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        ResultPrint: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getResultPrint', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        graduatedStudent: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getGraduatedStudent', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        currentSystemSettings: function (){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getCurrentSystemSettings', {}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        systemUser: function (){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getSystemUser', {}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        availablePermissions: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getAvailablePermissions', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        childPermissions: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'getChildPermissions', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        }
    };
});

app.factory("Delete", function ($http, $q) {
    
    return {
        systemUser: function (info) {
            var deferred = $q.defer();
            if (confirm("Delete This User")) {
                $http(requestLinks('POST', 'deleteSystemUser', info))
                        .then(function (rs) {
                            deferred.resolve(rs.data.success);
                        })
                        .catch(function (rs) {
                            deferred.reject(rs);
                        });
            }else {
                var rj = {message : "Operation Cancel"};
                deferred.reject(rj);
            }
            return deferred.promise;
        },
        school: function (info) {
            var deferred = $q.defer();
            if (confirm("Delete This Record")) {
                $http(requestLinks('POST', 'deleteSchool', info))
                        .then(function (rs) {
                            deferred.resolve(rs.data.success);
                        })
                        .catch(function (rs) {
                            deferred.reject(rs);
                        });
            }
            return deferred.promise;
        },
        department: function (info) {
            var deferred = $q.defer();
            if (confirm("Delete This Record")) {
                $http(requestLinks('POST', 'deleteDepartment', info))
                        .then(function (rs) {
                            deferred.resolve(rs.data.success);
                        })
                        .catch(function (rs) {
                            deferred.reject(rs);
                        });
            }
            return deferred.promise;
        },
        coursesRegistered: function (info) {
            var deferred = $q.defer();
            if (confirm("Drop This Course")) {
                $http(requestLinks('POST', 'dropCourseRegistered', info))
                        .then(function (rs) {
                            deferred.resolve(rs.data.success);
                        })
                        .catch(function (rs) {
                            deferred.reject(rs);
                        });
            }
            return deferred.promise;
        },
        scoreSheet: function (info){
            var deferred = $q.defer();
            if (confirm("Remove this course scores")) {
                $http(requestLinks('POST', 'removeScoreSheet', info))
                        .then(function (rs) {
                            deferred.resolve(rs.data.success);
                        })
                        .catch(function (rs) {
                            deferred.reject(rs);
                        });
            }
            return deferred.promise;
        },
        childPermission: function (info){
            var deferred = $q.defer();
            $http(requestLinks('POST', 'removeChildPermission', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data.success);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        }
    };
});

app.factory("download", function ($http, $q){
    
    return {
        coursesRegistered: function (info, courses) {
            var deferred = $q.defer();
            $http(downloadLinks('POST', 'coursesRegistered', {info: info, courses: courses}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        resultAcademicBoard: function (info, result, courses) {
            var deferred = $q.defer();
            $http(downloadLinks('POST', 'resultAcademicBoard', {info: info, result: result, courses: courses}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        resultNoticeBoard: function (info, result, courses) {
            var deferred = $q.defer();
            $http(downloadLinks('POST', 'resultNoticeBoard', {info: info, result: result, courses: courses}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        transcript: function (info) {
            var deferred = $q.defer();
            $http(downloadLinks('POST', 'transcript', info))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        },
        graduatedStudentList: function (list, info) {
            var deferred = $q.defer();
            $http(downloadLinks('POST', 'graduatedStudentList', {info: info, list: list}))
                    .then(function (rs) {
                        deferred.resolve(rs.data);
                    })
                    .catch(function (rs) {
                        deferred.reject(rs);
                    });
            return deferred.promise;
        }
    };
});

app.controller('login', function ($scope, $http, getData) {
    
    $scope.userLogin = function (info) {
        $('#btnLoging').attr('disabled', true);
        $('#processorState').addClass('callout-info');
        $('#processorState').html("Authenticating Please Wait...").fadeIn();
        getData.userLogin(info).then(function (rs) {
            if (rs.success) {
                getData.startSession(rs).then(function (respones) {
                    $('#processorState').removeClass('callout-info');
                    $('#processorState').addClass('callout-success');
                    $('#processorState').html("Success! Redirecting").delay(2000).fadeOut("slow", function () {
                        $('#btnLoging').attr('disabled', false);
                        window.location = "./";
                    });
                }).catch(function (rs) {
                    alert("Error Here" + rs);
                });
            } else {
                $('#btnLoging').attr('disabled', false);
                $('#processorState').removeClass('callout-info');
                $('#processorState').addClass('callout-danger');
                $('#processorState').html("Invalid Username or Password").delay(10000).fadeOut('slow');
            }
        }).catch(function (rs) {
            alert(rs.status);
        });
    };
    
});

app.controller('myCtrl', function ($scope, $http, getData) {
    
});

app.controller('manageSchDpt', function ($scope, getData, Save, Update, fetch, Delete) {
    $scope.urlopt = urlPath;
    
    $scope.createSchool = function (info) {
        var opt = $('#schBtnSave').html();

        getData.loader().start();
        if (opt === "Save") {
            Save.school(info).then(function (rs) {
                alert(rs);
                $scope.getSchools();
                getData.loader().stop();
            }).catch(function (rs) {
                alert(rs.status);
                getData.loader().stop();
            });
        }else{
            Update.school(info).then(function (rs) {
                alert(rs);
                $scope.getSchools();
                $('#schBtnSave').html("Save");
                $scope.model = {};
                getData.loader().stop();
            }).catch(function (rs) {
                alert(rs.status);
                getData.loader().stop();
            });
        }
        
    };
    
    $scope.deleteSchool = function (info) {

        Delete.school(info).then(function (rs) {
            getData.loader().start();
            alert(rs);
            $scope.getSchools();
            getData.loader().stop();
        }).catch(function (rs) {
            alert(rs.status);
            getData.loader().stop();
        });
        
    };
    
    $scope.editSchool = function (info) {
        $scope.model = {
            id : info.id,
            schoolName : info.schName,
            schoolAbbr : info.schAbbr
        };
        $('#schBtnSave').html('Update');
        $('#schoolModal').modal("show");
    };
    
    $scope.createDepartment = function (info) {
         var opt = $('#dptBtnSave').html();

        getData.loader().start();
        if (opt === "Save") {
            Save.department(info).then(function (rs) {
                alert(rs);
                $scope.getDepartment();
                getData.loader().stop();
            }).catch(function (rs) {
                alert(rs.status);
                getData.loader().stop();
            });
        }else{
            Update.department(info).then(function (rs) {
                alert(rs);
                $scope.getDepartment();
                $('#dptBtnSave').html("Save");
                $scope.model = {};
                getData.loader().stop();
            }).catch(function (rs) {
                alert(rs.status);
                getData.loader().stop();
            });
        }
    };
    
    $scope.newItemClick = function () {
        $scope.model = {};
         $('#schBtnSave').html('Save');
        $('#dptBtnSave').html('Save');
    };
    
    $scope.editDepartment = function (info) {
        $scope.model = {
            id : info.id,
            schoolId : "",
            departmentName : info.dptName,
            departmentAbbr : info.dptAbbr
        };
        $('#dptBtnSave').html('Update');
        $('#departmentModal').modal("show");
    };
    
    $scope.deleteDepartment = function (info) {
        
        Delete.department(info).then(function (rs) {
            getData.loader().start();
            alert(rs);
            $scope.getDepartment();
            getData.loader().stop();
        }).catch(function (rs) {
            alert(rs.status);
            getData.loader().stop();
        });
        
    };
    
    $scope.getSchools = function () {
        
        fetch.schools().then(function (rs) {
            $scope.schools = rs;
        }).catch(function(rs){
            alert(rs.status);
        });
        
    };
    $scope.getSchools();
    
    $scope.getDepartment = function () {
        
        fetch.department().then(function (rs) {
            $scope.dpt = rs;
        }).catch(function(rs){
            alert(rs.status);
        });
        
    };
    $scope.getDepartment();
    
});

app.controller('manageStudent', function ($scope, $localStorage, getData, Save, Update, fetch) {
    $scope.urlopt = urlPath;
    
    getData.sessionData().then(function (rs) {
        var json = JSON.parse(rs);
        $localStorage.sessionData = json;
        var departmentId = json.dptId;
        $scope.getStudents(departmentId);
    }).catch(function (rs) {
        alert("Error " + rs.status);
    });
    
    $scope.getStudents = function (departmentId) {
        
        fetch.students(departmentId).then(function (rs) {
            $scope.students = rs;
        }).catch(function(rs){
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    
    $scope.newItemClick = function () {
        $scope.model = {}; 
        $('#stdBtnSave').html('Save');
    };
    
    $scope.createStudent = function (info){
        info.departmentId = $localStorage.sessionData.dptId;
        var opt = $('#stdBtnSave').html();
        
        if (!validator.checkAll($('#studentForm'))) {
            return false;
        }
        
        if($scope.model.program_of_study === ""){
            alert("Please Select Program");
            return false;
        }
        
        getData.loader().start();
        if (opt === "Save") {
            Save.student(info).then(function (rs) {
                alert(rs);
                $scope.getStudents($localStorage.sessionData.dptId);
                getData.loader().stop();
            }).catch(function (rs) {
                alert(rs.status);
                getData.loader().stop();
            });
        }else {
            Update.student(info).then(function (rs) {
                alert(rs);
                $scope.getStudents($localStorage.sessionData.dptId);
                getData.loader().stop();
                $('#stdBtnSave').html('Save');
                $scope.model = {};
            }).catch(function (rs) {
                alert(rs.status);
                getData.loader().stop();
                $('#stdBtnSave').html('Save');
            });
        }
        
    };
    
    $scope.editStudent = function (info) {
        $scope.model = info;
        $scope.model.program_of_study = ""; 
        $('#stdBtnSave').html('Update');
        $('#studentModal').modal("show");
    };
    
});

app.controller('manageCourses', function ($scope, $localStorage, getData, Save, Update, fetch) {
    $scope.urlopt = urlPath;
    
    getData.sessionData().then(function (rs) {
        var json = JSON.parse(rs);
        var departmentId = json.dptId;
        $scope.getCourses(departmentId);
        $localStorage.sessionData = json;
    }).catch(function (rs) {
        alert("Error " + rs.status);
    });
    
    $scope.getCourses = function (departmentId) {
        
        fetch.courses(departmentId).then(function (rs) {
            $scope.courses = rs;
        }).catch(function (rs) {
            rs.message = "No Connection";
            alert(rs.message);
        });
    };
    
    $scope.clearData = function () {
        $('#cBtnSave').html('Save');
        $scope.model = {};
    };
    
    $scope.createCourse = function (info) {
        info.departmentId = $localStorage.sessionData.dptId;
        
        var opt = $('#cBtnSave').html();
        
        if (!validator.checkAll($('#courseForm'))) {
            return false;
        }
        
        getData.loader().start();
        if(opt === "Save"){
            Save.course(info).then(function (rs) {
                alert(rs);
                $scope.getCourses($localStorage.sessionData.dptId);
                getData.loader().stop();
            }).catch(function (rs) {
                getData.loader().stop();
                rs.message = "No Connection";
                alert(rs.message);
            });
        }else {
            Update.course(info).then(function (rs) {
                alert(rs);
                $scope.getCourses($localStorage.sessionData.dptId);
                getData.loader().stop();
                $('#cBtnSave').html('Save');
                $scope.model = {};
            }).catch(function (rs) {
                getData.loader().stop();
                rs.message = "No Connection";
                alert(rs.message);
            });
        }
    };
    
    $scope.editCourse = function (info) {
        $('#cBtnSave').html('Update');
        $scope.model = info;
        $scope.model.program = "";
        $scope.model.courseSemester = "";
        $scope.model.pre_requisite = "";
        $('#courseModal').modal("show");
    };
    
});

app.controller('gradeSchemeCtrl', function ($scope, $localStorage, getData, Save, Update, fetch) {
    
    $scope.urlopt = urlPath;
    
    getData.sessionData().then(function (rs) {
        var json = JSON.parse(rs);
        $localStorage.sessionData = json;
    }).catch(function (rs) {
        alert("Error " + rs.status);
    }); 
    
    $scope.newScheme = [];
    
    $scope.getGradeScheme = function () {
        
        fetch.gradeScheme().then(function (rs) {
            $scope.gradeScheme = rs;
        }).catch(function (rs) {
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    $scope.getGradeScheme();
    
    $scope.viewGradeScheme = function (info) {
        
        getData.loader().start();
        fetch.gradeSchemeItems(info).then(function (rs) {
            $scope.gradeSchemeItems = rs;
            $('#viewGradeSchemeModal').modal("show");
            getData.loader().stop();
        }).catch(function (rs) {
            getData.loader().stop();
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    
    $scope.setGradeSchemeEffect = function (info) {
        
        getData.loader().start();
        Update.gradeSchemeActive(info).then(function (rs) {
            alert(rs);
            $scope.getGradeScheme();
            getData.loader().stop();
        }).catch(function (rs) {
            getData.loader().stop();
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    
    $scope.addScheme = function(model){
        
        if(!validator.checkAll($('#gradeSchemeForm'))){
            return false;
        }
        
        getData.validateGradeScheme($scope.newScheme, model).then(function (rs) {
            $scope.newScheme.push(rs);
        }).catch(function (message) {
            $('#scoreAlert').html(message);
            $('#scoreAlert').fadeIn(1000).delay(3000).fadeOut(1000);
        });
        
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
    
    $scope.saveScheme = function () {
        
        if($scope.newScheme.length === 0){
            return false;
        }
        
        if(confirm("Create This Scheme")){
            
            getData.loader().start();
            Save.gradeScheme($scope.newScheme).then(function (rs) {
                alert(rs);
                $scope.getGradeScheme();
                $scope.newScheme = [];
                $('#schemeList').trigger('click');
                getData.loader().stop();
            }).catch(function (rs) {
                getData.loader().stop();
                rs.message = "No Connection";
                alert(rs.message);
            });
        }
        
    };
    
});

app.controller('classRemarkSchemeCtrl', function($scope, $localStorage, getData, Save, Update, fetch){
    
    $scope.urlopt = urlPath;
    
    getData.sessionData().then(function (rs) {
        var json = JSON.parse(rs);
        $localStorage.sessionData = json;
    }).catch(function (rs) {
        alert("Error " + rs.status);
    }); 
    
    $scope.newScheme = [];
    $scope.newRemarkSchem = [];
    
    /*
     * REMARK SCHEME
     */
    
    $scope.addSchemeRemark = function (model){
        
        if(!validator.checkAll($('#remarkSchemeForm'))){
            return false;
        }

        getData.validateResultRemarkScheme($scope.newRemarkSchem, model).then(function (obj) {
            $scope.newRemarkSchem.push(obj);
        }).catch(function (message) {
            $('#scoreAlert2').html(message);
            $('#scoreAlert2').fadeIn(1000).delay(3000).fadeOut(1000);
            return false;
        });
        
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
        
        if($scope.newRemarkSchem.length === 0){
            return false;
        }
        
        if(confirm("Create this Class Scheme")){
            getData.loader().start();
            Save.remarkScheme($scope.newRemarkSchem).then(function (rs) {
                alert(rs);
                $scope.model = {};
                $scope.newRemarkSchem = [];
                getData.loader().stop();
                $scope.getRemarkSchemeList();
                $('#schemeListRemarks').trigger('click');
            }).catch(function (rs) {
                getData.loader().stop();
                rs.message = "No Connection";
                alert(rs.message);
            });
        }
        
    };
    
    $scope.getRemarkSchemeList = function () {
         
        fetch.remarkScheme().then(function (rs) {
            $scope.remarkScheme = rs;
        }).catch(function (rs) {
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    $scope.getRemarkSchemeList();
    
    $scope.viewResultRemarkScheme = function (info) {
        
        getData.loader().start();
        fetch.remarkSchemeItems(info).then(function (rs) {
            $scope.viewRemarkScheme = rs;
            getData.loader().stop();
            $('#viewResultRemarkSchemeModal').modal("show");
        }).catch(function (rs) {
            getData.loader().stop();
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    
    $scope.setRemarkSchemeEffect = function(info){
        
        getData.loader().start();
        Update.remarkSchemeActive(info).then(function (rs) {
            alert(rs);
            $scope.getRemarkSchemeList();
            getData.loader().stop();
        }).catch(function (rs) {
            getData.loader().stop();
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    
    /*
     * CLASS REMARK SCHEME
     */
    
    $scope.addClassRemark = function(model){
        
        if(!validator.checkAll($('#gradeSchemeForm'))){
            return false;
        }
        
        getData.validateClassScheme($scope.newScheme, model).then(function (obj) {
            $scope.newScheme.push(obj);
        }).catch(function (message) {
            $('#scoreAlert').html(message);
            $('#scoreAlert').fadeIn(1000).delay(3000).fadeOut(1000);
            return false;
        });
        
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
    
    $scope.saveClassScheme = function(){
        
        if($scope.newScheme.length === 0){
            return false;
        }
        
        if(confirm("Create this Class Scheme")){
            getData.loader().start();
            Save.classScheme($scope.newScheme).then(function (rs) {
                alert(rs);
                $scope.model = {};
                $scope.newScheme = [];
                getData.loader().stop();
                $scope.getClassSchemeList();
                $('#classSchemeList').trigger('click');
            }).catch(function (rs) {
                getData.loader().stop();
                rs.message = "No Connection";
                alert(rs.message);
            });
        }
        
    };
    
    $scope.getClassSchemeList = function () {
        
        fetch.classScheme().then(function (rs) {
            $scope.classScheme = rs;
        }).catch(function (rs) {
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    $scope.getClassSchemeList();
    
    $scope.viewClassSchemeItems = function (info) {
        
        getData.loader().start();
        fetch.classSchemeItems(info).then(function (rs) {
            $scope.classSchemeItems = rs;
            getData.loader().stop();
            $('#viewClassSchemeModal').modal("show");
        }).catch(function (rs) {
            getData.loader().stop();
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    
    $scope.setClassSchemeEffect = function(info){
        
        getData.loader().start();
        Update.classSchemeActive(info).then(function (rs) {
            alert(rs);
            $scope.getClassSchemeList();
            getData.loader().stop();
        }).catch(function (rs) {
            getData.loader().stop();
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    
});

app.controller('courseRegistration', function ($scope, $http, $localStorage, getData, Save, fetch, Delete, download) {
    
    $scope.urlopt = urlPath;
    
    getData.sessionData().then(function (rs) {
        var json = JSON.parse(rs);
        $localStorage.sessionData = json;
        $scope.model = {departmentId : json.dptId};
    }).catch(function (rs) {
        alert("Error " + rs.status);
    });
    
    $scope.autocopilete = function(info){
        $('#tblAuto').removeClass('hide');
        
        fetch.autocopileteStudent(info).then(function(rs) {
            $scope.list = rs;
        }).catch(function (rs){
            alert(rs.status);
        });
        
    };
    
    $scope.setFilterData = function (info) {
        $scope.model.semester = "";
        $scope.courses = [];
        $scope.registedCourses = [];
        $scope.maxUnit = {};
        $scope.totalUnit = {};
        $http(requestLinks('POST', 'setFilterData', info)).then(function (rs) {
            $('#tblAuto').addClass('hide');
            $scope.model.regNo = info.regNo;
            $scope.semesters = rs.data;
        });

    };
    
    $scope.registerCourses = function(info){
        
        getData.loader().start();
        $http(requestLinks('POST', 'registerCourses', info)).then(function (rs) {
            $scope.verify = false;
            $scope.courses = rs.data.courses;
            $scope.registedCourses = rs.data.registered;
            $scope.maxUnit = {total : rs.data.maxUnit};
            $scope.unit = {total : rs.data.totalUnit};
            $scope.totalUnit = {total : rs.data.totalUnit};
            getData.loader().stop();
        });
        
    };

    $scope.coursesAdded = function (index) {
        var arr = [];
        var sum = $scope.totalUnit.total;
        for (var i = 0; i < $scope.courses.length; i++) {
            if ($scope.courses[i].Selected) {
                sum += $scope.courses[i].cu;
                arr.push($scope.courses[i]);
            }
        }
        if (sum > $scope.maxUnit.total) {
            $scope.courses[index].Selected = false;
        }
        $scope.unit = {total: sum};
    };

    $scope.addCourse = function (index) {
        if ($scope.courses[index].Selected) {
            $scope.coursesAdded(index);
        } else {
            $scope.coursesAdded(index);
        }
    };
    
    $scope.checkAll = function () {
        if($scope.verify){
            $scope.selectedAll = false;
        }else{
            $scope.selectedAll = true;
        }
        angular.forEach($scope.courses, function (x){
            x.Selected = $scope.selectedAll;
        });
    };
    
    $scope.saveCourseRegisted = function(info){
        
        getData.loader().start();
        getData.coursesToRegister($scope.courses).then(function (data) {
           
            Save.coursesRegistered({info: info, courses: data}).then(function (msg) {
                alert(msg);
                $scope.registerCourses(info);
            }).catch(function (rs) {
                alert(rs.status);
            });
            
        }).catch(function (msg) {
            getData.loader().stop();
            alert(msg);
        }); 
        
    };
    
    $scope.dropCourse = function(id, info){
        
        Delete.coursesRegistered({info: info, id: id}).then(function(msg){
            alert(msg);
            $scope.registerCourses(info);
        }).catch(function(rs){
            alert(rs.status);
        });
    };
    
    $scope.downloadCoursesRegistered = function (info){
        var arr = $scope.registedCourses;
        
        getData.loader().start();
        download.coursesRegistered(info, arr).then(function(rs){
            var blob = rs;
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = info.regNo + '.pdf';
            link.click();
            getData.loader().stop();
        }).catch(function(rs){
            getData.loader().stop();
            alert(rs.status);
        });
        
    };
});

app.controller('result', function ($scope, $http, getData, Save, fetch, Delete, download) {
    
    $scope.urlopt = urlPath;
    
    getData.sessionData().then(function (rs) {
        var json = JSON.parse(rs);
        $scope.model = {departmentId : json.dptId};
    }).catch(function (rs) {
        alert("Error " + rs.status);
    });
    
    fetch.department().then(function (rs) {
        $scope.departments = rs;
    }).catch(function (rs) {
        alert(rs.status);
    });
    
    $scope.autocopilete = function(info){
        $('#tblAuto').removeClass('hide');
        
        fetch.autocopileteStudent(info).then(function(rs) {
            $scope.list = rs;
        }).catch(function (rs){
            alert(rs.status);
        });
        
    };
    
    $scope.setFilterData = function (info) {
        
        $scope.model.studentId = info.id;
        $scope.model.regNo = info.regNo;
        $('#tblAuto').addClass('hide');

    };
    
    $scope.getLevels = function (info) {
        
        fetch.levels(info).then(function (rs) {
            $scope.levels = rs;
        }).catch(function (rs) {
            alert(rs.status);
        });

    };
    
    $scope.getSemesters = function(info){
        
        fetch.semesters(info).then(function (rs){
            $scope.semesters = rs;
        }).catch(function (rs){
            alert(rs.status);
        });
        
    };
    
    $scope.getCourses = function (info) {
        
        fetch.semesterCourses(info).then(function (rs) {
            $scope.coursesOfSemester = rs;
        }).catch(function(rs){
            alert(rs.status);
        });
        
    };
    
    $scope.saveResuleUpload = function (info){
        
        getData.loader().start();
        Save.resultUpload(info).then(function (rs) {
            alert(rs.success);
            getData.loader().stop();
            if(rs.count > 0){
                $scope.error = {total : rs.count};
                $scope.errorMessage = rs.message;
                $('#alertModal').modal("show");
            }
        }).catch(function(rs){
            alert(rs.status);
        });
        
    };
    
    $scope.saveResuleUploadSingle = function (info){
        
        getData.loader().start();
        Save.resultUploadSingle(info).then(function (rs) {
            alert(rs);
            getData.loader().stop();
        }).catch(function(rs){
            alert(rs.status);
        });
        
    };
    
    $scope.removeResuleUpload = function (info) {
        
        getData.loader().start();
        Delete.scoreSheet(info).then(function(rs) {
            alert(rs);
            getData.loader().stop();
        }).catch(function (rs){
            alert(rs.status);
            getData.loader().stop();
        });
        
    };
    
    $scope.compileResult = function (info) {
        
        getData.loader().start();
        getData.compileResult(info).then(function (rs) {
            alert(rs);
            getData.loader().stop();
        }).catch(function (rs) {
            alert(rs.status);
            getData.loader().stop();
        });
        
    };
    
    $scope.getResult = function (info) {
        getData.loader().start();
        fetch.Result(info).then(function (rs) {
            $scope.courseCodes = rs.courses;
            $scope.courseUnit = rs.courses;
            $scope.result = rs.result;
            $scope.rs = {status : rs.status};
            getData.loader().stop();
        }).catch(function (rs) {
            alert(rs.status);
        });

    };
    
    $scope.getResultPrint = function (info) {
        getData.loader().start();
        fetch.ResultPrint(info).then(function (rs) {
            $scope.courseCodes = rs.courses;
            $scope.courseUnit = rs.courses;
            $scope.result = rs.result;
            $scope.rs = {status : rs.status};
            getData.loader().stop();
        }).catch(function (rs) {
            alert(rs.status);
        });

    };
    
    $scope.downloadAcademicBoard = function (info) {
        var result = $scope.result;
        var courses = $scope.courseCodes;
         
        getData.loader().start();
        download.resultAcademicBoard(info, result, courses).then(function(rs){
            var blob = rs;
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'result_academic_board.pdf';
            link.click();
            getData.loader().stop();
        }).catch(function(rs){
            getData.loader().stop();
            alert(rs.status);
        });
        
    };
    
    $scope.downloadNoticeBoard = function (info) {
        var result = $scope.result;
        var courses = $scope.courseCodes;
        
        getData.loader().start();
        download.resultNoticeBoard(info, result, courses).then(function(rs){
            var blob = rs;
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'result_notice_board.pdf';
            link.click();
            getData.loader().stop();
        }).catch(function(rs){
            getData.loader().stop();
            alert(rs.status);
        });
        
    };
    
});

app.controller('transcriptCtrl', function ($scope, $http, $localStorage, getData, Save, fetch, Delete, download) {
    $scope.urlopt = urlPath;
    
    getData.sessionData().then(function (rs) {
        var json = JSON.parse(rs);
        $localStorage.sessionData = json;
        $scope.model = {departmentId : json.dptId};
    }).catch(function (rs) {
        alert("Error " + rs.status);
    });
    
    $scope.autocopilete = function(info){
        $('#tblAuto').removeClass('hide');
        
        fetch.autocopileteStudentTranscript(info).then(function(rs) {
            $scope.list = rs;
        }).catch(function (rs){
            alert(rs.status);
        });
        
    };
    
    $scope.setFilterData = function (info) {
        $scope.model = info;
        $('#tblAuto').addClass('hide');
    };
    
    $scope.generateTranscript = function (info) {
        
         
        getData.loader().start();
        download.transcript(info).then(function(rs){
            var blob = rs;
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = info.regNo + '_transcript.pdf';
            link.click();
            getData.loader().stop();
        }).catch(function(rs){
            getData.loader().stop();
            alert(rs.status);
        });
    };
});

app.controller('graduatedStudent', function ($scope, $http, $localStorage, getData, Save, fetch, Delete, download) {
    $scope.urlopt = urlPath;
    
    getData.sessionData().then(function (rs) {
        var json = JSON.parse(rs);
        $localStorage.sessionData = json;
        $scope.model = {departmentId : json.dptId};
    }).catch(function (rs) {
        alert("Error " + rs.status);
    });
    
    fetch.department().then(function (rs) {
        $scope.departments = rs;
    }).catch(function (rs) {
        alert(rs.status);
    });
    
    $scope.getSessions = function (info) {
        
        getData.graduatedSession(info).then(function (rs) {
            $scope.sessions = rs;
        }).catch(function (rs) {
            rs.message = "No Connection";
            alert(rs.message);
        });
        
    };
    
    $scope.newDataSession = function () {
        $scope.model.year = "";
    };
    
    $scope.getGraduatedStudentList = function (info) {
        
        getData.loader().start();
        fetch.graduatedStudent(info).then(function (rs) {
            $scope.gList = rs;
            getData.loader().stop();
        }).catch(function (rs) {
            rs.message = "No Connection";
            alert(rs.message);
            getData.loader().stop();
        });
        
    };
    
    $scope.downloadPdfFile = function (model) {
        var list = $scope.gList;
        
        getData.loader().start();
        download.graduatedStudentList(list, model).then(function (rs) {
            var blob = rs;
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = model.year + ' graduated student list.pdf';
            link.click();
            getData.loader().stop();
        }).catch(function (rs) {
            rs.message = "No Connection";
            alert(rs.message);
            getData.loader().stop();
        });
        
    };
    
});

app.controller('systemSettings', function ($scope, $http, $localStorage, getData, Save, Update, fetch, Delete, download) {
    $scope.urlopt = urlPath;
    
    getData.sessionData().then(function (rs) {
        var json = JSON.parse(rs);
        $localStorage.sessionData = json;
        $scope.sessionData = {logerId : json.logerId};
    }).catch(function (rs) {
        alert("Error " + rs.status);
    });
    
    fetch.department().then(function (rs) {
        $scope.departments = rs;
    }).catch(function (rs) {
        alert(rs.status);
    });
    
    $scope.setDepartmentId = function () {
        var dptId = $localStorage.sessionData.dptId;
        var logerType = $localStorage.sessionData.logerType;
        if (logerType === 'DIRECTOR ACADEMIC PLANNING') {
            $scope.model.departmentId = "";
        }else {
            $scope.model = {departmentId: dptId};
        }
    };
    
    $scope.getSettings = function () {
        fetch.currentSystemSettings().then(function (rs) {
            $scope.model = {session : rs.session, semester : rs.semester.toString()};
        }).catch(function (rs) {
            alert(rs.message);
        });
    };
    $scope.getSettings();
    
    $scope.getSystemUsers = function () {

        fetch.systemUser().then(function (rs) {
            $scope.usersList = rs;
        }).catch(function (rs) {
            alert(rs.message);
        });

    };
    $scope.getSystemUsers();
    
    $scope.createUsers = function (info) {
        info.logerId = $localStorage.sessionData.logerId;
        if (!validator.checkAll($('#newUserForm'))) {
            return false;
        }
        
        getData.loader().start();
        Save.systemUser(info).then(function (rs) {
            alert(rs);
            $scope.getSystemUsers();
            getData.loader().stop();
        }).catch(function (rs) {
            alert(rs.message);
            getData.loader().stop();
        });
        
    };
    
    $scope.removeUser = function (info) {
        
        getData.loader().start();
        Delete.systemUser(info).then(function (rs) {
            alert(rs);
            $scope.getSystemUsers();
            getData.loader().stop();
        }).catch(function (rs) {
            alert(rs.message);
            getData.loader().stop();
        });
        
    };
    
    $scope.getAvailablePermisions = function (info) {
        info.logerId = $localStorage.sessionData.logerId;
        info.logerType = $localStorage.sessionData.logerType;
        
        fetch.availablePermissions(info).then(function (rs) {
            $scope.availablePermisions = rs;
            $scope.child = {id : info.id};
            $('#permissionModal').modal("show");
        }).catch(function (rs) {
            alert(rs.message);
        });
        
    };
    
    $scope.getChildPermissions = function (info) {
        info.logerId = $localStorage.sessionData.logerId;

        fetch.childPermissions(info).then(function (rs) {
            $scope.childPermissions = rs;
            $scope.child = {id : info.id};
            $('#permissionRemoveModal').modal("show");
        }).catch(function (rs) {
            alert(rs.message);
        });
        
    };
    
    $scope.saveNewPermission = function () {
        var newPermission = $scope.availablePermisions;
        var id = $scope.child.id;

        getData.loader().start();
        getData.newChildPermissions(newPermission, id).then(function (rs) {
            Save.childPermission(rs).then(function (success) {
                $scope.availablePermisions = [];
                $scope.child = {};
                $('#permissionModal').modal("hide");
                getData.loader().stop();
                alert(success);
            }).catch(function (rs) {
                getData.loader().stop();
                alert(rs.message);
            });
        }).catch(function (rs) {
            getData.loader().stop();
            alert(rs);
        });

    };
    
    $scope.removePermission = function () {
        var childPermission = $scope.childPermissions;
        var id = $scope.child.id;
        
        getData.loader().start();
        getData.childPermissionsToRemove(childPermission, id).then(function (rs) {
            Delete.childPermission(rs).then(function (success) {
                $scope.childPermissions = [];
                $scope.child = {};
                $('#permissionRemoveModal').modal("hide");
                getData.loader().stop();
                alert(success);
            }).catch(function (rs) {
                getData.loader().stop();
                alert(rs.message);
            });
        }).catch(function (rs) {
            getData.loader().stop();
            alert(rs);
        });
        
    };
    
    $scope.setCurrentSettings = function (info) {

        getData.loader().start();
        Update.systemSettings(info).then(function (rs) {
            alert(rs);
            $scope.getSettings();
            getData.loader().stop();
        }).catch(function (rs) {
            getData.loader().stop();
            alert(rs.message);
        });

    };
    
});