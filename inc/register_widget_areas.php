<?php

if($GLOBALS['custom_options']['grid_type'] == 'two' || $GLOBALS['custom_options']['grid_type'] == 'one_left') {
    add_action('widgets_init', 'register_left_sidebar');
    function register_left_sidebar()
    {
        register_sidebar(
            array(
                'name' => __('Lewy sidebar', 'theme_text_domain'),
                'id' => 'left-sidebar',
                'description' => 'Widgety po lewej stronie',
                'class' => '',
                'before_widget' => '<div class = "widget-content">',
                'after_widget' => '</div>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>'
            )
        );
    }
}

if($GLOBALS['custom_options']['grid_type'] == 'two' || $GLOBALS['custom_options']['grid_type'] == 'one_right') {
    add_action('widgets_init', 'register_right_sidebar');
    function register_right_sidebar()
    {
        register_sidebar(
            array(
                'name' => __('Prawy sidebar', 'theme_text_domain'),
                'id' => 'right-sidebar',
                'description' => 'Widgety po prawej stronie',
                'class' => '',
                'before_widget' => '<div class = "widget-content">',
                'after_widget' => '</div>',
                'before_title' => '<h2 class="widget-title">',
                'after_title' => '</h2>'
            )
        );
    }
}