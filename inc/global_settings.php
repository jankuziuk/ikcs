<?php
    $globalOptions = get_option('ik_theme_options');
    $defaultOptions = array(
        'logo_align' => 'left',
        'grid_type' => 'one_right',
        'grid_content_width' => '1200',
        'grid_mobile_width' => '767',
        'grid_left_sidebar_width' => '300',
        'grid_right_sidebar_width' => '300',
        'grid_margin_between_columns' => '15'
    );
    if($globalOptions){
        $GLOBALS['custom_options'] = array_merge($defaultOptions, $globalOptions);
    }
    else{
        $GLOBALS['custom_options'] = $defaultOptions;
    }