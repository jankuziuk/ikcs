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
                datetime_mod TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (id)
            ) $charset_collate;";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
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
        wp_enqueue_script( 'ikcs-sortable', $this->settings['views_dir'].'views/js/libraries/sortable.js');
        wp_enqueue_script( 'ikcs-pagination', $this->settings['views_dir'].'views/js/libraries/dirPagination.js');
        wp_enqueue_script( 'ikcs-notify', $this->settings['views_dir'].'views/js/libraries/angular-notify.min.js');
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


//class IK_Custom_sections {
//
//    /**
//     * Constructor
//     */
//    public function __construct() {
//        add_action( 'save_post', array( $this, 'wpdocs_save_posts' ) );
//    }
//
//    /**
//     * Handle saving post data.
//     */
//    public function wpdocs_save_posts() {
//        // do stuff here...
//    }
//}
//
//IK_Custom_sections::init();
//


function ik_define_sections(){
    $post_id = $_GET['post'];
    $customSections = array(
        0=> array(
            'box_id' => 'banner',
            'box_name' => 'Banner',
            'box_fields' => array(
                0 => array(
                    'field_type' => 'text',
                    'field_id' => 'title',
                    'field_value' => '',
                    'field_label' => 'Tytuł',
                    'field_placeholder' => ''
                ),
                1 => array(
                    'field_type' => 'text',
                    'field_id' => 'title2',
                    'field_value' => '',
                    'field_label' => 'Tytuł 2',
                    'field_placeholder' => ''
                )
            )
        ),
        1=> array(
            'box_id' => 'banner2',
            'box_name' => 'Banner 2',
            'box_fields' => array(
                0 => array(
                    'field_type' => 'text',
                    'field_id' => 'title',
                    'field_value' => '',
                    'field_label' => 'Tytuł',
                    'field_placeholder' => ''
                ),
                1 => array(
                    'field_type' => 'text',
                    'field_id' => 'title2',
                    'field_value' => '',
                    'field_label' => 'Tytuł 2',
                    'field_placeholder' => ''
                )
            )
        )
    );
//    var_dump($post_id);
    update_post_meta( $post_id, 'test_test_test', $customSections);
    return $customSections;
}
add_action('init', 'ik_define_sections');

function ik_add_custom_box() {
    $screens = array( 'post', 'page' );
    $sections = ik_define_sections();
    foreach ( $screens as $screen ){
        foreach ( $sections as $section ){
            add_meta_box($section['box_id'], $section['box_name'], 'ik_generate_section', $screen, 'advanced', 'default', $section['box_fields']);
        }
    }
}
add_action('add_meta_boxes', 'ik_add_custom_box');

/* HTML код блока */
function ik_generate_section($post, $box_fields) {
    wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );
    echo '<table class="form-table">';
    foreach ($box_fields['args'] AS $field){
        includeFileWithVariables($field['field_type'], array('box_id' => $box_fields['id'], 'field' => $field));
    }
    echo '</table>';
}

function includeFileWithVariables($type, $args) {
    extract($args);
    if($type == 'text' || $type == 'email' || $type == 'number'){
        $file = 'input_text.php';
    }
    include(get_template_directory() . '/custom-sections/fields/'.$file);
}

/* Сохраняем данные, когда пост сохраняется */
function myplugin_save_postdata( $post_id ) {
    // проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
    if ( ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) ) )
        return $post_id;

    // проверяем, если это автосохранение ничего не делаем с данными нашей формы.
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    // проверяем разрешено ли пользователю указывать эти данные
    if ( 'page' == $_POST['post_type'] && ! current_user_can( 'edit_page', $post_id ) ) {
        return $post_id;
    } elseif( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }

    // Убедимся что поле установлено.
    if ( ! isset( $_POST['myplugin_new_field'] ) )
        return;

    // Все ОК. Теперь, нужно найти и сохранить данные
    // Очищаем значение поля input.
    $my_data = sanitize_text_field( $_POST['myplugin_new_field'] );

    // Обновляем данные в базе данных.
    update_post_meta( $post_id, '_my_meta_value_key', $my_data );
}
add_action( 'save_post', 'myplugin_save_postdata' );
?>