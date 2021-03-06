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

function get_image_sizes() {
    global $_wp_additional_image_sizes;

    $sizes = array();

    foreach ( get_intermediate_image_sizes() as $_size ) {
        if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
            $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
            $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
            $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
                'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
            );
        }
    }

    return $sizes;
}
