<?php

add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );

function add_files_to_theme() {
    wp_enqueue_style( 'style', get_template_directory_uri() . '/api/css/theme.min.css');
    wp_enqueue_script( 'script', get_template_directory_uri() . '/api/js/theme.min.js');
}
add_action( 'wp_enqueue_scripts', 'add_files_to_theme' );

require_once get_template_directory() . '/admin/index.php';

// Global settings
require_once get_template_directory() . '/inc/global_settings.php';

// Register widget areas
require_once get_template_directory() . '/inc/register_widget_areas.php';


require_once get_template_directory() . '/custom-sections/ikcs.php';
