var app = angular.module('ikcs', ['ui.sortable', 'ngCookies', 'angularUtils.directives.dirPagination', 'toastr']);

app.config(function(toastrConfig) {
    angular.extend(toastrConfig, {
        autoDismiss: false,
        maxOpened: 0,
        closeButton: true,
        newestOnTop: true,
        progressBar: true,
        positionClass: 'toast-bottom-right',
        preventDuplicates: false,
        preventOpenDuplicates: false,
        target: 'body',
        timeOut: 5000
    });
});

app.controller("ikcsGetSections", ['$scope', '$http', '$location', '$cookies', 'toastr', function ($scope, $http, $location, $cookies, toastr) {
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
            toastr.success('Sekcja została usunięta', 'Success!');
        }, function errorCallback(response) {
            console.warn(response);
            toastr.error('Wystąpił nieoczekiwany błąd', 'Błąd!');
        });
    };

    $scope.pageChanged = function (page, itemsPerPage) {
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

app.controller("ikcsAddEditSection", ['$scope', '$http', 'toastr', function ($scope, $http, toastr) {
    var sectionID = (typeof jQuery.getUrlVar('id') != "undefined") ? parseInt(jQuery.getUrlVar('id')) : false;
    $scope.pageLoadComplete = false;
    $scope.ikcsAddFormSaving = false;
    $scope.ikcsAdd = {
        id: sectionID,
        section_id: '',
        name: '',
        fields: [],
        settings: {
            show_select_bg: 1,
            show_select_margin: 1,
            show_custom_css: 1,
            bg_img_id: false,
            bg_img_url: '',
            margin: {
                top: 10,
                left: 0,
                right: 0,
                bottom: 10
            },
            padding: {
                top: 10,
                left: 0,
                right: 0,
                bottom: 10
            }
        }
    };

    $scope.sortableOptions = {
        cursor: "move",
        axis: 'y'
    };

    $scope.addNewSection = function () {
        var section={
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
        $scope.ikcsAdd.fields.push(section);
        console.log($scope.ikcsAdd);
    };

    $scope.addNewSubSection = function (index) {
        var section={
            id: '',
            label: '',
            value: '',
            repeater_fields: [],
            options: {
                open: 1,
                required: 'off',
                min_length: 0,
                max_length: 100
            }
        };
        $scope.ikcsAdd.fields[index].repeater_fields.push(section);
        console.log($scope.ikcsAdd);
    };

    $scope.removeItem = function (index) {
        $scope.ikcsAdd.fields.splice(index, 1);
    };

    $scope.removeSubItem = function (parentIndex, index) {
        $scope.ikcsAdd.fields[parentIndex].repeater_fields.splice(index, 1);
    };

    $scope.triggerShowItem = function (index, isOpen) {
        if(isOpen == 1){
            $scope.ikcsAdd.fields[index].options.open = 0;
        }
        else {
            $scope.ikcsAdd.fields[index].options.open = 1;
        }
    };

    $scope.triggerShowSubItem = function (parentIndex, index, isOpen) {
        if(isOpen == 1){
            $scope.ikcsAdd.fields[parentIndex].repeater_fields[index].options.open = 0;
        }
        else {
            $scope.ikcsAdd.fields[parentIndex].repeater_fields[index].options.open = 1;
        }
    };

    $scope.triggerShowSubItem = function (index, subindex, isOpen) {
        if(isOpen == 1){
            $scope.ikcsAdd.fields[index].repeater_fields[subindex].options.open = 0;
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
        $scope.ikcsAddFormSaving = true;
        $http({
            method: 'POST',
            url: ajaxurl,
            params: {
                action: 'ikcs_update_section'
            },
            data: {
                id: sectionID,
                section_id: $scope.ikcsAdd.section_id,
                name: $scope.ikcsAdd.name,
                settings: $scope.ikcsAdd.settings,
                fields: $scope.ikcsAdd.fields
            }
        }).then(function successCallback(response) {
            if(response.data.status == "OK" && response.data.type == 'insert'){
                window.location.search = "?page=ikcs-edit&id=" + response.data.id;
                toastr.success('Sekcja została dodana', 'Success!');
            }
            else if (response.data.status == "OK" && response.data.type == 'update'){
                toastr.success('Sekcja została zaaktualizowana', 'Success!');
            }
            else {
                toastr.error('Wystąpił nieoczekiwany błąd', 'Błąd!');
            }
            $scope.ikcsAddFormSaving = false;
        }, function errorCallback(response) {
            console.warn(response);
            $scope.ikcsAddFormSaving = false;
        });
    };
}]);

app.controller("ikcsPageRendering", ['$scope', '$http', function ($scope, $http) {
    $scope.ikcsSections = [];
    $scope.existingSections = [];
    $scope.ikcsGetListComplete = false;
    $scope.addNewSectionBefore = false;
    $scope.sortableOptions = {
        cursor: "move",
        axis: 'y'
    };

    $http({
        method: 'GET',
        url: ajaxurl,
        params: {
            action: 'ikcs_get_fa_json'
        }
    }).then(function successCallback(response) {
        $scope.fa_list = response.data.fa;
        $scope.fa_preview_index = 0;
        $scope.fa_preview_key = $scope.fa_list[$scope.fa_preview_index].fa_key;
        $scope.fa_preview_val = $scope.fa_list[$scope.fa_preview_index].fa_value;
    }, function errorCallback(response) {
        console.warn(response);
    });

    
    $scope.getExistingSections = function () {
        $http({
            method: 'GET',
            url: ajaxurl,
            params: {
                action: 'ikcs_get_all_sections'
            }
        }).then(function successCallback(response) {
            $scope.ikcsSections = response.data.sections;
            $scope.ikcsGetListComplete = true;
            console.log(response);
        }, function errorCallback(response) {
            console.warn(response);
        });
    };

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
            console.log(response);
        }, function errorCallback(response) {
            console.warn(response);
        });
    };

    $scope.addNewSection = function (id) {
        $scope.addNewSectionBefore = true;
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
            $scope.existingSections.push(angular.copy(response.data.section));
            $scope.addNewSectionBefore = false;
        }, function errorCallback(response) {
            console.warn(response);
        });
    };

    $scope.addRepeaterItem = function (parentIndex, index) {
        if(typeof $scope.existingSections[parentIndex].fields[index].repeater_items == 'undefined'){
            $scope.existingSections[parentIndex].fields[index].repeater_items = [];
        }
        $scope.existingSections[parentIndex].fields[index].repeater_items.push(angular.copy($scope.existingSections[parentIndex].fields[index].repeater_fields));
    };

    $scope.selectFaIcon = function (index, key, value) {
        $scope.fa_preview_index = index;
        $scope.fa_preview_key = key;
        $scope.fa_preview_val = value;
    };

    $scope.remove_image = function (index) {
        $scope.existingSections[index].settings.bg_img_id = false;
        $scope.existingSections[index].settings.bg_img_url = '';
    };

    $scope.upload_image = function(index) {
        var uploader,
            field_index = index;
        uploader = wp.media.frames.file_frame = wp.media({
            title: 'Wybierz logo',
            button: {
                text: 'Wybierz'
            },
            multiple: false
        });
        uploader.on('select', function() {
            var attachment = uploader.state().get('selection').first().toJSON();
            $scope.$apply(function () {
                $scope.existingSections[field_index].settings.bg_img_id = attachment.id;
                $scope.existingSections[field_index].settings.bg_img_url = attachment.url;
            });
        });
        uploader.open();
    };

    $scope.initColorPicker = function (type, index) {
        var $input = jQuery('input#bg_color_'+index),
            field_index = index;
        if(type == 'color' && !$input.is('.wp-color-picker')){
            $input.wpColorPicker({
                change: function(event, ui){
                    $scope.$apply(function () {
                        $scope.existingSections[field_index].settings.bg_color = ui.color.toString();
                    });
                }
            });
        }
    };

    $scope.showData = function () {
        console.log($scope.existingSections);
    };

    $scope.getAllSections();

    jQuery('body').on('click', '[data-show-popup]', function (e) {
        e.preventDefault();
        var $button = jQuery(this),
            $popup = jQuery($button.attr('data-show-popup'));

        if($button.is('.open')){
            $button.removeClass('open');
            $popup.addClass('hidden');
        } else {
            $button.addClass('open');
            $popup.removeClass('hidden');
        }

        $popup.on('click', $button.attr('data-item-class'), function () {
            $button.removeClass('open');
            $popup.addClass('hidden');
        });
    });

    jQuery(document).on('click', function (e) {
        var $container = jQuery('.add-from-sections-list');
        if($container.has(e.target).length === 0){
            jQuery('[data-show-popup]').removeClass('open');
            jQuery(jQuery('[data-show-popup]').attr('data-show-popup')).addClass('hidden');
        }
    });

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