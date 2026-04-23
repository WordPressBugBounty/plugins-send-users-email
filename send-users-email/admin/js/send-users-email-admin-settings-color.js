(function ($) {
    'use strict';
    
    $(document).ready(function () {
        // Initialize color pickers
        $('.sue-color-picker').each(function () {
            $(this).wpColorPicker();
        });
    });   

})(jQuery);
