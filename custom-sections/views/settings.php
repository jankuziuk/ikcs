<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<div class="wrap ikcs ikcs-wrap" data-ng-app="ikcs">
    <div data-ng-controller="ikcsSettings">
        <div class="main-header">
            <h1 class="wp-heading-inline"><?php echo __('Ustawienia', 'ikcs-trans'); ?></h1>
        </div>

        <div class="main-container ng-cloak" data-ng-cloak>
            <div id="poststuff">
                <div id="post-body">
                    <div class="ikcs-card">
                        <select class="form-control">
                            <option data-ng-repeat="lang in langs" data-ng-value="lang.code">{{ lang.name }} ({{lang.nativeName}})</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ikcs-copyring">
    &copy; 2017 Ivan Kuziuk by Dream Page
</div>