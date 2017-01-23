<?php

/**
 * Settings:
 *
 * - fields:
 *  -- type:
 *    --- text
 *    --- email
 *    --- number
 *    --- checkbox
 *    --- radio
 *    --- textarea
 */


class IKCS{

//    var $settings;

    private $settings = array();

    /* Constructor */

    function __construct()
    {
        $this->settings = array(
            'dir'=> get_template_directory() . '/custom-sections/',
            'views_dir'=> get_template_directory_uri() . '/custom-sections/',
            'list_url' => 'ikcs-list',
            'add_url' => 'ikcs-add',
            'edit_url' => 'ikcs-edit',
            'meta_key' => 'ikcs_fields',
            'sections_table' => 'ikcs_sections'
        );

        add_filter('IKCS/get_options', array($this, 'get_options'), 1);

        add_action('init', array($this, 'init'), 1);
        add_action('init', array($this, 'ikcs_create_table'), 1);
        add_action( 'add_meta_boxes', array( $this, 'ikcs_add_meta_box' ) );


    }

    function init()
    {
        global $pagenow;
        include($this->settings['dir'] . 'core/index.php');
        include($this->settings['dir'] . 'core/controllers/sectionsListController.php');
        include($this->settings['dir'] . 'core/controllers/administrationSectionController.php');
        if( is_admin() )
        {
            add_action('admin_menu', array($this,'ikcs_register_in_menu'));
            add_action('admin_enqueue_scripts', array($this,'includes_files'));

        }
    }

    public function get_options(){
        return $this->settings;
    }

    function ikcs_create_table(){
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name_sections = $wpdb->prefix . $this->settings['sections_table'];
        $table_name_postmeta = $wpdb->prefix . 'ikcs_postmeta';

        if($wpdb->get_var("SHOW TABLES LIKE '$table_name_sections'") != $table_name_sections) {
            $sql = "CREATE TABLE $table_name_sections (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                section_name VARCHAR(255),
                section_opions longtext,
                section_value longtext,
                datetime_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                datetime_mod TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (id)
            ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }

        if($wpdb->get_var("SHOW TABLES LIKE '$table_name_postmeta'") != $table_name_postmeta) {
            $sql = "CREATE TABLE $table_name_postmeta (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                post_id bigint(20),
                section_name VARCHAR(255),
                section_opions longtext,
                section_value longtext,
                datetime_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                datetime_mod TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (id)
            ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

    public function ikcs_add_meta_box( $post_type ) {
        // Устанавливаем типы постов к которым будет добавлен блок
        $post_types = array('post', 'page');
        if ( in_array( $post_type, $post_types )) {
            add_meta_box(
                'ikcs_meta_box_sections'
                ,__( 'Custom sections', 'ikcs-trans' )
                ,array( $this, 'render_meta_box_content' )
                ,$post_type
                ,'advanced'
                ,'high'
            );
        }
    }

    public function render_meta_box_content(){
        include($this->settings['dir'] . 'views/page-sections.php');
    }

    function ikcs_register_in_menu()
    {
        add_menu_page(
            __( 'Zdefiniowane sekcje', 'ikcs-trans' ),
            'Zdefiniowane sekcje',
            'manage_options',
            $this->settings['list_url'],
            array( $this, 'render_admin_page' ),
            'dashicons-layout'
        );
        add_submenu_page(
            'ikcs-list',
            __( 'Dodaj sekcje', 'ikcs-trans' ),
            __( 'Dodaj sekcje', 'ikcs-trans' ),
            'manage_options',
            $this->settings['add_url'],
            array( $this, 'render_add_page' )
        );
        add_pages_page(
            __( 'Edytuj sekcje', 'ikcs-trans' ),
            __( 'Edytuj sekcje','ikcs-trans' ),
            'manage_options',
            $this->settings['edit_url'],
            array( $this, 'render_edit_page' )
        );
    }

    public function render_admin_page(){
        include_once($this->settings['dir'] . 'views/index.php');
    }

    public function render_add_page(){
        include_once($this->settings['dir'] . 'views/add.php');
    }

    public function render_edit_page(){
        include_once($this->settings['dir'] . 'views/add.php');
    }

    public function includes_files(){
        wp_enqueue_style( 'ikcs-style', $this->settings['views_dir'].'views/css/style.css');
        wp_enqueue_script( 'ikcs-angular', $this->settings['views_dir'].'views/js/libraries/angular.min.js');
//        wp_enqueue_script( 'ikcs-sortable', $this->settings['views_dir'].'views/js/libraries/sortable.js');
//        wp_enqueue_script( 'ikcs-pagination', $this->settings['views_dir'].'views/js/libraries/dirPagination.js');
//        wp_enqueue_script( 'ikcs-notify', $this->settings['views_dir'].'views/js/libraries/angular-notify.min.js');
        wp_enqueue_script( 'ikcs-app', $this->settings['views_dir'].'views/js/app.js');
    }
}

function IKCS()
{
    global $IKCS;

    if( !isset($IKCS) )
    {
        $IKCS = new IKCS();
    }

    return $IKCS;
}


// initialize
IKCS();
?>