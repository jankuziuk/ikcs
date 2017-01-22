<?php
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

function theme_options_init(){
    register_setting( 'wpuniq_options', 'wpuniq_theme_options');
}
global $globalOptions;
$globalOptions = get_option('wpuniq_theme_options');
$defaultOptions = array(
    'show_left_sidebar' => '0',
    'show_right_sidebar' => '1',
    'show_left_sidebar_width' => '200',
    'show_right_sidebar_width' => '200',
    'margin_between_colums' => '15'
);

$globalOptions = wp_parse_args($globalOptions, $defaultOptions);

function theme_options_add_page() {
    add_menu_page( __( 'Ustawienia motywu', 'WP-Unique' ), __( 'Ustawienia motywu', 'WP-Unique' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}
function theme_options_do_page()
{
    global $select_options;
    if (!isset($_REQUEST['settings-updated'])) $_REQUEST['settings-updated'] = false;
    ?>

    <div class="wrap">
        <?php screen_icon();
        echo "<h2>" . __('Ustawienia motywu', 'WP-Unique') . "</h2>"; ?>
        <?php if (false !== $_REQUEST['settings-updated']) : ?>
            <div id="message" class="updated">
                <p><strong><?php _e('Ustawienia motywu zostały zapisane', 'WP-Unique'); ?></strong></p>
            </div>
        <?php endif; ?>
    </div>

    <form method="post" action="options.php">
        <?php
            settings_fields('wpuniq_options');
        ?>
        <h2 class="title">Ustawienia column</h2>
        <h2 class="title">Lewy sidebar</h2>
        <table width="100%" border="0" style="max-width: 500px;">
            <tr>
                <td width="170px;">
                    <fieldset>
                        <label for="wpuniq_theme_options[show_left_sidebar]">
                            <input
                                type="checkbox"
                                name="wpuniq_theme_options[show_left_sidebar]"
                                id="wpuniq_theme_options[show_left_sidebar]"
                                value="1"<?php if ($globalOptions['show_left_sidebar'] == '1') echo ' checked="checked"'; ?>/>Pokazuj lewy sidebar
                        </label>
                    </fieldset>
                </td>
                <td></td>
            </tr>
            <tr>
                <td width="170px;">Szerokość:</td>
                <td>
                    <input
                        type="number"
                        name="wpuniq_theme_options[show_left_sidebar_width]"
                        id="wpuniq_theme_options[show_left_sidebar_width]"
                        value="<?php echo $globalOptions['show_left_sidebar_width']; ?>"
                    /> px
                </td>
            </tr>
        </table>
        <h2 class="title">Prawy sidebar</h2>
        <table width="100%" border="0" style="max-width: 500px;">
            <tr>
                <td width="170px;">
                    <fieldset>
                        <label for="wpuniq_theme_options[show_right_sidebar]">
                            <input
                                type="checkbox"
                                name="wpuniq_theme_options[show_right_sidebar]"
                                id="wpuniq_theme_options[show_right_sidebar]"
                                value="1"
                                <?php if ($globalOptions['show_right_sidebar'] == '1') echo ' checked="checked"'; ?>/>Pokazuj prawy sidebar
                        </label>
                    </fieldset>
                </td>
                <td></td>
            </tr>
            <tr>
                <td width="170px;">Szerokość:</td>
                <td>
                    <input
                        type="number"
                        name="wpuniq_theme_options[show_right_sidebar_width]"
                        id="wpuniq_theme_options[show_right_sidebar_width]"
                        value="<?php echo $globalOptions['show_right_sidebar_width']; ?>"
                    /> px
                </td>
            </tr>
        </table>
        <h2 class="title">Ogólne ustawienia pozycji i odstępów</h2>
        <table width="100%" border="0" style="max-width: 500px;">
            <tr>
                <td width="300px;">Odstęp między kolumnami:</td>
                <td>
                    <input
                        type="number"
                        name="wpuniq_theme_options[margin_between_colums]"
                        id="wpuniq_theme_options[margin_between_colums]"
                        value="<?php echo $globalOptions['margin_between_colums']; ?>"
                    /> px
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Применить"/></td>
            </tr>
        </table>
    </form>

    <?php
}
?>

