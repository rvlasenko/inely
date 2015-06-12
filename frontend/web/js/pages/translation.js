(function(){

    switchLanguage();

})();


/**** Automatic Language Translation ****/
function switchLanguage() {

    var userLang = navigator.language || navigator.userLanguage;
    var language = 'en';
    if (userLang == 'ru') language = 'ru';

    /* If user has selected a language, we apply it */
    if ($.cookie('app-language')) {
        language = $.cookie('app-language');
    }
    /* We get current language on page load */
    $("[data-translate]").jqTranslate('../plugins/jquery-translator/translate', {
        forceLang: language
    });

    /* Change language on click */
    $('#switch-lang li a').on('click', function(e) {
        e.preventDefault();
        language = $(this).attr('data-lang');
        $("[data-translate]").jqTranslate('../plugins/jquery-translator/translate', {
            forceLang: language
        });

        /* We save language inside a cookie */
        $.cookie('app-language', language);
        $.cookie('app-language', language, { path: '/' });
    });

}