<?php
if($_REQUEST['action'] == "ikcs_update_section"){
    add_action('wp_ajax_ikcs_update_section', 'ikcs_update_section_callback');
    add_action( 'wp_ajax_nopriv_ikcs_update_section', 'ikcs_update_section_callback' );

    function ikcs_update_section_callback() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        global $wpdb;
        $table_name_sections = $wpdb->prefix . 'ikcs_sections';
        $data['status'] = '';
        if($request->id){
            $data['type'] = 'update';
            $query = $wpdb->update($table_name_sections, array('section_name' => $request->name, 'section_opions' => serialize($request->settings), 'section_value' => serialize($request->fields)), array( 'id' => $request->id ), array('%s', '%s', '%s'));
        } else {
            $data['type'] = 'insert';
            $query = $wpdb->insert($table_name_sections, array('section_name' => $request->name, 'section_opions' => serialize($request->settings), 'section_value' => serialize($request->fields)), array('%s', '%s', '%s'));
        }
        if ($query === FALSE){
            $data['status'] = "FAIL";
        }
        else{
            $data['status'] = "OK";
        }
        if($data['type']=='insert'){
            $data['id'] = $wpdb->insert_id;
        }
        echo json_encode($data);
        wp_die();
    }
}

if($_REQUEST['action'] == "ikcs_get_section_by_id") {
    add_action('wp_ajax_ikcs_get_section_by_id', 'ikcs_get_section_by_id_callback');
    add_action('wp_ajax_nopriv_ikcs_get_section_by_id', 'ikcs_get_section_by_id_callback');

    function ikcs_get_section_by_id_callback()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        global $wpdb;
        $table_name_sections = $wpdb->prefix . 'ikcs_sections';
        $result = $wpdb->get_row('SELECT * FROM '.$table_name_sections.' WHERE `id`='.$request->id);
        if($result){
            $data['status'] = 'OK';
            $data['section']['id'] = $result->id;
            $data['section']['name'] = $result->section_name;
            $data['section']['settings'] = unserialize($result->section_opions);
            $data['section']['fields'] = unserialize($result->section_value);
            $data['section']['other_info']['datetime_mod'] = $result->datetime_mod;
        }
        else{
            $data['status'] = 'FAIL';
        }

        echo json_encode($data);
        wp_die();
    }
}

if($_REQUEST['action'] == "ikcs_remove_section_by_id") {
    add_action('wp_ajax_ikcs_remove_section_by_id', 'ikcs_remove_section_by_id_callback');
    add_action('wp_ajax_nopriv_ikcs_remove_section_by_id', 'ikcs_remove_section_by_id_callback');

    function ikcs_remove_section_by_id_callback()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        global $wpdb;
        $table_name_sections = $wpdb->prefix . 'ikcs_sections';
        $result = $wpdb->delete($table_name_sections, array('id' => $request->id));
        if($result){
            $data['status'] = 'OK';
        }
        else{
            $data['status'] = 'FAIL';
        }
        echo json_encode($data);
        wp_die();
    }
}