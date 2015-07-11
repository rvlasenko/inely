/****  Variables Initiation  ****/
var doc = document;

/* ==========================================================*/
/* PLUGINS                                                   */
/* ========================================================= */

/**** Sortable Portlets ****/
function sortablePortlets(){
    if ($('.portlets').length && $.fn.sortable) {
        $( ".portlets" ).sortable({
            connectWith: ".portlets",
            handle: ".panel-header",
            items:'div.panel',
            placeholder: "panel-placeholder",
            opacity: 0.5,
            dropOnEmpty: true,
            forcePlaceholderSize: true,
            receive: function(event, ui) {
                $("body").trigger("resize");
            }
        });
    }
}

var oldIndex;
if ($('.sortable').length && $.fn.sortable) {
    $(".sortable").sortable({
        handle: ".panel-header",
        start: function(event, ui) {
            oldIndex = ui.item.index();
            ui.placeholder.height(ui.item.height() - 20);
        },
        stop: function(event, ui) {
            var newIndex = ui.item.index();

            var movingForward = newIndex > oldIndex;            
            var nextIndex = newIndex + (movingForward ? -1 : 1);

            var items = $('.sortable > div');
            
            // Find the element to move
            var itemToMove = items.get(nextIndex);
            if (itemToMove) {
                
                // Find the element at the index where we want to move the itemToMove
                var newLocation = $(items.get(oldIndex));
                
                // Decide if it goes before or after
                if (movingForward) {
                    $(itemToMove).insertBefore(newLocation);
                } else {
                    $(itemToMove).insertAfter(newLocation);
                }
            }
        }
    });
}

/****  Show Popover  ****/
function popover() {
    if ($('[rel="popover"]').length && $.fn.popover) {
        $('[rel="popover"]').popover({
            trigger: "hover"
        });
        $('[rel="popover_dark"]').popover({
            template: '<div class="popover popover-dark"><div class="arrow"></div><h3 class="popover-title popover-title"></h3><div class="popover-content popover-content"></div></div>',
            trigger: "hover"
        });
    }
}

/* Manage Slider */
function sliderIOS(){
    if ($('.slide-ios').length && $.fn.slider) {
        $('.slide-ios').each(function () {
            $(this).sliderIOS();
        });
    }
}

/* Manage Range Slider */
function rangeSlider(){
    if ($('.range-slider').length && $.fn.ionRangeSlider) {
        $('.range-slider').each(function () {
            $(this).ionRangeSlider({
                min: $(this).data('min') ? $(this).data('min') : 0,
                max: $(this).data('max') ? $(this).data('max') : 5000,
                hideMinMax: $(this).data('hideMinMax') ? $(this).data('hideMinMax') : false,
                hideFromTo: $(this).data('hideFromTo') ? $(this).data('hideFromTo') : false,
                to: $(this).data('to') ? $(this).data('to') : '',
                step: $(this).data('step') ? $(this).data('step') : '',
                type: $(this).data('type') ? $(this).data('type') : 'double',
                prefix: $(this).data('prefix') ? $(this).data('prefix') : '',
                postfix: $(this).data('postfix') ? $(this).data('postfix') : '',
                maxPostfix: $(this).data('maxPostfix') ? $(this).data('maxPostfix') : '',
                hasGrid: $(this).data('hasGrid') ? $(this).data('hasGrid') : false
            });
        });
    }
}

function inputSelect(){

    if($.fn.select2){
        setTimeout(function () {
            $('select').each(function(){
                function format(state) {
                    var state_id = state.id;
                    if (!state_id)  return state.text; // optgroup
                    var res = state_id.split("-");
                    if(res[0] == 'image') {
                        if(res[2]) return "<img class='flag' src='images/flags/" + res[1].toLowerCase() + "-" + res[2].toLowerCase() +".png' style='width:27px;padding-right:10px;margin-top: -3px;'/>" + state.text;
                        else return "<img class='flag' src='images/flags/" + res[1].toLowerCase() + ".png' style='width:27px;padding-right:10px;margin-top: -3px;'/>" + state.text;
                    }
                    else {
                        return state.text;
                    }
                }
                $(this).select2({
                    formatResult: format,
                    formatSelection: format,
                    placeholder: $(this).data('placeholder') ?  $(this).data('placeholder') : '',
                    allowClear: $(this).data('allowclear') ? $(this).data('allowclear') : true,
                    minimumInputLength: $(this).data('minimumInputLength') ? $(this).data('minimumInputLength') : -1,
                    minimumResultsForSearch: $(this).data('search') ? 1 : -1,
                    dropdownCssClass: $(this).data('style') ? 'form-white' : ''
                });
            });

        }, 200);
    }
}

function inputTags(){
    $('.select-tags').each(function(){
        $(this).tagsinput({
            tagClass: 'label label-primary'
        });
    });

}

/****  Summernote Editor  ****/
function editorSummernote(){
    if ($('.summernote').length && $.fn.summernote) {
        $('.summernote').each(function () {
            $(this).summernote({
                height: 300,
                airMode : $(this).data('airmode') ? $(this).data('airmode') : false,
                airPopover: [
                    ["style", ["style"]],
                    ['color', ['color']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']]
                  ],
                toolbar: [
                    ["style", ["style"]],
                    ["style", ["bold", "italic", "underline", "clear"]],
                    ["fontsize", ["fontsize"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["height", ["height"]],
                    ["table", ["table"]]
                ]
            });
        });
    }
}

/****  Animated Panels  ****/
function liveTile() {
     
    if ($('.live-tile').length && $.fn.liveTile) {
        $('.live-tile').each(function () {
            $(this).liveTile("destroy", true); /* To get new size if resize event */
            tile_height = $(this).data("height") ? $(this).data("height") : $(this).find('.panel-body').height() + 52;
            $(this).height(tile_height);
            $(this).liveTile({
                speed: $(this).data("speed") ? $(this).data("speed") : 500, // Start after load or not
                mode: $(this).data("animation-easing") ? $(this).data("animation-easing") : 'carousel', // Animation type: carousel, slide, fade, flip, none
                playOnHover: $(this).data("play-hover") ? $(this).data("play-hover") : false, // Play live tile on hover
                repeatCount: $(this).data("repeat-count") ? $(this).data("repeat-count") : -1, // Repeat or not (-1 is infinite
                delay: $(this).data("delay") ? $(this).data("delay") : 0, // Time between two animations
                startNow: $(this).data("start-now") ? $(this).data("start-now") : true //Start after load or not
            });
        });
    }
}

function animateNumber(){
    $('.countup').each(function(){
        from     = $(this).data("from") ? $(this).data("from") : 0;
        to       = $(this).data("to") ? $(this).data("to") : 100;
        duration = $(this).data("duration") ? $(this).data("duration") : 2;
        delay    = $(this).data("delay") ? $(this).data("delay") : 1000;
        decimals = $(this).data("decimals") ? $(this).data("decimals") : 0;
        var options = {useEasing : true, useGrouping : true,  separator : ',', prefix : $(this).data("prefix") ? $(this).data("  prefix") : '', suffix : $(this).data("suffix") ? $(this).data("suffix") : ''
        }
        var numAnim = new countUp($(this).get(0),from, to, decimals, duration, options);
        setTimeout(function(){
            numAnim.start();
        },delay);
    });
}

/****  Initiation of Main Functions  ****/
$(document).ready(function () {

    sortablePortlets();
    popover();
    sliderIOS();
    rangeSlider();
    inputSelect();
    inputTags();
    editorSummernote();
    liveTile();
    animateNumber();

});