<?php
    function the_ikcs_sections(){
        $post = get_post();
        $postData = unserialize(get_post_meta( $post->ID, '_my_meta_value_key', true));
        var_dump($postData);
        foreach ($postData as $section){
            $data[$section['id']]['settings'] = $section['settings'];
            foreach ($section['fields'] as $key=>$field){
                $data['fields'][$field['id']] = $field['value'];
            }
        }
//        $data['settings'] = $postData['settings'];

//        $data['fields'] = [];
//
//

        return $data;
    }