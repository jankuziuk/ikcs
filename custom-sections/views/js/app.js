var app = angular.module('ikcs', ['ui.sortable', 'ngCookies', 'angularUtils.directives.dirPagination']);

app.controller("ikcsGetSections", ['$scope', '$http', '$location', '$cookies', function ($scope, $http, $location, $cookies) {
    $scope.ikcsSections = [];
    $scope.ikcsGetListComplete = false;
    $scope.itemsPerPage = 10;
    $scope.currentPage = 1;

    if (typeof $cookies.get('itemsPerPage') != "undefined"){
        $scope.itemsPerPage = parseInt($cookies.get('itemsPerPage'));
    }
    if (typeof $cookies.get('sortKey') != "undefined"){
        $scope.sortKey = $cookies.get('sortKey');
    }
    if (typeof $cookies.get('reverse') != "undefined"){
        $scope.reverse = $cookies.get('reverse') == 'true' ? true : false;
    }

    $scope.getAllSections = function () {
        $http({
            method: 'GET',
            url: ajaxurl,
            params: {
                action: 'ikcs_get_all_sections'
            }
        }).then(function successCallback(response) {
            $scope.ikcsSections = response.data.sections;
            $scope.ikcsGetListComplete = true;
            if (typeof $location.search()['page'] != "undefined"){
                var page = parseInt($location.search()['page']);
                if(page > Math.ceil($scope.ikcsSections.length/$scope.itemsPerPage)){
                    $scope.currentPage = Math.ceil($scope.ikcsSections.length/$scope.itemsPerPage);
                    $location.search('page', Math.ceil($scope.ikcsSections.length/$scope.itemsPerPage));
                } else {
                    $scope.currentPage = page;
                }
            }
        }, function errorCallback(response) {
            console.warn(response);
        });
    };

    $scope.removeSectionById = function (id) {
        for (var i = 0; i<$scope.ikcsSections.length; i++){
            if($scope.ikcsSections[i].id == id){
                $scope.ikcsSections[i].removing = true;
            }
        }

        $http({
            method: 'POST',
            url: ajaxurl,
            params: {
                action: 'ikcs_remove_section_by_id'
            },
            data:{
                id: id
            }
        }).then(function successCallback(response) {
            if(response.data.status == "OK"){
                for (var i = 0; i<$scope.ikcsSections.length; i++){
                    if($scope.ikcsSections[i].id == id){
                        $scope.ikcsSections.splice(i, 1);
                    }
                }
            }
        }, function errorCallback(response) {
            console.warn(response);
        });
    };

    $scope.pageChanged = function (page, itemsPerPage) {
        console.log(page, itemsPerPage);
        $location.search('page', page);
        $cookies.put('itemsPerPage', itemsPerPage);
    };

    $scope.sort = function(keyname){
        $scope.sortKey = keyname;
        $scope.reverse = !$scope.reverse;
        $cookies.put('sortKey', keyname);
        $cookies.put('reverse', (($scope.reverse) ? true : false));
    };
    $scope.getAllSections();
}]);

app.controller("ikcsAddEditSection", ['$scope', '$http', function ($scope, $http) {
    var sectionID = (typeof jQuery.getUrlVar('id') != "undefined") ? parseInt(jQuery.getUrlVar('id')) : false,
        section={
            id: '',
            label: '',
            default_value: '',
            repeater_fields: [],
            options: {
                open: 1,
                required: 'off',
                min_length: 0,
                max_length: 100
            }
        };
    $scope.pageLoadComplete = false;
    $scope.ikcsAdd = {
        id: sectionID,
        name: '',
        fields: [],
        settings: {
            show_select_bg: 1,
            show_select_margin: 1,
            show_custom_css: 1
        }
    };
    $scope.sortableOptions = {
        cursor: "move",
        axis: 'y'
    };

    $scope.addNewSection = function () {
        $scope.ikcsAdd.fields.push(section);
    };

    $scope.addNewSubSection = function (index) {
        $scope.ikcsAdd.fields[index].repeater_fields.push(section);
    };

    $scope.removeItem = function (index) {
        $scope.ikcsAdd.fields.splice(index, 1);
    };

    $scope.triggerShowItem = function (index, isOpen) {
        if(isOpen == 1){
            $scope.ikcsAdd.fields[index].options.open = 0;
        }
        else {
            $scope.ikcsAdd.fields[index].options.open = 1;
        }
    };

    $scope.getInfoByID = function (id) {
        $http({
            method: 'POST',
            url: ajaxurl,
            params: {
                action: 'ikcs_get_section_by_id'
            },
            data:{
                id: id
            }
        }).then(function successCallback(response) {
            $scope.ikcsAdd = response.data.section;
            $scope.pageLoadComplete = true;
        }, function errorCallback(response) {
            console.warn(response);
        });
    };

    if(sectionID){
        $scope.getInfoByID(sectionID);
    }
    else {
        $scope.pageLoadComplete = true;
    }

    $scope.submit = function () {
        $http({
            method: 'POST',
            url: ajaxurl,
            params: {
                action: 'ikcs_update_section'
            },
            data: {
                id: sectionID,
                name: $scope.ikcsAdd.name,
                settings: $scope.ikcsAdd.settings,
                fields: $scope.ikcsAdd.fields
            }
        }).then(function successCallback(response) {
            if(response.data.status == "OK" && response.data.type == 'insert'){
                window.location.search = "?page=ikcs-edit&id=" + response.data.id;
            }
        }, function errorCallback(response) {
            console.warn(response);
        });
    };
}]);

jQuery.extend({
    getUrlVars: function(){
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    },
    getUrlVar: function(name){
        return jQuery.getUrlVars()[name];
    }
});