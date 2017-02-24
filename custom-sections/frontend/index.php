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
        return ikcs_build_result($result);
    }

    function check_iksc_field($section, $field){
        if(isset($section['fields'][$field])){
            return true;
        } else {
            return false;
        }
    }

    function write_iksc_field($section, $field){
        if(check_iksc_field($section, $field)){
            echo $section['fields'][$field];
        } else {
            return false;
        }
    }

    function write_iksc_background($section){
        if(isset($section['settings']['bg_type'])){
            if($section['settings']['bg_type'] == 'image' && isset($section['settings']['attachment_id'])){
                $img = wp_get_attachment_image_src($section['settings']['attachment_id'], $size = 'full');
                echo 'style="background: url('.$img[0].') '.$section['settings']['bg_pos_ver'].' '.$section['settings']['bg_pos_hor'].'"';
            } else if($section['settings']['bg_type'] == 'color'  && isset($section['settings']['bg_color'])) {

            } else {
                return false;
            }
        } else {
            return false;
        }
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

    function ikcs_build_result($sections){
        if(is_array($sections) && !empty($sections)){
            foreach ($sections as $key=>$section){
                $result[$key]['id'] = $section['id'];
                $result[$key]['name'] = $section['name'];
                $result[$key]['section_id'] = $section['section_id'];
                $result[$key]['fields'] = ikcs_build_fields($section['fields']);
                $result[$key]['settings'] = $section['settings'];
            }
        }
        return $result;
    }

    function ikcs_build_fields($fields){
        foreach ($fields as $key=>$field) {
            if ($field['type'] == 'repeater_object' && isset($field['repeater_items']) && !empty($field['repeater_items'])) {
                ikcs_build_fields($field['repeater_items']);
            } else {
                $result[$field['id']] = $field['value'];
            }
        }
        return $result;
    }


function super_var_dump($var) {
    super_var_dump::init($var);
}
class super_var_dump {
    private static $instance;
    private static $current_depth;
    static function init($a) {
        if ( empty(self::$instance) || ! self::$instance )
            self::$instance = 1;
        else
            self::$instance++;
        if ( empty(self::$current_depth) || ! self::$current_depth ) {
            self::$current_depth = 1; ?>
            <script type="text/javascript">
                function super_var_dump_toggle_div_display(instance, depth) {
                    var div = document.getElementById( 'super-var-dump-container-' + instance + '-' + depth );
                    var span = document.getElementById( 'super-var-dump-arrow-' + instance + '-' + depth );
                    if ( div.style.display == 'none' ) {
                        div.style.display = 'block';
                        span.innerHTML = ' <span style="font-weight: bold; color: red;">v</span> ';
                    }
                    else {
                        div.style.display = 'none';
                        span.innerHTML = ' <span style="font-weight: bold; color: red;">></span> ';
                    }
                    window.getSelection().removeAllRanges();
                }
            </script>
            <?php
            echo '<pre style="font: 14px/22px Lucida Console; overflow: auto; background-color: #1e1d20; color: #56da39;font-weight: bold; overflow-x: auto; white-space: pre-wrap; white-space: -moz-pre-wrap !important; word-wrap: break-word; white-space: normal; padding: 20px;">';
        } else
            self::$current_depth++;
        self::select_variable_type($a);
        self::$current_depth--;
        if ( ! self::$current_depth )
            echo '</pre>';
    }
    static function select_variable_type($a) {
        if ( is_object($a) )
            self::output_object($a);
        else if ( is_array($a) )
            self::output_array($a);
        else if ( is_numeric($a) )
            self::output_numeric($a);
        else if ( is_string($a) )
            self::output_string($a);
        else if ( is_bool($a) )
            self::output_bool($a);
        else if ( is_null($a) )
            self::output_null($a);
    }
    static function output_object($a) {
        $object_vars = get_object_vars($a);
        echo '<ul style="padding:10px" id="super-var-dump-' . self::$instance . '">';
        echo '<span id="super-var-dump-arrow-' .  self::$instance . '-' . self::$current_depth . '" style="cursor: pointer" onclick="super_var_dump_toggle_div_display(' . self::$instance . ', ' . self::$current_depth . ')"> <span style="font-weight: bold; color: red;">></span> </span>Object';
        echo '<ul id="super-var-dump-container-' .  self::$instance . '-' . self::$current_depth . '" style="display:none; padding: 10px">';
        echo '<ul>';
        foreach ( $object_vars as $object_var_key => $object_var_value ) {
            echo '<li>';
            echo $object_var_key . ' => ';
            self::init($a->$object_var_key);
            echo '</li>';
        }
        echo '</ul>';
        echo '</ul>';
        echo '</ul>';
    }
    static function output_array($a) {
        $keys = array_keys($a);
        $element = ( !empty( $keys ) ) ? 'ul' : 'span';
        $top = $element == 'ul' ? '<'. $element. ' id="super-var-dump-' . self::$instance . '">' : '<'. $element. ' id="super-var-dump-' . self::$instance . '">';
        echo $top;
        if ( !empty( $keys ) ) {
            echo 'array:'.count($keys).' <span id="super-var-dump-arrow-' .  self::$instance . '-' . self::$current_depth . '" style="cursor: pointer" onclick="super_var_dump_toggle_div_display(' . self::$instance . ', ' . self::$current_depth . ')"> <span style="font-weight: bold; color: red;">></span> </span>';
            echo '<ul id="super-var-dump-container-' .  self::$instance . '-' . self::$current_depth . '" style="display:none; padding-left: 20px;">';
            foreach($keys as $key) {
                echo '<li>';
                echo $key . " => ";
                super_var_dump($a[$key]);
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo 'array()';
        }
        echo '</' .$element .'>';
    }
    static function output_numeric($a) {
        echo '<span style="color: #1299da;">'.$a.'</span>';
        // echo '<br style="padding: 5px 0;">';
    }
    static function output_string($a) {
        if ( ! $a ) echo '<span style="color: #ffffff;">""</span>';
        else echo '<span style="color: #ffffff;">"'.$a.'"</span>';
        // echo '<br style="padding: 5px 0;">';
    }
    static function output_bool($a) {
        if ( $a ) echo '<span style="color: #ff6716;">true</span>';
        else echo '<span style="color: #ff6716;">false</span>';
        // echo '<br style="padding: 5px 0;">';
    }
    static function output_null($a) {
        echo '<span style="color: #ff6716;">NULL</span>';
    }
}
