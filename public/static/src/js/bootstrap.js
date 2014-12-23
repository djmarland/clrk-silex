(function() {
    'use strict';

// Declare app level module which depends on views, and components
    var app = angular.module('universe', [
        'ngRoute'
    ]).
        config(['$routeProvider', function ($routeProvider) {
/*
            $routeProvider.when('/', {
                templateUrl: 'partial/home/home.html',
                controller: 'HomeController'
            });

            $routeProvider.when('/characters', {
                templateUrl: 'partial/characters/characters.html',
                controller: 'CharactersController'
            });

            $routeProvider.when('/characters/edit', {
                templateUrl: 'partial/characters/characters-edit.html',
                controller: 'CharactersController'
            });

            $routeProvider.otherwise({redirectTo: '/'});
 */
        }]);

})();