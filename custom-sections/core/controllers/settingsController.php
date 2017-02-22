<?php
if($_REQUEST['action'] == "ikcs_get_langs") {
    add_action('wp_ajax_ikcs_get_langs', 'ikcs_get_langs_callback');
    add_action('wp_ajax_nopriv_ikcs_get_langs', 'ikcs_get_langs_callback');

    function ikcs_get_langs_callback()
    {
        $IKCS = new IKCS();
        $options = $IKCS->get_options();
        $url = $options['views_dir'] . 'helpers/langs.json';
        $langs = file_get_contents($url);
        echo $langs;
        wp_die();
    }
}
?>