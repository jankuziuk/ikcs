<?php

function ikcs_get_all_postmeta_by_key($meta_key) {
    global $wpdb;
    $results = $wpdb->get_results("SELECT * FROM `". $wpdb->prefix."postmeta` WHERE meta_key='".$meta_key."';");
    foreach ($results AS $key=>$result){
        if ( is_serialized($result->meta_value) ){
            $data[$key] = @unserialize($result->meta_value);
        }
        else{
            $data[$key] = $result->meta_value;
        }
        $data[$key]['meta_id'] = $result->meta_id;
    }
    return $data;
}

function ikcs_edit_path(){
    $IKCS = new IKCS();
    $options = $IKCS->get_options();
    $adminurl = admin_url();
    return $adminurl . 'admin.php?page=' . $options['edit_url'] . '&id=';
}

function ikcs_add_path(){
    $IKCS = new IKCS();
    $options = $IKCS->get_options();
    $adminurl = admin_url();
    return $adminurl . 'admin.php?page=' . $options['add_url'];
}

function ikcs_views_path(){
    $IKCS = new IKCS();
    $options = $IKCS->get_options();
    return $options['views_dir']. 'views';
}