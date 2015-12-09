$(document).ready(function () {

    $("#skin-select").find("#toggle").click(function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('#skin-select').animate({ left: 0 }, 100);
            $('.wrap-fluid').css({
                "width":       "auto",
                "margin-left": "270px"
            });
            $('.navbar').css({ "margin-left": "260px" });
            $('#skin-select').find('li').css({ "text-align": "left" });
            $('#skin-select li span, ul.topnav h4, .side-dash, .noft-blue, .noft-purple-number, .noft-blue-number, .title-menu-left').css({
                "display": "inline-block",
                "float": "none"
            });
            $('.ul.topnav li a:hover').css({ " background-color": "green!important" });
            $('.ul.topnav h4').css({ "display": "none" });
            $('.tooltip-tip2').addClass('tooltipster-disable');
            $('.tooltip-tip').addClass('tooltipster-disable');
            $('.datepicker-wrap').css({
                "position": "absolute",
                "right":    "300px"
            });
            $('.skin-part').css({ "visibility": "visible" });
            $('#menu-showhide, .menu-left-nest').css({ "margin": "10px" });
            $('.dark').css({ "visibility": "visible" });
            $('.search-hover').css({ "display": "none" });
            $('.dropdown-wrap').css({
                "position": "absolute",
                "left":     "0px",
                "top":      "53px"
            });
        } else {
            $(this).addClass('active');
            $('#skin-select').animate({ left: -220 }, 100);
            $('.wrap-fluid').css({
                "width":       "auto",
                "margin-left": "50px"
            });
            $('.navbar').css({ "margin-left": "40px" });
            $('#skin-select').find('li').css({ "text-align": "right" });
            $('#skin-select li span, ul.topnav h4, .side-dash, .noft-blue, .noft-purple-number, .noft-blue-number, .title-menu-left').css({ "display": "none" });
            //$('body').css({"padding-left":"50px"});
            $('.tooltip-tip2').removeClass('tooltipster-disable');
            $('.tooltip-tip').removeClass('tooltipster-disable');
            $('.datepicker-wrap').css({
                "position": "absolute",
                "right":    "84px"
            });
            $('.skin-part').css({
                "visibility": "visible",
                "top":        "3px"
            });
            $('.dark').css({ "visibility": "hidden" });
            $('#menu-showhide, .menu-left-nest').css({ "margin": "0" });
            $('.search-hover').css({
                "display":  "block",
                "position": "absolute",
                "right":    "-100px"
            });
            $('.dropdown-wrap').css({
                "position": "absolute",
                "left":     "-10px",
                "top":      "53px"
            });
        }
        return false;
    });
    setTimeout(function () { $("#skin-select").find("#toggle").addClass('active').trigger('click'); }, 10)
});