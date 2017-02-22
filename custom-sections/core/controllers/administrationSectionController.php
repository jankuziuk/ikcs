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
            $query = $wpdb->update($table_name_sections,
                array(
                    'section_id' => $request->section_id,
                    'section_name' => $request->name,
                    'section_opions' => serialize($request->settings),
                    'section_value' => serialize($request->fields),
                    'datetime_mod' => date("Y-m-d H:i:s")
                ), array(
                    'id' => $request->id
                ), array(
                    '%s', '%s', '%s', '%s'
                )
            );
        } else {
            $data['type'] = 'insert';
            $query = $wpdb->insert($table_name_sections,
                array(
                    'section_id' => $request->section_id,
                    'section_name' => $request->name,
                    'section_opions' => serialize($request->settings),
                    'section_value' => serialize($request->fields),
                    'datetime_mod' => date("Y-m-d H:i:s")
                ), array(
                    '%s', '%s', '%s', '%s'
                )
            );
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
            $data['section']['section_id'] = $result->section_id;
            $data['section']['name'] = $result->section_name;
            $data['section']['settings'] = unserialize($result->section_opions);
            $data['section']['fields'] = unserialize($result->section_value);
            $data['section']['other_info']['datetime_create'] = $result->datetime_create;
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

if($_REQUEST['action'] == "ikcs_get_fa_json") {
    add_action('wp_ajax_ikcs_get_fa_json', 'ikcs_get_fa_json_callback');
    add_action('wp_ajax_nopriv_ikcs_get_fa_json', 'ikcs_get_fa_json_callback');

    function ikcs_get_fa_json_callback()
    {
        $IKCS = new IKCS();
        $options = $IKCS->get_options();
        $url = $options['dir'] . 'views/css/font-awesome.min.css';
        $pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
        $subject = file_get_contents($url);
        preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
        $icons = array();
        foreach($matches as $key=>$match){
            $icons['fa'][$key]['fa_key'] = $match[1];
            $icons['fa'][$key]['fa_value'] = $match[1];
        }
        echo json_encode($icons);

//        $IKCS = new IKCS();
//        $options = $IKCS->get_options();
//        $url = $options['dir'] . 'helpers/tsconfig.json';
//        $json =   file_get_contents($url,0,null,null);
//
//        if($json != false){
//            $data['status'] = 'OK';
//            $falist = json_decode($json,true);
//            foreach ($falist['icons'] as $key=>$val){
//                $data['fa'][$key]['fa_key'] = 'fa-' . $val['id'];
//                $data['fa'][$key]['fa_value'] = $val['id'];
//                $data['fa'][$key]['fa_categories'] = $val['categories'];
//            }
//        }
//        else{
//            $data['status'] = 'FAIL';
//        }
//        echo json_encode($data);
        wp_die();
    }
}

if($_REQUEST['action'] == "ikcs_save_post") {
    add_action('wp_ajax_ikcs_save_post', 'ikcs_save_post_callback');
    add_action('wp_ajax_nopriv_ikcs_save_post', 'ikcs_save_post_callback');

    function ikcs_save_post_callback()
    {
        $IKCS = new IKCS();
        $options = $IKCS->get_options();

        wp_die();
    }
}