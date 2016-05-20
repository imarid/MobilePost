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
