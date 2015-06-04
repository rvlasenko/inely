$(document).ready(function () {

    $("a.day").click(function () {
        var content_id = $(this).attr('href');
        $('.main').hide().html($(content_id).html()).show(400);
        return false;
    });

});