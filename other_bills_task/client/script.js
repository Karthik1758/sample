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
		$scope.clear = function () {
			$scope.ifscCodeInput = "",
				$scope.error = '',
				$scope.agencyError = '',
				$scope.details = [];
			$scope.agencyDetails = [];
			$scope.found = false;
			$scope.ifsc = false;
		}
	$scope.searchIfscCode = function () {
		$scope.ifsc = false;
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
					$scope.error = '';
					$scope.ifsc = true;
				} else {
					$scope.error = response.data.message;
					$scope.details = {};
					$scope.ifsc = false;
				}
			}).catch(
				function (response) {
					// console.log($scope.ifscCodeInput);
					$scope.error = response.data.errors[(Object.keys(response.data.errors))[0]][0];
					$scope.details = ''
				}
			)
	}
	$scope.addAgency = function () {
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/addAgency',
			data: {
				name: $scope.agencyNameInput,
				account_number: $scope.bankAccountNumberInput,
				account_number_confirmation: $scope.confirmBankAccountNumberInput,
				ifsc_code: $scope.ifscCodeInput
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					// alertMessage(response.data.message);
					swal("Success",response.data.message, "success");
				} else {
					// alert(response.data.message);
					swal("Error",response.data.message, "error");

				}
			}).catch(
				function (response) {
					// console.log($scope.ifscCodeInput);
					// alert(response.data.message);
					swal("Error",response.data.message, "error");

				}
			)
	}
	$scope.found = false;
	$scope.ifsc = false;
	$scope.searchAgency = function () {
		$scope.found = false;
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getAgency',
			data: {
				account_number: $scope.accountNumber
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.agencyDetails = response.data.data;
					$scope.agencyError = '';
					$scope.found = true;
				} else {
					$scope.agencyError = response.data.message;
					$scope.agencyDetails = {};
				}
			}).catch(
				function (response) {
					// console.log($scope.ifscCodeInput);
					$scope.agencyError = response.data.errors[(Object.keys(response.data.errors))[0]][0];
					$scope.agencyDetails = ''
				}
			)
		$scope.editAgency = function () {
			$http({
				method: 'POST',
				url: 'http://127.0.0.1:8000/api/editAgency/' + $scope.agencyDetails.id,
				data: {
					name: $scope.agencyName,
					ifsc_code: $scope.ifscCodeInput
				},
			}).then(
				function (response) {
					if (response.data.status == true) {
						alert(response.data.message);
					} else {
						alert(response.data.message);
					}
				}).catch(
					function (response) {
						// console.log($scope.ifscCodeInput);
						alert(response.data.message);
					}
				)
		}

	}
});

app.controller('AddBillController', function ($scope, $http) {
	$scope.formDetails = [];
	$scope.found = false;
	$http({
		method: 'POST',
		url: 'http://127.0.0.1:8000/api/getFormNumber',
	}).then(
		function (response) {
			if (response.data.status == true) {
				$scope.formDetails = response.data.data;
			} else {
				console.log(response);
				alertMessage(response.data.message);
			}
		}
	).catch(
		function (response) {
			alert(response.data.message);
		}
	)
	$scope.getFormType = function () {
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getFormType',
			data: {
				form_number_id: $scope.formNumberSelect
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.formTypes = response.data.data;
				} else {
					console.log(response);
				}
			}
		).catch(
			function (response) {
				console.log(response.data.message);
			}
		)
	}
	$scope.searchAgency = function () {
		$scope.clearAgencyDetails();
		$scope.found = false;
		$http({
			method: 'POST',
			url: 'http://127.0.0.1:8000/api/getAgency',
			data: {
				account_number: $scope.accountNumber
			},
		}).then(
			function (response) {
				if (response.data.status == true) {
					$scope.agencyDetails = response.data.data;
					$scope.IfscDetails=response.data.ifsc;
					$scope.agencyError = '';
					$scope.found = true;
					$scope.billList==true;
				} else {
					$scope.agencyError = response.data.message;
					$scope.agencyDetails = {};
				}
			}).catch(
				function (response) {
					// console.log($scope.ifscCodeInput);
					$scope.agencyError = response.data.errors[(Object.keys(response.data.errors))[0]][0];
					$scope.agencyDetails = ''
				}
			)
	}
	$scope.agencyBill=[];
	$scope.ptDeduction=0;
	$scope.tdsIt=0;
	$scope.gst=0;
	$scope.gis=0;
	$scope.telanganaHarithaNidhi=0;
	$scope.netAmount='';
	$scope.billList=false;
	$scope.addBill=function(){
		$scope.billList=true;
		$scope.found=false;
		$scope.agencyBill.push({
			'agency_name' : $scope.agencyDetails.name,
			'agency_account_number':$scope.agencyDetails.account_number,
			'agency_bank_name':$scope.agencyDetails.bank_ifsc.bank_name,
			'agency_branch':$scope.agencyDetails.bank_ifsc.branch,
			'agency_ifsc_code':$scope.agencyDetails.bank_ifsc.ifsc_code,
			'agency_gross':$scope.gross,
			'agency_ptDeduction':$scope.ptDeduction,
			'agency_tdsIt':$scope.tdsIt,
			'agency_gst':$scope.gst,
			'agency_gis':$scope.gis,
			'agency_telangana_haritha_nidhi':$scope.telanganaHarithaNidhi,
			'agency_net_amount':$scope.netAmount
		});
	}
	$scope.clearAgencyDetails=function(){
		$scope.gross='';
		$scope.ptDeduction=0;
		$scope.tdsIt=0;
		$scope.gst=0;
		$scope.gis=0;
		$scope.telanganaHarithaNidhi=0;
		$scope.netAmount=0;
		$scope.agencyDetails={};
	}
});


function alertMessage(message){
	alert(message);
}

