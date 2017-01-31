<?php
    $tmpPath = ikcs_views_path() . "/templates/";
?>

<div data-ng-app="ikcs" class="ikcs">
    <div data-ng-controller="ikcsPageRendering" class="ng-cloak" data-ng-cloak>
        <div class="ikcs-page">
<!--            wp_get_attachment_image_src( $attachment_id = 19, $size = 'full')-->
            <div class="sections-list" ui-sortable="sortableOptions">
                <div class="section-item" data-ng-repeat="(itemIndex, item) in existingSections" data-as-sortable-item>
                    <div class="mp-area display-table">
                        <div class="table-row">
                            <div class="table-col background v-top" data-ng-if="item.settings.show_select_bg">
                                <div class="mp-inner-title"><?php echo __( 'Ustał tło:', 'ikcs-trans' ); ?></div>
                                <div class="mp-inner-bg">
                                    <div class="mp-bg-type">
                                        <div class="form-group">
                                            <label class="fg-label"><?php echo __( 'Wybierz rodzaj tła', 'ikcs-trans' ); ?></label>
                                            <select
                                                data-ng-model="item.settings.bg_type"
                                                data-ng-change="initColorPicker(item.settings.bg_type, $index)"
                                                class="form-control form-control-sm"
                                            >
                                                <option value="" disabled="disabled"><?php echo __( 'Wybierz typ tła', 'ikcs-trans' ); ?></option>
                                                <option value="image"><?php echo __( 'Obrazek', 'ikcs-trans' ); ?></option>
                                                <option value="color"><?php echo __( 'Kolor', 'ikcs-trans' ); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mp-image" data-ng-if="item.settings.bg_type == 'image'">
                                        <div class="image-view without-pd">
                                            <div class="image-view-panel">
                                                <div class="image-view-label"><?php echo __( 'Wybierz obrzek', 'ikcs-trans' ); ?></div>
                                                <div data-ng-show="item.settings.bg_img_url != ''" class="image-view-actions">
                                                    <button
                                                        type="button"
                                                        data-ng-click="remove_image($index)"
                                                        class="ikcs-btn ikcs-btn-dash ikcs-btn-trash"
                                                        data-balloon="<?php echo __( 'Usuń obrazek', 'ikcs-trans' ); ?>"
                                                        data-balloon-pos="down"
                                                    >
                                                        <i class="dashicons dashicons-trash"></i>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        data-ng-click="upload_image($index)"
                                                        class="ikcs-btn ikcs-btn-dash"
                                                        data-balloon="<?php echo __( 'Edytuj obrazek', 'ikcs-trans' ); ?>"
                                                        data-balloon-pos="down"
                                                    >
                                                        <i class="dashicons dashicons-edit"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="no-image-view" data-ng-show="item.settings.bg_img_url == ''">
                                                <i class="dashicons dashicons-format-image"></i>
                                            </div>
                                            <div class="image-preview" data-ng-show="item.settings.bg_img_url != ''">
                                                <img data-ng-src="{{ item.settings.bg_img_url }}" data-ng-model="item.settings.bg_img_url" alt="" />
                                            </div>
                                        </div>
                                        <input type="hidden" data-ng-model="item.settings.bg_img_id">
                                        <button
                                            type="button"
                                            class="ikcs-btn ikcs-btn-block"
                                            data-ng-show="item.settings.bg_img_url == ''"
                                            data-ng-click="upload_image($index)">
                                            <?php echo __( 'Dodaj obrazek', 'ikcs-trans' ); ?>
                                        </button>
                                        <div class="image-view without-pd" data-ng-show="item.settings.bg_img_url != ''">
                                            <div class="image-view-panel">
                                                <div class="image-view-label"><?php echo __( 'Ustawienia tła', 'ikcs-trans' ); ?></div>
                                            </div>
                                            <div class="display-table">
                                                <div class="table-row">
                                                    <div class="table-col bg-label">
                                                        <label class="fg-label"><?php echo __( 'W pionie:', 'ikcs-trans' ); ?></label>
                                                    </div>
                                                    <div class="table-col bg-input">
                                                        <select data-ng-model="item.settings.bg_pos_ver" class="form-control form-control-sm">
                                                            <option value="center" selected="selected"><?php echo __( 'Wyśrodkować', 'ikcs-trans' ); ?></option>
                                                            <option value="top"><?php echo __( 'W góre', 'ikcs-trans' ); ?></option>
                                                            <option value="bottom"><?php echo __( 'W doł', 'ikcs-trans' ); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="table-row">
                                                    <div class="table-col bg-label">
                                                        <label class="fg-label"><?php echo __( 'W poziomie:', 'ikcs-trans' ); ?></label>
                                                    </div>
                                                    <div class="table-col bg-input">
                                                        <select data-ng-model="item.settings.bg_pos_hor" class="form-control form-control-sm">
                                                            <option value="center" selected="selected"><?php echo __( 'Wyśrodkować', 'ikcs-trans' ); ?></option>
                                                            <option value="left"><?php echo __( 'Do lewej', 'ikcs-trans' ); ?></option>
                                                            <option value="right"><?php echo __( 'Do prawej', 'ikcs-trans' ); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="table-row">
                                                    <div class="table-col bg-label">
                                                        <label class="fg-label"><?php echo __( 'Skalowanie:', 'ikcs-trans' ); ?></label>
                                                    </div>
                                                    <div class="table-col bg-input">
                                                        <select data-ng-model="item.settings.bg_size" class="form-control form-control-sm">
                                                            <option value="repeat" selected="selected"><?php echo __( 'Repeat', 'ikcs-trans' ); ?></option>
                                                            <option value="no-repeat"><?php echo __( 'No repeat', 'ikcs-trans' ); ?></option>
                                                            <option value="cover"><?php echo __( 'Cover', 'ikcs-trans' ); ?></option>
                                                            <option value="contain"><?php echo __( 'Contain', 'ikcs-trans' ); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="colorpicker" data-ng-show="item.settings.bg_type == 'color'">
                                        <input type="text" name="bg_color_{{ $index }}" id="bg_color_{{ $index }}" class="form-control form-control-sm" data-ng-model="item.settings.bg_color" />
                                    </div>
                                </div>
                            </div>
                            <div class="table-col margin v-top" data-ng-if="item.settings.show_select_margin">
                                <div class="mp-inner-title"><?php echo __( 'Odstępy zewnętrzne:', 'ikcs-trans' ); ?></div>
                                <div class="display-table">
                                    <div class="table-row">
                                        <div class="table-col mp-label">
                                            <label class="fg-label" for="m_top"><?php echo __( 'Górny:', 'ikcs-trans' ); ?></label>
                                        </div>
                                        <div class="table-col mp-input">
                                            <input type="number" min="0" class="form-control form-control-sm" id="m_top" data-ng-model="item.settings.margin.top" />
                                        </div>
                                        <div class="table-col mp-px">px</div>
                                    </div>
                                    <div class="table-row">
                                        <div class="table-col mp-label">
                                            <label class="fg-label" for="m_left"><?php echo __( 'Lewy:', 'ikcs-trans' ); ?></label>
                                        </div>
                                        <div class="table-col mp-input">
                                            <input type="number" min="0" class="form-control form-control-sm" id="m_left" data-ng-model="item.settings.margin.left" />
                                        </div>
                                        <div class="table-col mp-px">px</div>
                                    </div>
                                    <div class="table-row">
                                        <div class="table-col mp-label">
                                            <label class="fg-label" for="m_right"><?php echo __( 'Prawy:', 'ikcs-trans' ); ?></label>
                                        </div>
                                        <div class="table-col mp-input">
                                            <input type="number" min="0" class="form-control form-control-sm" id="m_right" data-ng-model="item.settings.margin.right" />
                                        </div>
                                        <div class="table-col mp-px">px</div>
                                    </div>
                                    <div class="table-row">
                                        <div class="table-col mp-label">
                                            <label class="fg-label" for="m_bottom"><?php echo __( 'Dolny:', 'ikcs-trans' ); ?></label>
                                        </div>
                                        <div class="table-col mp-input">
                                            <input type="number" min="0" class="form-control form-control-sm" id="m_bottom" data-ng-model="item.settings.margin.bottom" />
                                        </div>
                                        <div class="table-col mp-px">px</div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-col padding v-top" data-ng-if="item.settings.show_select_margin">
                                <div class="mp-inner-title"><?php echo __( 'Odstępy wewnętrzne:', 'ikcs-trans' ); ?></div>
                                <div class="display-table">
                                    <div class="table-row">
                                        <div class="table-col mp-label">
                                            <label class="fg-label" for="p_top"><?php echo __( 'Górny:', 'ikcs-trans' ); ?></label>
                                        </div>
                                        <div class="table-col mp-input">
                                            <input type="number" min="0" class="form-control form-control-sm" id="p_top" data-ng-model="item.settings.padding.top" />
                                        </div>
                                        <div class="table-col mp-px">px</div>
                                    </div>
                                    <div class="table-row">
                                        <div class="table-col mp-label">
                                            <label class="fg-label" for="p_left"><?php echo __( 'Lewy:', 'ikcs-trans' ); ?></label>
                                        </div>
                                        <div class="table-col mp-input">
                                            <input type="number" min="0" class="form-control form-control-sm" id="p_left" data-ng-model="item.settings.padding.left" />
                                        </div>
                                        <div class="table-col mp-px">px</div>
                                    </div>
                                    <div class="table-row">
                                        <div class="table-col mp-label">
                                            <label class="fg-label" for="p_right"><?php echo __( 'Prawy:', 'ikcs-trans' ); ?></label>
                                        </div>
                                        <div class="table-col mp-input">
                                            <input type="number" min="0" class="form-control form-control-sm" id="p_right" data-ng-model="item.settings.padding.right" />
                                        </div>
                                        <div class="table-col mp-px">px</div>
                                    </div>
                                    <div class="table-row">
                                        <div class="table-col mp-label">
                                            <label class="fg-label" for="p_bottom"><?php echo __( 'Dolny:', 'ikcs-trans' ); ?></label>
                                        </div>
                                        <div class="table-col mp-input">
                                            <input type="number" min="0" class="form-control form-control-sm" id="p_bottom" data-ng-model="item.settings.padding.bottom" />
                                        </div>
                                        <div class="table-col mp-px">px</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-fields">
                        <div class="mp-inner-title">Zdefiniowane pola</div>
                        <div
                            class="display-table"
                            ng-init="parent = item"
                        >
                            <div
                                class="table-row fielsd_type_{{ field.type }}"
                                data-ng-repeat="(fieldIndex, field) in item.fields"
                                data-ng-include="'item.html'"
                            >

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="add-new-item">
                <div class="add-from-sections-list">
                    <div class="add-from-sections-list-popup hidden" id="selectListOfSections">
                        <div class="section-list-title"><?php echo __( 'Wybierz', 'ikcs-trans' ); ?></div>
                        <div class="section-list-inner">
                            <div class="add-from-section" data-ng-repeat="item in ikcsSections" data-ng-click="addNewSection(item.id)">
                                <div class="ikcs-menu-image dashicons-before dashicons-grid-view"></div>
                                <div class="ikcs-menu-name">{{ item.section_name }}</div>
                            </div>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="ikcs-btn ikcs-btn-add-new"
                        data-show-popup="#selectListOfSections"
                        data-item-class=".add-from-section"
                        data-ng-class="addNewSectionBefore ? 'btn-loader' : ''"
                    >
                        <div class="loader"
                             data-ng-show="addNewSectionBefore"
                             data-ng-include="'<?php echo $tmpPath; ?>preloader.html'">
                        </div>
                        <?php echo __( 'Dodaj nową sekcje', 'ikcs-trans' ); ?>
                    </button>
                </div>
                <div class="clear"></div>
            </div>
            <button
                type="button"
                class="ikcs-btn ikcs-btn-add-new"
                data-ng-click="showData()"
            >
                <?php echo __( 'Show data', 'ikcs-trans' ); ?>
            </button>

            <script type="text/ng-template" id="item.html">
                <div class="table-col table-fields-label">
                    <label class="fg-label" ng-if="field.type != 'repeater_object'" for="field_{{ item.id }}_{{ field.id }}">{{ field.label }}</label>
                </div>
                <div class="table-col">

                    <div data-ng-if="field.type == 'text' || field.type == 'tel' || field.type == 'email' || field.type == 'number'" data-ng-include="'<?php echo $tmpPath; ?>input.html'"></div>
                    <div data-ng-if="field.type == 'link'" data-ng-include="'<?php echo $tmpPath; ?>link.html'"></div>
                    <div data-ng-if="field.type == 'textarea'" data-ng-include="'<?php echo $tmpPath; ?>textarea.html'"></div>
                    <div data-ng-if="field.type == 'checkbox'" data-ng-include="'<?php echo $tmpPath; ?>checkbox.html'"></div>
                    <div data-ng-if="field.type == 'radio'" data-ng-include="'<?php echo $tmpPath; ?>radio.html'"></div>
                    <div data-ng-if="field.type == 'trueorfalse'" data-ng-include="'<?php echo $tmpPath; ?>trueorfalse.html'"></div>
                    <div data-ng-if="field.type == 'fa'" data-ng-include="'<?php echo $tmpPath; ?>fa.html'"></div>

                    <div ng-if="field.type == 'repeater_object'" class="repeater-items">
                        <div class="mp-inner-title">
                            {{ field.label }}
                        </div>
                        <div ui-sortable="sortableOptions">
                            <div class="repeater"
                                 data-ng-init="parent = field.repeater_items"
                                 data-ng-repeat="r_items in field.repeater_items"
                            >
                                <div class="counter"><span>{{ $index + 1 }}</span></div>
                                <div class="display-table">
                                    <div class="table-row fielsd_type_{{ field.type }}"
                                         data-ng-repeat="field in r_items"
                                         data-ng-include="'item.html'"
                                         data-as-sortable-item
                                    >
                                    </div>
                                </div>
                                <div class="remove-repeater-item">
                                    <button
                                        type="button"
                                        data-ng-click="removeItem(parent, $index)"
                                        class="ikcs-btn ikcs-btn-dash ikcs-btn-trash"
                                        data-balloon="<?php echo __( 'Usuń', 'ikcs-trans' ); ?>"
                                        data-balloon-pos="down"
                                    >
                                        <i class="dashicons dashicons-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="add-new-item">
                            <button
                                type="button"
                                class="ikcs-btn ikcs-btn-dash"
                                data-ng-click="addRepeaterItem(field)"
                                data-balloon="<?php echo __( 'Dodaj element do: ', 'ikcs-trans' ); ?> '{{ field.label }}'"
                                data-balloon-pos="down"
                            >
                                <i class="dashicons dashicons-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </script>

            <div data-ng-include="'<?php echo $tmpPath; ?>fa_popup.html'"></div>
            <script>
                var languages = {
                    "select_icon": "<?php echo __( 'Wybierz ikonę', 'ikcs-trans' ); ?>",
                    "edit_icon": "<?php echo __( 'Zmień ikonę', 'ikcs-trans' ); ?>",
                    "remove_icon": "<?php echo __( 'Usuń ikonę', 'ikcs-trans' ); ?>",
                    "name_value_not_defined": "<?php echo __( 'Nie zdefiniowałeś elementów', 'ikcs-trans' ); ?>"
                }
            </script>


        </div>
    </div>
</div>
