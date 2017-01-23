<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<div class="wrap" data-ng-app="ikcs">
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
                                 data-ng-include="'<?php echo ikcs_views_path(); ?>/templates/preloader.html'">
                            </div>
                            <div data-ng-if="pageLoadComplete">
                                <div class="ikcs-card-head">
                                    <div class="form-group">
                                        <label class="fg-label"><?php echo __( 'Wprowadż nazwę pola', 'ikcs-trans' ); ?></label>
                                        <input type="text" name="name" data-ng-model="ikcsAdd.name" class="form-control" autocomplete="off" />
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
                                    <div class="ikcs_items" data-ng-if="ikcsAdd.fields.length > 0" ui-sortable="sortableOptions" ng-model="ikcsAdd.fields">
                                        <div class="ikcs_item ikcs-card" data-ng-repeat="item in ikcsAdd.fields" data-as-sortable-item>

                                            <div class="ikcs_head ikcs-card-header ikcs-card-header-sort">
                                                <div>
                                                    <div class="ikcs_head-sort">#{{ $index+1 }}</div>
                                                    <div class="ikcs_head-name" data-ng-if="item.label != '' || item.label != ' '">{{ item.label }}</div>
                                                    <div class="ikcs_head-name" data-ng-if="item.label == '' || item.label == ' '">---</div>
                                                </div>

                                                <ul class="actions">
                                                    <li data-ng-click="removeItem($index)"><i class="wp-menu-image dashicons-before dashicons-trash"></i></li>
                                                    <li data-ng-click="triggerShowItem($index, item.options.open)">
                                                        <i class="wp-menu-image dashicons-before dashicons-arrow-up" data-ng-if="item.options.open == 1"></i>
                                                        <i class="wp-menu-image dashicons-before dashicons-arrow-down" data-ng-if="item.options.open == 0"></i>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="ikcs_body" data-ng-show="item.options.open == 1">

                                                <div class="form-wrapper">
                                                    <div class="form-item">
                                                        <div class="form-group">
                                                            <label class="fg-label"><?php echo __( 'Wprowadż nazwę pola', 'ikcs-trans' ); ?></label>
                                                            <input type="text" data-ng-model="item.label" class="form-control form-control-sm" autocomplete="off" />
                                                        </div>
                                                    </div>

                                                    <div class="form-item">
                                                        <div class="form-group">
                                                            <label class="fg-label"><?php echo __( 'Wprowadż identyfikator pola', 'ikcs-trans' ); ?></label>
                                                            <input type="text" data-ng-model="item.id" class="form-control form-control-sm" autocomplete="off" />
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
                                                                <option value="textarea">Duży obszar tekstowy</option>
                                                                <option value="cheskbox">Checkbox</option>
                                                                <option value="radio">Radio</option>
                                                                <option value="link">Link</option>
                                                                <option value="fa">Font Awesome</option>
                                                                <option value="repeater_object">Objekt pul</option>
                                                            </select>
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
                                                        <div class="ikcs_repeater_items" ui-sortable="sortableOptions">
                                                            <div data-ng-repeat="subitem in item.repeater_fields" data-as-sortable-item>

                                                                <div class="ikcs_head ikcs-card-header ikcs-card-header-sort repeater-header">
                                                                    <div>
                                                                        <div class="ikcs_head-sort">#{{ $index+1 }}</div>
                                                                        <div class="ikcs_head-name" data-ng-if="subitem.label != '' || subitem.label != ' '">{{ subitem.label }}</div>
                                                                        <div class="ikcs_head-name" data-ng-if="subitem.label == '' || subitem.label == ' '">---</div>
                                                                    </div>

                                                                    <ul class="actions">
                                                                        <li data-ng-click="removeSubItem($parent.$index, $index)"><i class="wp-menu-image dashicons-before dashicons-trash"></i></li>
                                                                        <li data-ng-click="triggerShowSubItem($parent.$index, $index, subitem.options.open)">
                                                                            <i class="wp-menu-image dashicons-before dashicons-arrow-up" data-ng-if="subitem.options.open == 1"></i>
                                                                            <i class="wp-menu-image dashicons-before dashicons-arrow-down" data-ng-if="subitem.options.open == 0"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <div class="ikcs_body" data-ng-show="subitem.options.open == 1">

                                                                    <div class="form-wrapper">
                                                                        <div class="form-item">
                                                                            <div class="form-group">
                                                                                <label class="fg-label"><?php echo __( 'Wprowadż nazwę pola', 'ikcs-trans' ); ?></label>
                                                                                <input type="text" data-ng-model="subitem.label" class="form-control form-control-sm" autocomplete="off" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-item">
                                                                            <div class="form-group">
                                                                                <label class="fg-label"><?php echo __( 'Wprowadż identyfikator pola', 'ikcs-trans' ); ?></label>
                                                                                <input type="text" data-ng-model="subitem.id" class="form-control form-control-sm" autocomplete="off" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-item">
                                                                            <div class="form-group">
                                                                                <label class="fg-label"><?php echo __( 'Rodzaj pola', 'ikcs-trans' ); ?></label>
                                                                                <select data-ng-model="subitem.type" class="form-control form-control-sm">
                                                                                    <option value="text">Text</option>
                                                                                    <option value="tel">Telefon</option>
                                                                                    <option value="email">Email</option>
                                                                                    <option value="number">Liczba</option>
                                                                                    <option value="textarea">Duży obszar tekstowy</option>
                                                                                    <option value="cheskbox">Checkbox</option>
                                                                                    <option value="radio">Radio</option>
                                                                                    <option value="link">Link</option>
                                                                                    <option value="fa">Font Awesome</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-item">
                                                                            <div class="radio-label fg-label"><?php echo __('Czy to pole jest wymagane ?', 'ikcs-trans' ); ?></div>
                                                                            <div>
                                                                                <label class="radio-item radio-inline">
                                                                                    <input type="radio" name="fields[options][required]" data-ng-model="subitem.options.required" value="on" />
                                                                                    <span class="crs-icon"></span>
                                                                                    <span class="crs-text"><?php echo __( 'Tak', 'ikcs-trans' ); ?></span>
                                                                                </label>
                                                                                <label class="radio-item radio-inline">
                                                                                    <input type="radio" name="fields[options][required]" data-ng-model="subitem.options.required" value="off" />
                                                                                    <span class="crs-icon"></span>
                                                                                    <span class="crs-text"><?php echo __( 'Nie', 'ikcs-trans' ); ?></span>
                                                                                </label>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-item">
                                                                            <div class="form-group">
                                                                                <label class="fg-label"><?php echo __( 'Domyślna wartość pola', 'ikcs-trans' ); ?></label>
                                                                                <input type="text" data-ng-model="subitem.default_value" class="form-control form-control-sm" autocomplete="off" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-item">
                                                                            <div class="form-group">
                                                                                <label class="fg-label"><?php echo __( 'Minimalna ilość znaków', 'ikcs-trans' ); ?></label>
                                                                                <input type="number" min="0" data-ng-model="subitem.options.min_length" class="form-control form-control-sm" autocomplete="off" />
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-item">
                                                                            <div class="form-group">
                                                                                <label class="fg-label"><?php echo __( 'Maksymalna ilość znaków', 'ikcs-trans' ); ?></label>
                                                                                <input type="number" min="0" data-ng-model="subitem.options.max_length" class="form-control form-control-sm" autocomplete="off" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="add-new-item">
                                                            <button type="button" class="ikcs-btn" data-ng-click="addNewSubSection($index)"><?php echo __( 'Dodaj nowe pole', 'ikcs-trans' ); ?></button>
                                                        </div>
                                                    </div>

                                                    <div class="form-item">
                                                        <div class="radio-label fg-label"><?php echo __('Czy to pole jest wymagane ?', 'ikcs-trans' ); ?></div>
                                                        <div>
                                                            <label class="radio-item radio-inline">
                                                                <input type="radio" name="fields[options][required]" data-ng-model="item.options.required" value="on" />
                                                                <span class="crs-icon"></span>
                                                                <span class="crs-text"><?php echo __( 'Tak', 'ikcs-trans' ); ?></span>
                                                            </label>
                                                            <label class="radio-item radio-inline">
                                                                <input type="radio" name="fields[options][required]" data-ng-model="item.options.required" value="off" />
                                                                <span class="crs-icon"></span>
                                                                <span class="crs-text"><?php echo __( 'Nie', 'ikcs-trans' ); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-item">
                                                        <div class="form-group">
                                                            <label class="fg-label"><?php echo __( 'Domyślna wartość pola', 'ikcs-trans' ); ?></label>
                                                            <input type="text" data-ng-model="item.default_value" class="form-control form-control-sm" autocomplete="off" />
                                                        </div>
                                                    </div>

                                                    <div class="form-item">
                                                        <div class="form-group">
                                                            <label class="fg-label"><?php echo __( 'Minimalna ilość znaków', 'ikcs-trans' ); ?></label>
                                                            <input type="number" min="0" data-ng-model="item.options.min_length" class="form-control form-control-sm" autocomplete="off" />
                                                        </div>
                                                    </div>

                                                    <div class="form-item">
                                                        <div class="form-group">
                                                            <label class="fg-label"><?php echo __( 'Maksymalna ilość znaków', 'ikcs-trans' ); ?></label>
                                                            <input type="number" min="0" data-ng-model="item.options.max_length" class="form-control form-control-sm" autocomplete="off" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
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
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </form>
        </div>
    </div>
</div>