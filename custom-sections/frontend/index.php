<?php
    function write_iksc_sections($id = false){
        $IKCS = new IKCS();
        $options = $IKCS->get_options();
        $ikcsSections = get_ikcs_sections($id = false);
        if ($ikcsSections){
            foreach ($ikcsSections as $section){
                if(include_exists($options['dir'] . 'templates/'.$section['section_id'].'.php')){
                    include($options['dir'] . 'templates/'.$section['section_id'].'.php');
                } else {
                    if (current_user_can('editor') || current_user_can('administrator')){
                        $message = 'Template "'.$section['section_id'].'" not found in '.$options['views_dir'] . 'templates/'.$section['section_id'].'.php';
                        add_bootstrap_alert('danger', $message);
                    }
                }
            }
        }
    }

    function get_ikcs_sections($id = false){
        if($id == false){
            $id = get_post()->ID;
        }
        $postSections = get_post_meta($id, 'ikcs_post_meta_key', true);
        if (empty($postSections)){
            $result = false;
        } else {
            $result = json_decode(json_encode($postSections), true);
        }
        return $result;
    }

    function include_exists ($fileName){
        if (realpath($fileName) == $fileName) {
            return is_file($fileName);
        }
        if ( is_file($fileName) ){
            return true;
        }

        $paths = explode(PS, get_include_path());
        foreach ($paths as $path) {
            $rp = substr($path, -1) == DS ? $path.$fileName : $path.DS.$fileName;
            if ( is_file($rp) ) {
                return true;
            }
        }
        return false;
    }

    function add_bootstrap_alert($type, $message, $close=true){
        if($type && $message){
            echo '<div class="alert alert-'.$type.'" role="alert">';
            if($close){
                echo '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
                echo $message;
            }
            echo '</div>';
        }
    }