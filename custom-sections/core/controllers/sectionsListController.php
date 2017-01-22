<?php
if($_REQUEST['action'] == "ikcs_get_all_sections") {
    add_action('wp_ajax_ikcs_get_all_sections', 'ikcs_get_all_sections_callback');
    add_action('wp_ajax_nopriv_ikcs_get_all_sections', 'ikcs_get_all_sections_callback');

    function ikcs_get_all_sections_callback()
    {
        global $wpdb;
        $table_name_sections = $wpdb->prefix . 'ikcs_sections';
        $result = $wpdb->get_results('SELECT `id`, `section_name`, `datetime_mod` FROM '.$table_name_sections.' ORDER BY datetime_mod');
        if(is_array($result)){
            $data['status'] = 'OK';
            $data['sections'] = $result;
        }
        else{
            $data['status'] = 'FAIL';
        }

        echo json_encode($data);
        wp_die();
    }
}