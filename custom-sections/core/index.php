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

function misha_image_uploader_field( $name, $value = '') {
    $image = ' button">Upload image';
    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
    $display = 'none'; // display state ot the "Remove image" button

    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

        // $image_attributes[0] - image URL
        // $image_attributes[1] - image width
        // $image_attributes[2] - image height

        $image = '"><img src="' . $image_attributes[0] . '" style="max-width:95%;display:block;" />';
        $display = 'inline-block';

    }

    return '
	<div>
		<a href="#" class="misha_upload_image_button' . $image . '</a>
		<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
		<a href="#" class="misha_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
	</div>';
}
