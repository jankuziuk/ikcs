<?php
    $tmpPath = ikcs_views_path() . "/templates/";
?>

<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<div class="wrap ikcs ikcs-wrap" data-ng-app="ikcs">
    <div data-ng-controller="ikcsAddEditSection" class="ng-cloak" data-ng-cloak>
        <div class="main-header">
            <h1 class="wp-heading-inline">
                <span data-ng-if="ikcsAdd.id"><?php echo __( 'Edytuj sekcje', 'ikcs-trans' ); ?> </span>
                <span data-ng-if="!ikcsAdd.id"><?php echo __( 'Dodaj sekcje', 'ikcs-trans' ); ?> </span>
                <span data-ng-if="ikcsAdd.name != '' && ikcsAdd.name != ' '"> - "</span>{{ ikcsAdd.name }}<span data-ng-if="ikcsAdd.name != '' && ikcsAdd.name != ' '">"</span>
            </h1>
        </div>

        <div class="main-container">
            <form method="post" name="ikcs_new_section" id="ikcs_new_section" data-ng-submit="submit()">
                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="post-body-content" class="ikcs-card">
                            <div class="loader"
                                 data-ng-if="!pageLoadComplete"
                                 data-ng-include="'<?php echo $tmpPath; ?>preloader.html'">
                            </div>
                            <div data-ng-if="pageLoadComplete">
                                <div class="ikcs-card-head">
                                    <div class="form-group form-group-item">
                                        <label class="fg-label"><?php echo __( 'Wprowadż nazwę sekcji', 'ikcs-trans' ); ?></label>
                                        <input type="text" name="name" data-ng-model="ikcsAdd.name" class="form-control" autocomplete="off" />
                                    </div>
                                    <div class="form-group form-group-item">
                                        <label class="fg-label"><?php echo __( 'Wprowadż identyfikator sekcji', 'ikcs-trans' ); ?></label>
                                        <input type="text" name="section_id" data-ng-model="ikcsAdd.section_id" class="form-control" autocomplete="off" />
                                    </div>
                                </div>

                                <div class="ikcs-card-body ikcs-list-body">
                                    <div class="ikcs_items-header">
                                        <div class="ikcs_head ikcs-card-header ikcs-card-header-sort">
                                            <div>
                                                <div class="ikcs_head-sort">#</div>
                                                <div class="ikcs_head-name"><?php echo __( 'Nazwa pola', 'ikcs-trans' ); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="ikcs_items"
                                        data-ng-if="ikcsAdd.fields.length > 0"
                                        ui-sortable="sortableOptions"
                                        ng-model="ikcsAdd.fields"
                                        ng-init="parent = ikcsAdd"
                                    >
                                        <div
                                            class="ikcs_item ikcs-card"
                                            data-ng-repeat="item in ikcsAdd.fields"
                                            data-ng-include="'item_config.html'"
                                            data-as-sortable-item
                                        ></div>
                                    </div>
                                    <div class="add-new-item">
                                        <button type="button" class="ikcs-btn" data-ng-click="addNewSection()"><?php echo __( 'Dodaj nowe pole', 'ikcs-trans' ); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="postbox-container-1">
                            <div class="ikcs-card">
                                <div class="loader"
                                     data-ng-if="!pageLoadComplete"
                                     data-ng-include="'<?php echo ikcs_views_path(); ?>/templates/preloader.html'">
                                </div>
                                <div data-ng-if="pageLoadComplete">
                                    <div class="ikcs-card-body">
                                        <div class="ikcs-card-options" data-ng-if="ikcsAdd.other_info">
                                            <h5 class="ikcs-card-title"><?php echo __( 'Informacja podstawowa', 'ikcs-trans' ); ?></h5>
                                            <div class="options">
                                                <div class="options-item" data-ng-if="ikcsAdd.other_info.datetime_create">
                                                    <?php echo __( 'Data stworzenia:', 'ikcs-trans' ); ?> <b>{{ ikcsAdd.other_info.datetime_create }}</b>
                                                </div>
                                                <div class="options-item" data-ng-if="ikcsAdd.other_info.datetime_mod">
                                                    <?php echo __( 'Data ostatniej modyfikacji:', 'ikcs-trans' ); ?> <b>{{ ikcsAdd.other_info.datetime_mod }}</b>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ikcs-card-options">
                                            <h5 class="ikcs-card-title"><?php echo __( 'Ustawienia', 'ikcs-trans' ); ?></h5>
                                            <div class="options">
                                                <div class="options-item">
                                                    <label class="switch-item switch-inline">
                                                        <input type="checkbox" name="settings[show_select_bg]" data-ng-model="ikcsAdd.settings.show_select_bg" data-ng-true-value="1" data-ng-false-value="0" />
                                                        <span class="crs-icon"></span>
                                                        <span class="crs-text"><?php echo __( 'Pokazuj wybów tła', 'ikcs-trans' ); ?></span>
                                                    </label>
                                                </div>
                                                <div class="options-item">
                                                    <label class="switch-item switch-inline">
                                                        <input type="checkbox" name="settings[show_select_margin]" data-ng-model="ikcsAdd.settings.show_select_margin" data-ng-true-value="1" data-ng-false-value="0" />
                                                        <span class="crs-icon"></span>
                                                        <span class="crs-text"><?php echo __( 'Pokazuj wybów odstępów', 'ikcs-trans' ); ?></span>
                                                    </label>
                                                </div>
                                                <div class="options-item">
                                                    <label class="switch-item switch-inline">
                                                        <input type="checkbox" name="settings[show_custom_css]" data-ng-model="ikcsAdd.settings.show_custom_css" data-ng-true-value="1" data-ng-false-value="0" />
                                                        <span class="crs-icon"></span>
                                                        <span class="crs-text"><?php echo __( 'Pokazuj obszar dla własnego CSS', 'ikcs-trans' ); ?></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ikcs-card-footer">
                                        <button
                                            type="submit"
                                            class="ikcs-btn ikcs-btn-large ikcs-btn-block btn-loader-lg"
                                            data-ng-class="ikcsAddFormSaving ? 'btn-loader' : ''"
                                        >
                                            <span data-ng-if="ikcsAdd.id"><?php echo __( 'Zapisz zmiany', 'ikcs-trans' ); ?> </span>
                                            <span data-ng-if="!ikcsAdd.id"><?php echo __( 'Dodaj', 'ikcs-trans' ); ?> </span>
                                            <div class="loader"
                                                 data-ng-if="ikcsAddFormSaving"
                                                 data-ng-include="'<?php echo ikcs_views_path(); ?>/templates/preloader.html'">
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="ikcs-card" data-ng-show="ikcsAdd.settings.show_select_margin && pageLoadComplete">
                                <div class="margin">
                                    <div class="mp-inner-title"><?php echo __( 'Ustaw domyśne odstępy zewnętrzne:', 'ikcs-trans' ); ?></div>
                                    <div class="display-table">
                                        <div class="table-row">
                                            <div class="table-col mp-label">
                                                <label class="fg-label" for="m_top"><?php echo __( 'Górny:', 'ikcs-trans' ); ?></label>
                                            </div>
                                            <div class="table-col mp-input">
                                                <input type="number" class="form-control form-control-sm" id="m_top" data-ng-model="ikcsAdd.settings.margin.top" />
                                            </div>
                                            <div class="table-col mp-px">px</div>
                                        </div>
                                        <div class="table-row">
                                            <div class="table-col mp-label">
                                                <label class="fg-label" for="m_left"><?php echo __( 'Lewy:', 'ikcs-trans' ); ?></label>
                                            </div>
                                            <div class="table-col mp-input">
                                                <input type="number" class="form-control form-control-sm" id="m_left" data-ng-model="ikcsAdd.settings.margin.left" />
                                            </div>
                                            <div class="table-col mp-px">px</div>
                                        </div>
                                        <div class="table-row">
                                            <div class="table-col mp-label">
                                                <label class="fg-label" for="m_right"><?php echo __( 'Prawy:', 'ikcs-trans' ); ?></label>
                                            </div>
                                            <div class="table-col mp-input">
                                                <input type="number" class="form-control form-control-sm" id="m_right" data-ng-model="ikcsAdd.settings.margin.right" />
                                            </div>
                                            <div class="table-col mp-px">px</div>
                                        </div>
                                        <div class="table-row">
                                            <div class="table-col mp-label">
                                                <label class="fg-label" for="m_bottom"><?php echo __( 'Dolny:', 'ikcs-trans' ); ?></label>
                                            </div>
                                            <div class="table-col mp-input">
                                                <input type="number" class="form-control form-control-sm" id="m_bottom" data-ng-model="ikcsAdd.settings.margin.bottom" />
                                            </div>
                                            <div class="table-col mp-px">px</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="padding">
                                    <div class="mp-inner-title"><?php echo __( 'Ustaw domyśne odstępy wewnętrzne:', 'ikcs-trans' ); ?></div>
                                    <div class="display-table">
                                        <div class="table-row">
                                            <div class="table-col mp-label">
                                                <label class="fg-label" for="p_top"><?php echo __( 'Górny:', 'ikcs-trans' ); ?></label>
                                            </div>
                                            <div class="table-col mp-input">
                                                <input type="number" class="form-control form-control-sm" id="p_top" data-ng-model="ikcsAdd.settings.padding.top" />
                                            </div>
                                            <div class="table-col mp-px">px</div>
                                        </div>
                                        <div class="table-row">
                                            <div class="table-col mp-label">
                                                <label class="fg-label" for="p_left"><?php echo __( 'Lewy:', 'ikcs-trans' ); ?></label>
                                            </div>
                                            <div class="table-col mp-input">
                                                <input type="number" class="form-control form-control-sm" id="p_left" data-ng-model="ikcsAdd.settings.padding.left" />
                                            </div>
                                            <div class="table-col mp-px">px</div>
                                        </div>
                                        <div class="table-row">
                                            <div class="table-col mp-label">
                                                <label class="fg-label" for="p_right"><?php echo __( 'Prawy:', 'ikcs-trans' ); ?></label>
                                            </div>
                                            <div class="table-col mp-input">
                                                <input type="number" class="form-control form-control-sm" id="p_right" data-ng-model="ikcsAdd.settings.padding.right" />
                                            </div>
                                            <div class="table-col mp-px">px</div>
                                        </div>
                                        <div class="table-row">
                                            <div class="table-col mp-label">
                                                <label class="fg-label" for="p_bottom"><?php echo __( 'Dolny:', 'ikcs-trans' ); ?></label>
                                            </div>
                                            <div class="table-col mp-input">
                                                <input type="number" class="form-control form-control-sm" id="p_bottom" data-ng-model="ikcsAdd.settings.padding.bottom" />
                                            </div>
                                            <div class="table-col mp-px">px</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>

                <script type="text/ng-template" id="item_config.html">
                    <div class="ikcs_head ikcs-card-header ikcs-card-header-sort">
                        <div>
                            <div class="ikcs_head-sort">#{{ $index+1 }}</div>
                            <div class="ikcs_head-name" data-ng-if="item.label != '' || item.label != ' '">{{ item.label }}</div>
                            <div class="ikcs_head-name" data-ng-if="item.label == '' || item.label == ' '">---</div>
                        </div>

                        <ul class="actions">
                            <li data-ng-click="removeSubItem(parent, $index)"><i class="wp-menu-image dashicons-before dashicons-trash"></i></li>
                            <li data-ng-click="item.open = !item.open">
                                <i class="wp-menu-image dashicons-before dashicons-arrow-up" data-ng-if="item.open"></i>
                                <i class="wp-menu-image dashicons-before dashicons-arrow-down" data-ng-if="!item.open"></i>
                            </li>
                        </ul>
                    </div>

                    <div class="ikcs_body" data-ng-show="item.open">

                        <div class="form-wrapper">
                            <div class="form-item">
                                <div class="form-group">
                                    <label class="fg-label"><?php echo __( 'Wprowadż nazwę pola', 'ikcs-trans' ); ?></label>
                                    <input
                                        type="text"
                                        data-ng-model="item.label"
                                        class="form-control form-control-sm"
                                    />
                                </div>
                            </div>

                            <div class="form-item">
                                <div class="form-group">
                                    <label class="fg-label"><?php echo __( 'Wprowadż identyfikator pola', 'ikcs-trans' ); ?></label>
                                    <input
                                        type="text"
                                        data-ng-model="item.id"
                                        class="form-control form-control-sm"
                                    />
                                </div>
                            </div>

                            <div class="form-item">
                                <div class="form-group">
                                    <label class="fg-label"><?php echo __( 'Rodzaj pola', 'ikcs-trans' ); ?></label>
                                    <select data-ng-model="item.type" class="form-control form-control-sm">
                                        <option value="text">Text</option>
                                        <option value="tel">Telefon</option>
                                        <option value="email">Email</option>
                                        <option value="number">Liczba</option>
                                        <option value="link">Link</option>
                                        <option value="textarea">Duży obszar tekstowy (Textarea)</option>
                                        <option value="image">Obrazek</option>
                                        <option value="colorpicker">Wybór koloru (Color picker)</option>
                                        <option value="select">Lista wyboró (Select)</option>
                                        <option value="checkbox">Akceptowanie (Checkbox)</option>
                                        <option value="radio">Pole wyboru (Radio)</option>
                                        <option value="trueorfalse">Tak lub nie (true/false)</option>
                                        <option value="fa">Font Awesome</option>
                                        <option value="repeater_object">Objekt pul</option>
                                    </select>
                                </div>
                            </div>

                            <div class="textarea-fields" data-ng-if="item.type == 'textarea'">
                                <div class="form-item">
                                    <div class="form-group">
                                        <label class="fg-label"><?php echo __( 'Ilość wierszy', 'ikcs-trans' ); ?></label>
                                        <input type="number" data-ng-model="item.textarea_rows" class="form-control form-control-sm" autocomplete="off" />
                                    </div>
                                </div>
                            </div>

                            <div class="repeater" data-ng-if="item.type == 'repeater_object'">
                                <div class="ikcs_items-header">
                                    <div class="ikcs_head ikcs-card-header ikcs-card-header-sort">
                                        <div>
                                            <div class="ikcs_head-sort">#</div>
                                            <div class="ikcs_head-name"><?php echo __( 'Nazwa pola', 'ikcs-trans' ); ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="ikcs_repeater_items"
                                    ui-sortable="sortableOptions"
                                    ng-init="parent = item"
                                >
                                    <div
                                        data-ng-repeat="item in item.repeater_fields"
                                        data-ng-include="'item_config.html'"
                                        data-as-sortable-item
                                    ></div>
                                </div>
                                <div class="add-new-item">
                                    <button type="button" class="ikcs-btn" data-ng-click="addNewSubSection(item)"><?php echo __( 'Dodaj nowe pole', 'ikcs-trans' ); ?></button>
                                </div>
                            </div>

                            <div class="form-item">
                                <div class="radio-label fg-label"><?php echo __('Czy to pole jest wymagane ?', 'ikcs-trans' ); ?></div>
                                <div>
                                    <label class="radio-item radio-inline">
                                        <input
                                            type="radio"
                                            name="fields[{{itemIndex}}][{{item.id}}][required]"
                                            data-ng-model="item.required"
                                            value="on"
                                        />
                                        <span class="crs-icon"></span>
                                        <span class="crs-text"><?php echo __( 'Tak', 'ikcs-trans' ); ?></span>
                                    </label>
                                    <label class="radio-item radio-inline">
                                        <input
                                            type="radio"
                                            name="fields[{{itemIndex}}][{{item.id}}][required]"
                                            data-ng-model="item.required"
                                            value="off"
                                        />
                                        <span class="crs-icon"></span>
                                        <span class="crs-text"><?php echo __( 'Nie', 'ikcs-trans' ); ?></span>
                                    </label>
                                </div>
                            </div>

                            <!-- Ustawienia dla koloru -->
                            <div data-ng-if="item.type == 'colorpicker'">
                                <div class="form-item">
                                    <input
                                        type="text"
                                        class="form-control form-control-sm color_picker"
                                        data-ng-model="item.value"
                                    />
                                </div>
                            </div>

                            <!-- Ustawienia dla obrazków -->
                            <div data-ng-if="item.type == 'image'">
                                <div class="form-item">
                                    <label class="fg-label"><?php echo __( 'Wybierz rozmiar obrazków', 'ikcs-trans' ); ?></label>
                                    <select data-ng-model="item.image_size" class="form-control form-control-sm">
                                        <option value="full"><?php echo __( 'Pełny rozmiar', 'ikcs-trans' ); ?></option>
                                        <option value="{{ name }}" data-ng-repeat="(name, options) in imageSizes">{{ name }} ({{options.width}}x{{options.height}})</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Dodnie elementów dla checkbox i radio -->
                            <div class="checkbox_radio-fields" data-ng-if="item.type == 'checkbox' || item.type == 'radio' || item.type == 'select'">
                                <div class="form-item">
                                    <div class="mp-inner-title"><?php echo __( 'Opcje', 'ikcs-trans' ); ?></div>
                                    <div class="display-table no-bg small-table">
                                        <div class="table-row" data-ng-init="parent = item.field_options" data-ng-repeat="option in item.field_options">
                                            <div class="table-col pd-right-only table-checkbox-default" data-ng-if="item.type == 'checkbox'">
                                                <div class="form-group">
                                                    <label class="fg-label">&nbsp;</label>
                                                    <div>
                                                        <label class="checkbox-item">
                                                            <input
                                                                type="checkbox"
                                                                data-ng-model="option.checked"
                                                                data-ng-init="option.checked ? option.checked : option.checked = false"
                                                                data-ng-true-value="true"
                                                                data-ng-false-value="false"
                                                            />
                                                            <span class="crs-icon"></span>
                                                            <span class="crs-text"><?php echo __( 'Zaznać domyślnie', 'ikcs-trans' ); ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-col pd-right-only">
                                                <div class="form-group">
                                                    <label class="fg-label"><?php echo __( 'Wartość', 'ikcs-trans' ); ?></label>
                                                    <input
                                                        type="text"
                                                        data-ng-model="option.value"
                                                        class="form-control form-control-sm"
                                                    />
                                                </div>
                                            </div>
                                            <div class="table-col pd-left-only">
                                                <div class="form-group">
                                                    <label class="fg-label"><?php echo __( 'Etyketa', 'ikcs-trans' ); ?></label>
                                                    <input
                                                        type="text"
                                                        data-ng-model="option.label"
                                                        class="form-control form-control-sm"
                                                    />
                                                </div>
                                            </div>
                                            <div class="table-col table-col-trash pd-left-only pd-right-only">
                                                <label class="fg-label">&nbsp;</label>
                                                <div>
                                                    <button
                                                        type="button"
                                                        data-ng-click="removeOptionItem(parent, $index)"
                                                        class="ikcs-btn ikcs-btn-dash ikcs-btn-trash"
                                                        data-balloon="<?php echo __( 'Usuń', 'ikcs-trans' ); ?>"
                                                        data-balloon-pos="down"
                                                    >
                                                        <i class="dashicons dashicons-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="add-checkbox_radio">
                                        <button
                                            type="button"
                                            class="ikcs-btn"
                                            data-ng-click="addOptionItem(item)">
                                            <?php echo __( 'Dodaj element', 'ikcs-trans' ); ?>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-item" data-ng-if="item.type == 'trueorfalse'">
                                <div class="form-group">
                                    <label class="fg-label"><?php echo __( 'Etykieta', 'ikcs-trans' ); ?></label>
                                    <input
                                        type="text"
                                        data-ng-model="item.trueorfalse_label"
                                        data-ng-init="item.trueorfalse_label ? item.trueorfalse_label : item.trueorfalse_label = '<?php echo __( 'Włącz/wyłąć', 'ikcs-trans' ); ?>'"
                                        class="form-control form-control-sm"
                                    />
                                </div>
                            </div>

                            <div class="form-item" data-ng-if="item.type == 'trueorfalse'">
                                <label class="switch-item switch-inline">
                                    <input
                                        type="checkbox"
                                        data-ng-model="item.field_option_checked"
                                        data-ng-init="item.field_option_checked ? item.field_option_checked : item.field_option_checked = false"
                                        data-ng-true-value="true"
                                        data-ng-false-value="false"
                                    />
                                    <span class="crs-icon"></span>
                                    <span class="crs-text"><?php echo __( 'Włącz/wyłąć domyślnie', 'ikcs-trans' ); ?></span>
                                </label>
                            </div>

                            <div class="form-item" data-ng-if="item.type == 'text' && item.type == 'tel' && item.type == 'email' && item.type == 'number'">
                                <div class="form-group">
                                    <label class="fg-label"><?php echo __( 'Domyślna wartość pola', 'ikcs-trans' ); ?></label>
                                    <input
                                        type="text"
                                        data-ng-model="item.value"
                                        class="form-control form-control-sm"
                                    />
                                </div>
                            </div>

                            <div class="form-item" data-ng-if="item.type == 'radio' && item.field_options && item.field_options.length>0" >
                                <div class="form-group">
                                    <label class="fg-label"><?php echo __( 'Domyślna wartość', 'ikcs-trans' ); ?></label>
                                    <select data-ng-model="item.field_option_checked" class="form-control form-control-sm">
                                        <option
                                            value="{{ default_item.value }}"
                                            ng-repeat="default_item in item.field_options"
                                        >
                                            {{ default_item.label }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-item" data-ng-if="item.type == 'text' || item.type == 'textarea' || item.type == 'number'">
                                <div class="form-group">
                                    <label class="fg-label"><?php echo __( 'Minimalna ilość znaków', 'ikcs-trans' ); ?></label>
                                    <input
                                        type="number"
                                        min="0"
                                        data-ng-model="item.min_length"
                                        class="form-control form-control-sm"
                                    />
                                </div>
                            </div>

                            <div class="form-item" data-ng-if="item.type == 'text' || item.type == 'textarea' || item.type == 'number'">
                                <div class="form-group">
                                    <label class="fg-label"><?php echo __( 'Maksymalna ilość znaków', 'ikcs-trans' ); ?></label>
                                    <input
                                        type="number"
                                        min="0"
                                        data-ng-model="item.max_length"
                                        class="form-control form-control-sm"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </script>
            </form>
        </div>
    </div>

    <script>
        var imageSizes = <?php echo json_encode(get_image_sizes()); ?>;
    </script>

</div>