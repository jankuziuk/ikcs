<div data-ng-app="ikcs">
    <div data-ng-controller="ikcsPageRendering" class="ng-cloak" data-ng-cloak>
        <div class="ikcs-page">

            <div class="sections-list" ui-sortable="sortableOptions">
                <div class="section-item" ng-repeat="item in existingSections" data-as-sortable-item>
                    <div class="options">
                        <div class="option-mp">
                            <div class="mp-area">
                                <div class="display-table">
                                    <div class="table-row">
                                        <div class="table-col background v-top" data-ng-if="item.settings.show_select_bg">
                                            <div class="mp-inner-title"><?php echo __( 'Ustał tło:', 'ikcs-trans' ); ?></div>
                                            <div class="image">
                                                <img src="" alt="Logo" id="ik_logo_img_{{index}}" style="vertical-align: middle;" />
                                                <input type="hidden" name="ik_theme_options[logo_url_{{index}}]" id="ik_logo_url_{{index}}">
                                                <a class="button" data-ng-click="upload_image(index)" style="vertical-align: middle;">Dodaj logo</a>
                                            </div>
                                            <div class="colorpicker"></div>
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
                            </div>
                        </div>
                        <div class="clear"></div>
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
                             data-ng-if="addNewSectionBefore"
                             data-ng-include="'<?php echo ikcs_views_path(); ?>/templates/preloader.html'">
                        </div>
                        <?php echo __( 'Dodaj nową sekcje', 'ikcs-trans' ); ?>
                    </button>
                </div>
                <div class="clear"></div>
            </div>


        </div>
    </div>
</div>
