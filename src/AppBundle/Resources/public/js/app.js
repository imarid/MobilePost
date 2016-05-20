var app = angular.module("myApp", ['ngRoute', 'ngResource']);

app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
        .when('/parcelorders', {
            'templateUrl': '/bundles/app/partials/parcelorders.html',
            'controller': 'ParcelordersCtrl'
        })
        .when('/login', {
            'templateUrl': '/bundles/app/partials/login.html',
            'controller': 'LoginCtrl'
        })
        .when('/assigntasks', {
            'templateUrl': '/bundles/app/partials/assigntasks.html',
            'controller': 'AssignTasksCtrl'
        })
        .otherwise({
            'template': '',
            'controller': 'HomeCtrl'
        });
}]);
