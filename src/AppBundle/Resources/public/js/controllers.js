//var app = angular.module("mobilePost", ['ngRoute', 'ngResource']);

app.controller('ParcelordersCtrl', ['$scope', '$resource', function ($scope, $resource) {
    var r = $resource('/api/v1/parcelorders.json', {}, {
    });

    $scope.data = r.query();
}]);

app.controller('LoginCtrl', ['$scope', '$location', 'User', function ($scope, $location, User) {
    $scope.loginFailed = false;
    $scope.login = function () {
        User.login($scope.username, $scope.password).then(function (user) {
            $location.path('/');
        }, function () {
            $scope.loginFailed = true;
        });
    };
}]);

app.controller('HomeCtrl', ['$scope', '$location', 'User', function ($scope, $location, User) {
    User.getCurrentUser().then(function (user) {
        if (user.roles.indexOf('ROLE_ADMIN') != -1) {
            // Homepage for admin
            $location.path('/assigntasks');
        } else {
            // Homepage for postman
            $location.path('/parcelorders');
        }
    }, function () {
        // Homepage for not logged in user (login form)
        $location.path('/login');
    });
}]);

app.controller('AssignTasksCtrl', ['$scope', '$q', 'ParcelOrder', 'Postman', 'Task', function ($scope, $q, ParcelOrder, Postman, Task) {
    function reloadOrders() {
        $scope.orders = ParcelOrder.queryUnassigned();
    }
    reloadOrders();
    $scope.postmans = Postman.query();
    $scope.saveAssignments = function () {
        promises = [];
        $scope.orders.forEach(function (order) {
            if (order.assignTo) {
                promises.push(Task.post({'parcelOrder': order.id, 'postman': +order.assignTo}).$promise);
            }
        });
        if (!promises.length) {
            alert('Nie wybrano żadnego zlecenia do przydzielenia');
        } else {
            $q.all(promises).then(function () {
                reloadOrders();
                alert('Przydzielenia zostały zapisane');
            });
        }
    };
}]);

app.controller('UpdateParcelFormCtrl', ['$scope', '$routeParams', '$window', 'ParcelOrder', function($scope, $routeParams, $window, ParcelOrder) {
	$scope.parcelOrder = ParcelOrder.get({id: $routeParams.parcelId});
	$scope.submit = function() {
		ParcelOrder.update({id: $routeParams.parcelId}, $scope.parcelOrder,
		function() {
			$window.location.href = '#/parcelorders';
		});
	}
}]);

/*
app.controller('CreateParcelFormCtrl', ['$scope', '$window', 'ParcelOrder', function($scope, $window, ParcelOrder) {
	$scope.submit = function() {
		ParcelOrder.save($scope.parcelOrder, function() {
			$window.location.href = '#';
		});
	};
}]);
*/
app.controller('AddPostmanCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.postman_email = null;
    $scope.postman_username = null;
    $scope.postman_name = null;
    $scope.postman_plainPassword_first = null;
    $scope.postman_plainPassword_second = null;
    $scope.postman_phone = null;
    $scope.postman_city = null;
    $scope.Submit = function()
    {
        var data = "postman_email=" + $scope.postman_email;
        data += "&postman_username=" + $scope.postman_username;
        data += "&postman_name=" + $scope.postman_name;
        data += "&postman_plainPassword_first=" + $scope.postman_plainPassword_first;
        data += "&postman_plainPassword_second=" + $scope.postman_plainPassword_second;
        data += "&postman_phone=" + $scope.postman_phone;
        data += "&postman_city=" + $scope.postman_city;
        
        var config = { headers : { 'Content-Type': 'application/x-www-form-urlencoded;' } };
        $http.post('addpostmen', data, config).then(
                function(response)
                {
                    console.log("Success: " + response);
                }, 
                function(response)
                {
                    console.log("Error: " + response);
                });
    }
}]);
