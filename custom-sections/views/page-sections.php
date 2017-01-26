<div data-ng-app="ikcs">
    <div data-ng-controller="ikcsPageRendering" class="ng-cloak" data-ng-cloak>
        <div class="ikcs-page">

            <div class="sections-list" ui-sortable="sortableOptions">
                <div class="section-item" ng-repeat="item in existingSections" data-as-sortable-item>
                    <div class="options">
                        <div class="options-bg">
                            <div class="image"></div>
                            <div class="colorpicker"></div>
                        </div>
                        <div class="option-mp">
test
                        </div>
                    </div>
                </div>
            </div>

            <div class="add-new-item">
                <div class="add-from-sections-list">
                    <div class="add-from-sections-list-popup">
                        <div class="add-from-section" data-ng-repeat="item in ikcsSections" data-ng-click="addNewSection(item.id)">
                            <div class="ikcs-menu-image dashicons-before dashicons-grid-view"></div>
                            <div class="ikcs-menu-name">{{ item.section_name }}</div>
                        </div>
                        <div class="loader"
                             data-ng-if="addNewSectionBefore"
                             data-ng-include="'<?php echo ikcs_views_path(); ?>/templates/preloader.html'">
                        </div>
                    </div>
                    <button type="button" class="ikcs-btn">
                        <?php echo __( 'Dodaj nową sekcje', 'ikcs-trans' ); ?>
                    </button>
                </div>
                <div class="clear"></div>
            </div>

        </div>
    </div>
</div>

