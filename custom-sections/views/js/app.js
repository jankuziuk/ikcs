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
    $scope.imageSizes = imageSizes;

    console.log($scope.imageSizes);

    $scope.sortableOptions = {
        cursor: "move",
        axis: 'y'
    };

    $scope.addNewSection = function () {
        var section={
            id: '',
            label: '',
            value: '',
            open: true,
            required: 'off'
        };
        $scope.ikcsAdd.fields.push(section);
        console.log($scope.ikcsAdd);
    };

    $scope.addNewSubSection = function (data) {
        var section={
            id: '',
            label: '',
            value: '',
            open: true,
            required: 'off'
        };
        if(typeof data.repeater_fields == "undefined"){
            data.repeater_fields = [];
        }
        data.repeater_fields.push(section);
    };

    $scope.removeSubItem = function(array, index){
        if(typeof array.repeater_fields == "undefined"){
            array.fields.splice(index, 1);
        } else {
            array.repeater_fields.splice(index, 1);
        }
    };

    $scope.addOptionItem = function (data) {
        if(typeof data.field_options == "undefined"){
            data.field_options = [];
        }
        data.field_options.push({value: "", label: ""});
    };

    $scope.removeOptionItem = function (data, index) {
        data.splice(index, 1);
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
    $scope.languages = languages;
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
            var arr = angular.copy(response.data.section);
            arr.field_input_name = '[fields]';
            $scope.existingSections.push(arr);
            $scope.addNewSectionBefore = false;
        }, function errorCallback(response) {
            console.warn(response);
        });
    };

    $scope.addRepeaterItem = function (data) {
        console.log(data);
        var count = 0,
            field_input_name = '',
            arr = [];

        if(typeof data.repeater_items == "undefined"){
            data.repeater_items = [];
        }
        count = data.repeater_items.length;
        arr = angular.copy(data.repeater_fields);
        arr.field_input_name = field_input_name + '['+count+']';
        data.repeater_items.push(arr);
    };

    $scope.removeRepeaterItem = function (array, index) {
        array.splice(index, 1);
    };

    $scope.upload_img = function(data) {
        var uploader;
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
                data.attachment_id = attachment.id;
                data.attachment_url = attachment.url;
                data.has_attachment = true;
            });
        });
        uploader.open();
    };

    $scope.remove_img = function (data) {
        data.has_attachment = false;
        delete data.attachment_id;
        delete data.attachment_url;
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

    $scope.showSelectFaIcon = function (className, data) {
        angular.element(className).show();
        $scope.selectFaIcon = function (value) {
            data.value = value;
            angular.element(className).hide();
        }
    };

    $scope.removeFaIcon = function (data) {
        data.value = '';
    };

    $scope.previewFaIcon = function (index, key, value) {
        $scope.fa_preview_index = index;
        $scope.fa_preview_key = key;
        $scope.fa_preview_val = value;
    };

    $scope.hidePopup = function (className) {
        angular.element(className).hide();
    };

    $scope.submitPageIKSCForm = function () {

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

    jQuery('body').on('mouseover', '.remove-repeater-item button', function () {
        jQuery(this).closest('.repeater').addClass('removehovered');
    }).on('mouseout', '.remove-repeater-item button', function () {
        jQuery(this).closest('.repeater').removeClass('removehovered');
    })

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