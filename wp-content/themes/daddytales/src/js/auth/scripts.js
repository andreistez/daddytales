(function($){
    'use strict';

	$(function() {
        onUserTabClick();
	});

    /**
     * Click on User dashboard tab.
     */
    function onUserTabClick() {
        if (! $('.user-tabs').length) return;

        $('body').on('click', '.user-tab', function() {
            // Get current tab.
            var tab = $(this);
            // Content part identifier for this tab.
            // Equal to the same attribute of .user-tab-content-inner.
            var content = tab.attr('data-content');

            // Remove active class fropm previously active tab and its content.
            $('.user-tab, .profile-content-inner').removeClass('active');
            // Add active class to current tab.
            tab.addClass('active');
            // Show its content part.
            $('.profile-content-inner[data-content="' + content + '"]').addClass('active');
        });
    }
})(jQuery);