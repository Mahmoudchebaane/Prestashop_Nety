(function($) {
    "use strict";
    $.SmileTrigger = $.SmileTrigger || {};
    $.SmileTrigger.wp_media = $.SmileTrigger.wp_media || [];
    $.SmileTrigger.media_new = function() {
        var $body = $("body");
        $body.on('click', '.smile_upload_icon', $.SmileTrigger.media_new_activate);
    };
    //intended for zip files only. if needed should be easy to expand in the future
    $.SmileTrigger.media_new_activate = function(event) {
        event.preventDefault();
        var clicked = $(this),
            options = clicked.data();
        options.input_target = $('#' + options.target);
        // Create the media frame.
        var file_frame = wp.media({
            frame: options.frame,
            library: { type: options.type },
            button: { text: options.button },
            className: options['class']
        });
        file_frame.on('select update insert', function() { $.SmileTrigger.media_new_insert(file_frame, options); });
        //open the media frame
        file_frame.open();
    };
    //insert the url of the zip file
    $.SmileTrigger.media_new_insert = function(file_frame, options) {
        var state = file_frame.state(),
            selection = state.get('selection').first().toJSON();
        options.input_target.val(selection.id).trigger('change')
        $("body").trigger(options.trigger, [selection, options]);
    }
    $(document).ready(function() {
        $.SmileTrigger.media_new();
        //Fonts Zip file upload
        $("body").on('smile_insert_zip', $.SmileTrigger.icon_insert);
        //font manager
        $("body").on('click', '.smile_del_icon', $.SmileTrigger.icon_remove);
    });
    /************************************************************************
    EXTRA FUNCTIONS, NOT NECESSARY FOR THE DEFAULT UPLOAD
    *************************************************************************/
    $.SmileTrigger.icon_insert = function(event, selection, options) {
        // clean the options field, we dont need to save a value
        options.input_target.val("");
        var manager = $('.smile_iconfont_manager');
        var msg = $('#msg');
        if (selection.subtype !== 'zip') {
            $('.spinner').hide();
            setTimeout(function() {
                msg.slideUp();
            }, 5000);
            return;
        }
    }
    $.SmileTrigger.icon_remove = function(event) {
        event.preventDefault();

        var button = $(this),
            parent = button.parents('.smile-available-font:eq(0)'),
            manager = button.parents('.smile_iconfont_manager:eq(0)'),
            all_fonts = manager.find('.smile-available-font'),
            del_font = button.data('delete'),
            sec_name = button.data('sec_name');
        var msg = $('#msg');
        $.ajax({
            type: 'POST',
            cache: false,
            url: ultimateajaxurl,
            data: {
                ajax: true,
                controller: 'AdminFontManager',
                action: 'RemoveCustomicons', // prestashop already set camel case before execute method
                del_font: del_font,
            },
            success: function(response) {
                console.log(response)
                console.log('here')
                $('.spinner').hide();
                if (response.match(/smile_font_removed/)) {
                    showSuccessMessage("Icon set deleted successfully!");
                    setTimeout(function() {
                        $('.' + sec_name).remove()
                    }, 2000);
                } else {
                    msg.html("<p><div class='error'><p>Couldn't remove the font.</p></div>");
                    msg.show();
                }
            }
        });
    }
})(jQuery);