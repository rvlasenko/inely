$('body').on('click', 'a.btn, button.btn, input.btn, label.btn', function (e) {
    var element, circle, d, x, y;

    element = $(this);

    if (element.find(".md-click-circle").length == 0) {
        element.prepend("<span class='md-click-circle'></span>");
    }

    circle = element.find(".md-click-circle");
    circle.removeClass("md-click-animate");

    if (!circle.height() && !circle.width()) {
        d = Math.max(element.outerWidth(), element.outerHeight());
        circle.css({height: d, width: d});
    }

    x = e.pageX - element.offset().left - circle.width() / 2;
    y = e.pageY - element.offset().top - circle.height() / 2;

    circle.css({top: y + 'px', left: x + 'px'}).addClass("md-click-animate");
});