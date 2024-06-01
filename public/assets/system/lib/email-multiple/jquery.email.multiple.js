/**
 * Created by Malal91 and Haziel
 * Select multiple email by jquery.email_multiple
 * **/

/**
 * Example :
 *   $("Your Element Input ID").emailMultiple({
 *     placeholder: 'To: Enter Email...',
 *     reset: false,
 *     fill: false,
 *     id: '_mailTo', // Your Element Input ID
 *     srcData: ['example@email.com', 'example@email.com']
 *   });
 * **/

 /**
 * Example Update Data:
 *   $("Your Element Input ID").emailMultipleUpdate({
 *     id: '_mailTo', // Your Element Input ID
 *     srcData: ['example@email.com', 'example@email.com']
 *   });
 * **/

(function($){

    $.fn.emailMultiple = function(options) {

        let defaults = {
            reset: false,
            fill: false,
            srcData: null, // Set srcData to Array ['example@email.com', 'example@email.com']
            id: null, // Element Input ID
            placeholder: null
        };

        let settings = $.extend(defaults, options);
        let email = "";

        return this.each(function()
        {
            $(this).after("<div class=\"all-ele-mail all-mail-"+ $(this)[0].id +"\"></div>\n" +
                "<input type=\"text\" name=\"multi-email-"+$(this)[0].id+"\" class=\"form-control enter-mail-"+ $(this)[0].id +"\" placeholder=\""+settings.placeholder+"\" />");
            let $orig = $(this);
            let $element = $('.enter-mail-' + $(this)[0].id);


            $element.keydown(function (e) {
                $element.css('border', '');
                if (e.keyCode === 13 || e.keyCode === 32) {
                    let getValue = $element.val();
                    if (/^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,6}$/.test(getValue)){                        
                        $('.all-mail-'+ $orig[0].id).append('<span class="multi-emails selected-'+ $orig[0].id +'">' + getValue + '<span class="cancel-email">x</span></span>');
                        $element.val('');

                        email += getValue + ';'
                    } else {
                        $element.css('border', '1px solid red')
                    }
                }

                $orig.val(email.slice(0, -1))
            });

            $(document).on('click','.cancel-email',function(){
                $(this).parent().remove();
            });

            if(settings.srcData){
                $.each(settings.srcData, function (x, y) {
                    if (/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(y)){
                        $('.all-mail-' + settings.id).append('<span class="multi-emails selected-'+ settings.id +'">' + y + '<span class="cancel-email">x</span></span>');
                        $element.val('');

                        email += y + ';'
                    } else {
                        $element.css('border', '1px solid red')
                    }
                })

                $orig.val(email.slice(0, -1))
            }

            if(settings.reset){
                $('.' + settings.id).remove()
            }

            return $orig.hide()
        });
    };

    $.fn.emailMultipleUpdate = function(options) {
        let defaults = {
            srcData: null, // Set srcData to Array ['example@email.com', 'example@email.com']
            id: null, // Element Input ID
            placeholder: null
        };

        let settings = $.extend(defaults, options);
        let $orig = $(this);
        let $element = $('.enter-mail-' + $(this)[0].id);
        let email = "";

        if(settings.srcData){
            $.each(settings.srcData, function (x, y) {
                if (/^[a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/.test(y)){
                    $('.all-mail-' + settings.id).append('<span class="multi-emails selected-'+ settings.id +'">' + y + '<span class="cancel-email">x</span></span>');
                    $element.val('');

                    email += y + ';'
                } else {
                    $element.css('border', '1px solid red')
                }
            })

            $orig.val(email.slice(0, -1))
        }
        return $orig.hide()
    };

})(jQuery);
