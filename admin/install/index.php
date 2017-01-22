<?php
add_action('after_switch_theme', 'install_ik_customizer');

function install_ik_customizer () {
//    $insertValues = '';
//    $defaultOptions = array(
//        'general_logo_align' => 'left',
//        'layout_grid_type' => 'one_right',
//        'layout_grid_content_width' => '1200',
//        'layout_grid_left_sidebar_width' => '300',
//        'layout_grid_right_sidebar_width' => '300',
//        'layout_grid_margin_between_columns' => '15'
//    );
//    $index = 0;
//    foreach ($defaultOptions as $kay=>$val){
//        $insertValues = $insertValues . '("'.(string)$kay.'","'.(string)$val.'")';
//        $index++;
//        if($index <= count($defaultOptions) - 1){
//            $insertValues = $insertValues . ',';
//        }
//    }
//    global $wpdb;
//    $table_name = $wpdb->prefix.'ik_settings';
//    $charset_collate = $wpdb->get_charset_collate();
//    if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
//        $sql = "CREATE TABLE $table_name (
//              id mediumint(9) NOT NULL AUTO_INCREMENT,
//              name text NOT NULL,
//              value text NOT NULL,
//              PRIMARY KEY  (id)
//        ) $charset_collate;";
//        $insert = 'INSERT INTO '.$table_name.' (`name`, `value`) VALUES '.$insertValues.';';
//        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//        dbDelta( $sql );
//        dbDelta($insert);
//    }
}
?>