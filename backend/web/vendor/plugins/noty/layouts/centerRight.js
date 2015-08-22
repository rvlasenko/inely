$.noty.layouts.centerRight = {
  name: 'centerRight',
      options: { // overrides options

      },
      container: {
          object: '<ul id="noty_customBottomCenter_layout_container" />',
          selector: 'ul#noty_customBottomCenter_layout_container',
          style: function() {
              $(this).css({
                  bottom: 20,
                  left: 0,
                  position: 'fixed',
                  width: '750px',
                  height: 'auto',
                  margin: 0,
                  padding: 0,
                  listStyleType: 'none',
                  zIndex: 10000000
              });

              $(this).css({
                  left: ($(window).width() - $(this).outerWidth(false)) / 2 + 'px'
              });
          }
      },
      parent: {
          object: '<li />',
          selector: 'li',
          css: {}
      },
      css: {
          display: 'none',
          width: '750px'
      },
      addClass: ''
};
