<div data-ng-app="ikcs">
    <div data-ng-controller="ikcsPageRendering" class="ng-cloak" data-ng-cloak>
        <div class="ikcs-page">

            <div class="sections-list" ui-sortable="sortableOptions">
                <div class="section-item" ng-repeat="item in existingSections" data-as-sortable-item>
                    <div class="options">
                        <div class="options-bg" data-ng-if="item.settings.show_select_bg">
                            <div class="image"></div>
                            <div class="colorpicker"></div>
                        </div>
                        <div class="option-mp" data-ng-if="item.settings.show_select_margin">
                            <div class="mp-area">
                                <?php echo __( 'Obszar kontentu', 'ikcs-trans' ); ?>
                                <div class="margin">
                                    <div class="top">
                                        <input type="number" class="form-control form-control-sm" data-ng-model="item.margin.top" />
                                    </div>
                                    <div class="left">
                                        <input type="number" class="form-control form-control-sm" data-ng-model="item.margin.left" />
                                    </div>
                                    <div class="right">
                                        <input type="number" class="form-control form-control-sm" data-ng-model="item.margin.right" />
                                    </div>
                                    <div class="bottom">
                                        <input type="number" class="form-control form-control-sm" data-ng-model="item.margin.bottom" />
                                    </div>
                                </div>
                                <div class="padding">
                                    <div class="top">
                                        <input type="number" class="form-control form-control-sm" data-ng-model="item.padding.top" />
                                    </div>
                                    <div class="left">
                                        <input type="number" class="form-control form-control-sm" data-ng-model="item.padding.left" />
                                    </div>
                                    <div class="right">
                                        <input type="number" class="form-control form-control-sm" data-ng-model="item.padding.right" />
                                    </div>
                                    <div class="bottom">
                                        <input type="number" class="form-control form-control-sm" data-ng-model="item.padding.bottom" />
                                    </div>
                                </div>
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

