<div data-ng-app="ikcs">
    <div data-ng-controller="ikcsPageRendering">
        <div class="ikcs-page">

            <div class="sections-list" ui-sortable="sortableOptions">
                <div class="section-item" ng-repeat="item in existingSections" data-as-sortable-item>
                    <div class="options">
                        <div class="options-bg">
                            <div class="image"></div>
                            <div class="colorpicker"></div>
                        </div>
                        <div class="option-mp">

                        </div>
                    </div>
                </div>
            </div>

            <div class="add-new-item">
                <div class="add-from-sections-list">
                    <div class="add-from-sections-list-popup">
                        <div class="add-from-section" data-ng-repeat="item in ikcsSections">{{ item.section_name }}</div>
                    </div>
                    <button type="button" class="ikcs-btn ikcs-btn-large">
                        <?php echo __( 'Dodaj nową sekcje', 'ikcs-trans' ); ?>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

