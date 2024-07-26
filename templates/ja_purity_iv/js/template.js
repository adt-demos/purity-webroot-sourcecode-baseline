jQuery(document).ready(function ($) {
  jQuery(document).on("scroll", onScroll);
  onepageNavLinks = jQuery('.onepage .t4-navbar .nav-link');

  AOS.init({
    duration: 1200,
    once: true,
    disable: function () {
      var maxWidth = 992;
      return window.innerWidth < maxWidth;
    }
  });

  function onScroll(event) {
    var scrollPos = jQuery(document).scrollTop();
    onepageNavLinks.each(function () {
      var currLink = jQuery(this);
      var refElement = jQuery(currLink.attr("href"));
      if (refElement.position().top <= scrollPos /* && refElement.position().top + refElement.height() > scrollPos*/) {
        onepageNavLinks.removeClass("active");
        currLink.addClass("active");
      }
      else {
        currLink.removeClass("active");
      }
    });
  }

  // Isotope
  var $container = jQuery('.view-masonry .items-row');

  if ($container.length) {
    $container.isotope({
      itemSelector: '.item',
      gutter: 0,
      percentPosition: true,
      masonry: {
        horizontalOrder: true,
      }
    });


    // re-order when images loaded
    $container.imagesLoaded(function () {
      $container.isotope();

      setTimeout (function() {
        $container.isotope();
      }, 2000);  
    });
  };

  // Theme switcher
  if ($('.ja-dark-mode').length > 0) {
    const cookieId = $('body').attr('jadark-cookie-id');

    function setTheme() {
      JATheme = $('body').hasClass('dark-active') ? 'isActive' : 'notActive';
      $.cookie(cookieId, JATheme, { path: '/' });
    }

    $(".ja-dark-mode").click(function () {
      $('body').toggleClass('dark-active');
      setTheme();
    });
  };

  // Add Class For Section
  if ($('.t4-mod-wrap').length > 0) {
    $('.t4-mod-wrap').each(function() {
      var $bgColor = $(this).attr('data-bg-color');
      if($bgColor != 'bg-default') {
        $(this).parents('.t4-section').addClass($bgColor);
      }
    });
  };

  
});

function jsAdvanceSearchResultsNotice(click) {
  document.getElementById("notice").style.display = 'none';
}