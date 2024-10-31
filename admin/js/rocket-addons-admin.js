(function($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(document).ready(function() {
        // add a 'Settings' tab via JS
        const navTabWrapper = $('.nav-tab-wrapper');
        const currentTabs = $('.nav-tab-wrapper a');
        let activeTab = '';
        if (!currentTabs.hasClass('nav-tab-active')) {
            activeTab = ' nav-tab-active';
        }
        navTabWrapper.prepend('<a href="' + rocket_ajax_object.adminurl + 'admin.php?page=rocket-addons-for-elementor" class="nav-tab fs-tab svg-flags-lite home' + activeTab + '">Rocket Addons</a>');

        $('.rcontrol-enable').on('click', function() {
            $('.rswitch').prop('checked', true);
            $('.rswitch').attr('checked');
        });

        $('.rcontrol-disable').on('click', function() {
            $('.rswitch').prop('checked', false);
            $('.rswitch').removeAttr('checked');
        });
    });

})(jQuery);