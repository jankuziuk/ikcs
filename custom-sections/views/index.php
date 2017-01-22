<?php
//    $list = ikcs_get_all_postmeta_by_key($this->settings['meta_key']);
//?>
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<div class="wrap" data-ng-app="ikcs">
    <div data-ng-controller="ikcsGetSections">
        <div class="main-header">
            <h1 class="wp-heading-inline"><?php echo __('Zdefiniowane sekcje', 'ikcs-trans'); ?></h1>
        </div>

        <div class="main-container ng-cloak" data-ng-cloak>
            <div id="poststuff">
                <div id="post-body">
                    <div class="ikcs-card">
                        <div class="loader"
                             data-ng-if="!ikcsGetListComplete"
                             data-ng-include="'<?php echo ikcs_views_path(); ?>/templates/preloader.html'">
                        </div>
                        <div class="ikcs-show-content" data-ng-if="ikcsGetListComplete">
                            <div class="ikcs-card-head" data-ng-show="ikcsSections.length > 0">
                                <div class="row">
                                    <div class="colunm">
                                        <div class="form-group">
                                            <label class="fg-label"><?php echo __( 'Wyszukaj sekcje wg nazwy', 'ikcs-trans' ); ?></label>
                                            <input type="text" name="name" data-ng-model="search.section_name" class="form-control" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="colunm">
                                        <div class="form-group">
                                            <label class="fg-label"><?php echo __( 'Pokazuj na stronie', 'ikcs-trans' ); ?></label>
                                            <input type="number" min="1" data-ng-model="itemsPerPage" class="form-control" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>

                            <div class="display-table ikcs-sections-list" data-ng-show="ikcsSections.length > 0">
                                <div class="table-row table-head">
                                    <div class="table-col table-name" ng-click="sort('section_name')" style="cursor: pointer;"><?php echo __('Nazwa', 'ikcs-trans'); ?></div>
                                    <div class="table-col table-date" ng-click="sort('datetime_mod')" style="cursor: pointer;"><?php echo __('Data modyfikacji', 'ikcs-trans'); ?></div>
                                    <div class="table-col table-actions"></div>
                                </div>
                                <div class="table-row table-item ikcs-sections-item"
                                     data-ng-show="ikcsSections.length > 0"
                                     current-page="currentPage"
                                     dir-paginate="item in ikcsSections|orderBy:sortKey:reverse|filter:search|itemsPerPage:itemsPerPage"
                                >
                                    <a href="<?php echo ikcs_edit_path(); ?>{{ item.id }}" class="table-col table-name">{{ item.section_name }}</a>
                                    <a href="<?php echo ikcs_edit_path(); ?>{{ item.id }}" class="table-col table-date">{{ item.datetime_mod }}</a>
                                    <div class="table-col table-actions">
                                        <button type="button" data-ng-class="item.removing ? 'btn-loader' : ''" class="ikcs-btn ikcs-btn-dash ikcs-btn-trash dashicons dashicons-trash" class="remove-section" data-ng-click="removeSectionById(item.id, $index)">
                                            <div class="loader"
                                                 data-ng-if="item.removing"
                                                 data-ng-include="'<?php echo ikcs_views_path(); ?>/templates/preloader.html'">
                                            </div>
                                        </button>
                                        <a href="<?php echo ikcs_edit_path(); ?>{{ item.id }}" class="ikcs-btn ikcs-btn-dash dashicons dashicons-edit"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="ikcs-section-empty" data-ng-show="ikcsSections.length == 0">
                                <?php echo __( 'Nie masz zadnej zdefiniowanej sekcji', 'ikcs-trans' ); ?>
                            </div>
                            <div class="ikcs-section-footer">
                                <div data-ng-show="ikcsSections.length > 0" id="pagination">
                                    <dir-pagination-controls
                                        max-size="5"
                                        direction-links="true"
                                        boundary-links="true"
                                        on-page-change="pageChanged(newPageNumber, itemsPerPage)">
                                    </dir-pagination-controls>
                                </div>
                                <div class="add-new-item">
                                    <a href="<?php echo ikcs_add_path(); ?>" class="ikcs-btn ikcs-btn-large">
                                        <?php echo __( 'Dodaj nową sekcje', 'ikcs-trans' ); ?>
                                    </a>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ikcs-copyring">
    &copy; 2017 Ivan Kuziuk by Dream Page
</div>



<!--<div class="wrap">-->
<!--    <h1 class="wp-heading-inline">--><?php //echo __('Zdefiniowane sekcje', 'ikcs-trans'); ?><!--</h1>-->
<!--    <table class="wp-list-table widefat fixed striped pages">-->
<!--        <thead>-->
<!--            <tr><th scope="col" id="title" class="manage-column column-title column-primary desc check-colum">Tytuł</th>-->
<!--        </thead>-->
<!--        <tbody id="the-list">-->
<!--            --><?php //if (!empty($list)) : ?>
<!--                --><?php //foreach ($list AS $item): ?>
<!--                    <tr class="iedit author-self type-page status-publish hentry">-->
<!--                        <td class="title column-title has-row-actions column-primary page-title" data-colname="Tytuł">-->
<!--                            <strong>-->
<!--                                <a class="row-title" href="--><?php //echo ikcs_edit_path($item['meta_id']); ?><!--">-->
<!--                                    --><?php //echo $item['box_name']; ?>
<!--                                </a>-->
<!--                            </strong>-->
<!--                            <div class="row-actions">-->
<!--                                <span class="edit">-->
<!--                                    <a href="--><?php //echo ikcs_edit_path($item['meta_id']); ?><!--">Edytuj</a> |-->
<!--                                </span>-->
<!--                                <span class="trash">-->
<!--                                    <a href="" class="submitdelete">Do kosza</a>-->
<!--                                </span>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                --><?php //endforeach; ?>
<!--            --><?php //else: ?>
<!--                <tr class="no-items">-->
<!--                    <td class="colspanchange">Nie znaleziono żadnych zdefiniowanych sekcyj.</td>-->
<!--                </tr>-->
<!--            --><?php //endif; ?>
<!--        </tbody>-->
<!--    </table>-->
<!--</div>-->

<?php

//var_dump($this);