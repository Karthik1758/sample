let app = angular.module('ifmis', ['ui.router'])

app.config(['$stateProvider', function ($stateProvider) {
    $stateProvider
        .state('addAgency', {
            url: '/addAgency',
            templateUrl: 'addAgency.html'
        });
    $stateProvider
        .state('billEntry', {
            url: '/billEntry',
            templateUrl: 'billEntry.html'
        });
}
]);
app.controller('AddAgencyController', function ($scope, $http) {
    $scope.editable = "false",
        $scope.ifscCodeInput = ""
    $scope.details = [];
    $scope.searchIfscCode = function () {
        console.log($scope.ifscCodeInput);
        $http({
            method: 'POST',
            url: 'http://127.0.0.1:8000/api/getIfscCodeDetails',
            data: {
                ifsc_code: $scope.ifscCodeInput
            },
        }).then(
            function (response) {
                if (response.data.status == true) {
                    $scope.details = response.data.data;
                } else {
                    alert(response.data.message);
                }
            }).catch(
                function (response) {
                    console.log($scope.ifscCodeInput);
                }
            )
    }
})
