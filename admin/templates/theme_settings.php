<?php
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

function load_custom_wp_admin_files() {
    wp_enqueue_style( 'options_style', get_template_directory_uri() . '/admin/css/style.css');
    wp_enqueue_script( 'options_script', get_template_directory_uri() . '/admin/js/global.js');
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_files');

function theme_options_init(){
    register_setting( 'ik_options', 'ik_theme_options');
}
function logo_setting() {  echo '<input type="file" name="logo" />';}

function theme_options_add_page() {
    add_menu_page( __( 'Ustawienia motywu', 'WP-Unique' ), __( 'Ustawienia motywu', 'WP-Unique' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

function theme_options_do_page()
{
    global $select_options;
    if (!isset($_REQUEST['settings-updated'])) $_REQUEST['settings-updated'] = false;
    ?>

    <div class="primary-content">
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
                settings_fields('ik_options');
                global $options;
                $globalOptions = get_option('ik_theme_options');
                $defaultOptions = array(
                    'logo_align' => 'left',
                    'grid_type' => 'one_right',
                    'grid_content_width' => '1200',
                    'grid_mobile_width' => '767',
                    'grid_left_sidebar_width' => '300',
                    'grid_right_sidebar_width' => '300',
                    'grid_margin_between_columns' => '15'
                );
                if($globalOptions){
                    $options = array_merge($defaultOptions, $globalOptions);
                }
                else{
                    $options = $defaultOptions;
                }
            ?>

            <div class="top-panel wrap">
                <h2><?php echo __('Ustawienia motywu', 'WP-Unique'); ?></h2>
                <p class="submit">
                    <input type="submit" name="submit" class="button button-primary" value="Zapisz zmiany">
                </p>
                <?php if (false !== $_REQUEST['settings-updated']) : ?>
                    <div id="message" class="updated">
                        <p><strong><?php _e('Ustawienia motywu zostały zapisane', 'WP-Unique'); ?></strong></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="middle-panel">

                <div class="ik-tabs">
                    <div class="ik-tabs-menu">
                        <div class="ik-tabs-menu-item ik-tab-menu-active" data-ik-tabs-menu-id="generaloptions">Ustawienia ogólne</div>
                        <div class="ik-tabs-menu-item" data-ik-tabs-menu-id="layoutoptions">Opcje układu</div>
                        <div class="ik-tabs-menu-item" data-ik-tabs-menu-id="contact">Kontakt</div>
                        <div class="ik-tabs-menu-item" data-ik-tabs-menu-id="footer">Footer</div>
                        <div class="ik-tabs-menu-item" data-ik-tabs-menu-id="statistics">Statystyka</div>
                    </div>
                    <div class="ik-tabs-body">
                        <div class="ik-tabs-body-item ik-tab-body-active" data-ik-tabs-body-id="generaloptions">
                            <div class="ik-settings-section">
                                <div class="ik-head">Logo</div>
                                <table class="form-table">
                                    <tr>
                                        <th scope="row">
                                            <label for="ik_logo_url">URL</label>
                                        </th>
                                        <td>
                                            <img src="<?php echo $options['logo_url']; ?>" alt="Logo" id="ik_logo_img" style="vertical-align: middle;" />
                                            <input type="hidden" name="ik_theme_options[logo_url]" id="ik_logo_url" value="<?php echo $options['logo_url']; ?>">
                                            <a class="button" onclick="upload_image();" style="vertical-align: middle;">Dodaj logo</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th scope="row">
                                            <label for="ik_logo_width">Rozmiary</label>
                                        </th>
                                        <td>
                                            (<input type="number" name="ik_theme_options[logo_width]" id="ik_logo_width" value="<?php echo $options['logo_width']; ?>" /> X <input type="number" name="ik_theme_options[logo_height]" id="ik_logo_height" value="<?php echo $options['logo_height']; ?>" />) px
                                            <p class="description">(Szerokość X Wysokość) wartości podają się w px</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="ik_logo_position">Położenie</label>
                                        </th>
                                        <td>
                                            <select name="ik_theme_options[logo_align]" id="ik_logo_position">
                                                <option value="left" <?php if($options['logo_align'] == 'left'): ?>selected="selected"<?php endif; ?>>Do lewej</option>
                                                <option value="right" <?php if($options['logo_align'] == 'right'): ?>selected="selected"<?php endif; ?>>Do prawej</option>
                                                <option value="center" <?php if($options['logo_align'] == 'center'): ?>selected="selected"<?php endif; ?>>Wyśrodkować</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="ik-tabs-body-item" data-ik-tabs-body-id="layoutoptions">
                            <div class="ik-settings-section">
                                <div class="ik-head">Układ</div>
                                <table class="form-table">
                                    <tr>
                                        <th scope="row">
                                            <label>Typ układu</label>
                                        </th>
                                        <td>
                                            <div class="type-of-grid">
                                                <div class="item">
                                                    <label class="tooltip-wrapper">
                                                        <input type="radio" name="ik_theme_options[grid_type]" value="only_content" <?php if($options['grid_type'] == 'only_content'): ?>checked="checked"<?php endif; ?> />
                                                        <span class="icon only_content"></span>
                                                        <span class="tooltip-text">Tylko content</span>
                                                    </label>
                                                </div>
                                                <div class="item">
                                                    <label class="tooltip-wrapper">
                                                        <input type="radio" name="ik_theme_options[grid_type]" value="two" <?php if($options['grid_type'] == 'two'): ?>checked="checked"<?php endif; ?> />
                                                        <span class="icon two-sb"></span>
                                                        <span class="tooltip-text">Lewy i prawy</span>
                                                    </label>
                                                </div>
                                                <div class="item">
                                                    <label class="tooltip-wrapper">
                                                        <input type="radio" name="ik_theme_options[grid_type]" value="one_left" <?php if($options['grid_type'] == 'one_left'): ?>checked="checked"<?php endif; ?> />
                                                        <span class="icon one-left-sb"></span>
                                                        <span class="tooltip-text">Tylko lewy</span>
                                                    </label>
                                                </div>
                                                <div class="item">
                                                    <label class="tooltip-wrapper">
                                                        <input type="radio" name="ik_theme_options[grid_type]" value="one_right" <?php if($options['grid_type'] == 'one_right'): ?>checked="checked"<?php endif; ?> />
                                                        <span class="icon one-right-sb"></span>
                                                        <span class="tooltip-text">Tylko prawy</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="ik_content_width">Szerokość strony</label>
                                        </th>
                                        <td>
                                            <input type="number" name="ik_theme_options[grid_content_width]" id="ik_content_width" value="<?php echo $options['grid_content_width']; ?>" class="regular-text" /> px
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="ik_left_sb_width">Szerokość lewej kolumnu</label>
                                        </th>
                                        <td>
                                            <input type="number" name="ik_theme_options[grid_left_sidebar_width]" id="ik_left_sb_width" value="<?php echo $options['grid_left_sidebar_width']; ?>" class="regular-text" /> px
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="ik_right_sb_width">Szerokość prawej kolumnu</label>
                                        </th>
                                        <td>
                                            <input type="number" name="ik_theme_options[grid_right_sidebar_width]" id="ik_right_sb_width" value="<?php echo $options['grid_right_sidebar_width']; ?>" class="regular-text" /> px
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="ik_right_sb_margin_between_columns">Odstęp między kolumnami</label>
                                        </th>
                                        <td>
                                            <input type="number" name="ik_theme_options[grid_margin_between_columns]" id="ik_right_sb_margin_between_columns" value="<?php echo $options['grid_margin_between_columns']; ?>" class="regular-text" /> px
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">
                                            <label for="ik_right_sb_grid_mobile_width">Spadanie kolumn na szerokości do</label>
                                        </th>
                                        <td>
                                            <input type="number" name="ik_theme_options[grid_mobile_width]" id="ik_right_sb_grid_mobile_width" value="<?php echo $options['grid_mobile_width']; ?>" class="regular-text" /> px
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="ik-tabs-body-item" data-ik-tabs-body-id="contact">
                            <div class="ik-settings-section">
                                <div class="ik-head">Dane kontaktowe</div>
                                <table class="form-table">
                                    <?php foreach ($options['contact_addresses'] as $address): ?>
                                    <?php endforeach; ?>
                                    <?php if (count($options['contact_addresses']) > 1): ?>
                                        <?php foreach ($options['contact_addresses'] as $key=>$address): ?>

                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <th scope="row">
                                                <label for="ik_address_line0">Adres</label>
                                            </th>
                                            <td>
                                                <input type="text" name="ik_theme_options[contact_addresses][address0]" id="ik_address_line_0" value="<?php echo $options['contact_addresses']['0']; ?>" class="regular-text" />
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <tr>
                                        <th scope="row">
                                            <label for="ik_phone_line0">Telefon</label>
                                        </th>
                                        <td>
                                            <input type="text" name="ik_theme_options[contact_phones_0]" id="ik_phone_line0" value="<?php echo $options['contact_phones_0']; ?>" class="regular-text" />
                                        </td>
                                    <tr>
                                        <th scope="row">
                                            <label for="ik_email_line0">E-mail</label>
                                        </th>
                                        <td>
                                            <input type="text" name="ik_theme_options[contact_emails_0]" id="ik_email_line0" value="<?php echo $options['contact_emails_0']; ?>" class="regular-text" />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="ik-tabs-body-item" data-ik-tabs-body-id="footer">
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        <label for="ik_copyring_message">Powiadomienie dotyczące prawa autorskiego</label>
                                    </th>
                                    <td>
                                        <textarea name="ik_theme_options[footer_copy]" id="ik_copyring_message" class="regular-text" rows="3"><?php echo $options['footer_copy']; ?></textarea>
                                        <p class="description">Tu wpisz powiadomienie dotyczące prawa autorskiego, które będzie pokazywanie w stopce</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="ik-tabs-body-item" data-ik-tabs-body-id="statistics">
                            <table class="form-table">
                                <tr>
                                    <th scope="row">
                                        <label for="ik_statistics">Google Analytics</label>
                                    </th>
                                    <td>
                                        <textarea name="ik_theme_options[statistics_ga]" id="ik_statistics" class="large-text code" rows="6"><?php echo $options['statistics_ga']; ?></textarea>
                                        <p class="description">Wklej swój kod Google Analytics, będzie on dodany przed zamknięciem tagu &#60;&#47;head&#62;</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        var uploader;
        function upload_image() {

            //Extend the wp.media object
            uploader = wp.media.frames.file_frame = wp.media({
                title: 'Wybierz logo',
                button: {
                    text: 'Wybierz'
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            uploader.on('select', function() {
                var attachment = uploader.state().get('selection').first().toJSON();
                var url = attachment['url'];
                jQuery('#ik_logo_url').val(url);
                jQuery('#ik_logo_img').attr('src', url);
            });

            //Open the uploader dialog
            uploader.open();
        }
    </script>
    <?php
}
?>