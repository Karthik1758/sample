let app = angular.module('employee', ['ui.router'])


app.controller('loginController', function ($scope, $http) {
  $scope.emailInput = '';
  $scope.passwordInput = '';
  $scope.login = function () {
    $http({
      url: 'http://127.0.0.1:8000/api/login',
      method: 'POST',
      data: {
        email: $scope.emailInput,
        password: $scope.passwordInput
      },
    })
      .then(
        function (responseData) {
          // responseData=JSON.parse(responseData);
         
          if (responseData.data.status) {
          
          alert(responseData.data.message);
          localStorage.setItem('usertoken',responseData.data.data)
            location.assign("./home.html");
          } else {
            alert(responseData.data.message);
          }
        },
        function (responseData) {
          // responseData=JSON.parse(responseData);
          alert(responseData.data.errors[Object.keys(responseData.data.errors)[0]][0]);
          console.log(responseData);

        })
  }
})




app.config(['$stateProvider', function ($stateProvider) {
  $stateProvider
    .state('employee', {
      url: '/employee',
      templateUrl: 'employee.html'
    })
    .state('employee.addEmployee', {
      url: '/addEmployee',
      templateUrl: 'addEmployee.html'
    })
    .state('employee.employeeDetails', {
      url: '/employeeDetails',
      templateUrl: 'employeeDetails.html'
    })
    .state({
      name: 'employee.employeeDetails.viewEmployee',
      url: '/viewEmployee/:id',
      templateUrl: 'viewEmployee.html',
    })
    .state({
      name: 'employee.employeeDetails.viewEmployee.editEmployee',
      url: '/editEmployee/:id',
      templateUrl: 'editEmployee.html'
    })
}])

//main page controller
app.controller('homeController',function($scope,$http){
  $http.post('',{usertoken:localStorage.getItem('usertoken')}).then(
    function(response){

    },function(error){
      
    }
  )
})


app.controller('AddEmployee', function ($scope, $http) {
  $scope.fullNameInput = "";
  $scope.emailInput = "";
  $scope.phoneNumberInput = "";
  $scope.dobInput = "";
  $scope.genderInput = "";
  $scope.passwordInput = "";
  $scope.confirmPasswordInput = "";
  $scope.addEmployee = function () {
    console.log($scope.genderInput);
    $http({
      url: "http://127.0.0.1:8000/api/AddEmployee",
      method: "POST",
      data: {
        full_name: $scope.fullNameInput,
        email: $scope.emailInput,
        phone_number: $scope.phoneNumberInput,
        dob: $scope.dobInput,
        gender: $scope.genderInput,
        password: $scope.passwordInput,
        password_confirmation: $scope.confirmPasswordInput
      }
    })
      .then(
        function (responseData) {
          // responseData=JSON.parse(responseData);
          if (responseData.data.status) {
            alert(responseData.data.message);
            location.assign("home.html#!/employee/employeeDetails");
          } else {
            alert(responseData.data.message);
          }
        },
        function (responseData) {
          // responseData=JSON.parse(responseData);
          alert(responseData.data.errors[Object.keys(responseData.data.errors)[0]][0]);
          console.log(responseData);
        })
  }
});



app.controller('employeeDetails', function ($scope, $http) {
  $scope.employees = [];
  $http({
    url: "http://127.0.0.1:8000/api/getEmployees",
    method: "POST"
  }).then(
    function (responseData) {
      if (responseData.data.status) {
        $scope.employees = responseData.data.data.data;
        $scope.pagination = responseData.data.data.links;
        $scope.pagination[0].label = 'Prev';
        $scope.pagination[$scope.pagination.length - 1].label = 'Next';
      } else {
        console(responseData.data.message);
      }
    },
    function (responseData) {

      alert(responseData.data.errors[Object.keys(responseData.data.errors)[0]][0]);
      console.log(responseData);
    })

  $scope.getEmployees = function (url) {
    $http({
      url,
      method: "POST"
    }).then(
      function (responseData) {
        if (responseData.data.status) {
          $scope.employees = responseData.data.data.data;
          $scope.pagination = responseData.data.data.links;
          $scope.pagination[0].label = 'Prev';
          $scope.pagination[$scope.pagination.length - 1].label = 'Next';
        } else {
          console(responseData.data.message);
        }
      },
      function (responseData) {
        alert(responseData.data.errors[Object.keys(responseData.data.errors)[0]][0]);
        console.log(responseData);
      })
  }
});



app.controller("viewEmployeeController", function ($scope, $http, $stateParams) {
  $scope.details = {};
  $scope.editEmployee = function () {
    console.log($scope.genderInput);
    $http({
      url: "http://127.0.0.1:8000/api/editEmployee/" + $stateParams.id,
      method: "POST",
      data: {
        full_name: $scope.details.full_name,
        email: $scope.details.email,
        phone_number: $scope.details.phone_number,
        dob: $scope.details.dob,
        gender: $scope.details.gender,
      }
    })
      .then(
        function (responseData) {
          // responseData=JSON.parse(responseData);
          if (responseData.data.status) {
            alert(responseData.data.message);
            location.assign("home.html#!/employee/employeeDetails/viewEmployee/" + $stateParams.id);
          } else {
            alert(responseData.data.message);
          }
        },
        function (responseData) {
          // responseData=JSON.parse(responseData);
          alert(responseData.data.errors[Object.keys(responseData.data.errors)[0]][0]);
          console.log(responseData);
        })
  }
  $http({
    method: "POST",
    url: "http://127.0.0.1:8000/api/getEmployeeDetails/",
    data: { id: $stateParams.id },
  }).then(function success(response) {
    $scope.details = response.data;
    $scope.leaves = response.data.leave;
    $scope.details.dob = new Date($scope.details.dob);
    console.log(response.data.data);
  })
});


app.controller('ApplyLeaveController', function ($scope, $http,$stateParams) {
  $scope.fromDateInput = '';
  $scope.toDateInput = '';
  $scope.selectType = '';
  $scope.reasonInput = '';
  $scope.applyLeave = function () {
    $http({
      url: 'http://127.0.0.1:8000/api/AddLeave/',
      method: 'POST',
      data: {
        employee_id:$stateParams.id,
        from:$scope.fromDateInput,
        to:$scope.toDateInput,
        type:$scope.selectType,
        reason:$scope.reasonInput
      },
    })
      .then(
        function (responseData) {
          // responseData=JSON.parse(responseData);
          if (responseData.data.status) {
            alert(responseData.data.message);
            location.reload();
          } else {
            alert(responseData.data.message);
          }
        },
        function (responseData) {
          // responseData=JSON.parse(responseData);
          alert(responseData.data.errors[Object.keys(responseData.data.errors)[0]][0]);
          console.log(responseData);

        })
  }
})



