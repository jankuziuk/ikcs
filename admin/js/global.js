jQuery(document).ready(function () {


    // Tabsy
    jQuery('body').on('click', '[data-ik-tabs-menu-id]', function (e) {
        e.preventDefault();
        var $this = jQuery(this),
            $parent = $this.closest('.ik-tabs'),
            tabid = $this.data('ik-tabs-menu-id');

        jQuery('[data-ik-tabs-menu-id]', $parent).removeClass('ik-tab-menu-active');
        $this.addClass('ik-tab-menu-active');
        jQuery('[data-ik-tabs-body-id]', $parent).removeClass('ik-tab-body-active');
        jQuery('[data-ik-tabs-body-id="'+tabid+'"]', $parent).addClass('ik-tab-body-active');
    });


});
