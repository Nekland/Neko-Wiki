$(document).ready(function() {

    // Use strict just for js fanboys =} this code is pretty ugly !
    'use strict';

    var $mainForm = $('.main-translation-form', '#page-translation-form');

    function showForm($formPart) {
        if ($mainForm.hasClass('col-md-12')) {
            $mainForm.removeClass('col-md-12').addClass('col-md-6');
            $mainForm.after('<div id="second-translation-form" class="col-md-6"></div>');
        }
        $('#second-translation-form').html($formPart);
    }

    function getForm(language) {
        var $new = $('#new-translation-template').clone(),
            $newTmp = $(
            $('#neko_wiki_page_newTranslations')
                .data('prototype')
                .replace(/\_\_name\_\_/g, language)
                .replace(/\%lang\%/g, language)
        );

        $new
            .find('.form-group:first')
            .append($newTmp.find('label').eq(1).detach())
            .append($newTmp.find('input[type=text]').detach().addClass('form-control'))
        ;

        $new
            .find('.form-group').eq(1)
            .append($newTmp.find('label').eq(1).detach())
            .append($newTmp.find('textarea').detach().addClass('form-control').addClass('page-content'))
        ;
        $new.append($newTmp.find('input[type=hidden]').val(language));

        return $new;
    }

    $('a', '#languages-form-list').click(function (e) {
        var $this    = $(this),
            language = $this.data('lang'),
            done     = false;

        $('.main-translation-form hidden', '#page-translation-form').each(function() {
            var $formPart = $(this);

            if ($formPart.data('lang') === language) {
                showForm($formPart.detach());
                done = true;
            }
        });

        if (!done) {
            // we need to create the new form for translation
            var $new = getForm(language);
            showForm($new);
        }

        e.preventDefault();
    });

});
