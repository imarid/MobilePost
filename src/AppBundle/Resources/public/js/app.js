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
	.when('/edit/:parcelId', {
	templateUrl: '/bundles/app/partials/editAllForm.html',
	controller: 'UpdateParcelFormCtrl'
	})
        .otherwise({
            'template': '',
            'controller': 'HomeCtrl'
        });
}]);

app.directive('ngRedirectTo',['$window', function($window) {
	return {
		restrict: 'A',
		link: function(scope, element, attributes) {
			element.on('click', function() {
				$window.location.href = attributes.ngRedirectTo;
			});
		}
	}
}]);
