
// Pagination using infinitive-scroll. Support 2 mode, manual & auto

(function ($) {
  $(document).ready(function () {
    var $container = $('#item-container'),
      nextbtn = $('#infinity-next');
    if (!$container.length || !nextbtn.length || !nextbtn.data('mode')) return;

    // hide default joomla pagination
    $('div.pagination').hide();
    // show next button
    if (nextbtn.data('mode') == 'manual') nextbtn.show().removeClass('hide');

    $container.infinitescroll({
      navSelector: 'ul.pagination',    // selector for the paged navigation
      nextSelector: 'ul.pagination > li:last > a',  // selector for the NEXT link (to page 2)
      itemSelector: '.item-article',     // selector for all items you'll retrieve
      loading: {
        finished: function () {
          $('#infscr-loading').remove();
          nextbtn.removeClass('infscr-loading');
          var instance = $(this).data('infinitescroll');
          if (instance && instance.options.state.currPage >= instance.options.maxPage) {
            nextbtn.removeClass('hide').addClass('d-none').html(nextbtn.data('finishedmsg'));
            $container.infinitescroll('destroy');
          }
        },
        finishedMsg: nextbtn.data('finishedmsg'),
        msgText: '',
        speed: 'fast',
        start: function (opts) {
          nextbtn.addClass('infscr-loading');
          var instance = $(this).data('infinitescroll');
          if (!instance) return;
          instance.beginAjax(opts);
          setTimeout(function () {
            if ($('.ja-gallery-list').length) {
              var $len = $('.ja-gallery-list').length;
              for ($i = 0; $i < $len; $i++) {
                var $button = '.ja-gallery-list';
                if ($('.ja-gallery-list').find('.btn-play').length) {
                  $button = '.btn-play';
                }
                $($button).off().unbind().click(function (event) {
                  event.preventDefault();
                  var $json = jQuery.parseJSON($(this).parent('.ja-gallery-list').find('input').val());
                  blueimp.Gallery($json, {
                    transitionSpeed: 0,
                    hidePageScrollbars: false
                  });
                });
              }
            }
            ////////////////////////////////
            // equalheight for col
            ////////////////////////////////
            var ehArray = ehArray2 = [],
              i = 0;

            $('.equal-height').each(function () {
              var $ehc = $(this);
              if ($ehc.has('.equal-height')) {
                ehArray2[ehArray2.length] = $ehc;
              } else {
                ehArray[ehArray.length] = $ehc;
              }
            });
            for (i = ehArray2.length - 1; i >= 0; i--) {
              ehArray[ehArray.length] = ehArray2[i];
            }

            var equalHeight = function () {
              for (i = 0; i < ehArray.length; i++) {
                var $cols = ehArray[i].children().filter('.col'),
                  maxHeight = 0,
                  equalChildHeight = ehArray[i].hasClass('equal-height-child');

                // reset min-height

                if (equalChildHeight) {
                  $cols.each(function () { $(this).children().first().css('min-height', 0) });
                } else {
                  $cols.css('min-height', 0);
                }
                $cols.each(function () {
                  maxHeight = Math.max(maxHeight, equalChildHeight ? $(this).children().first().innerHeight() : $(this).innerHeight());
                });
                if (equalChildHeight) {
                  $cols.each(function () { $(this).children().first().css('min-height', maxHeight + 2) });
                } else {
                  $cols.css('min-height', maxHeight + 2);
                }
              }
              // store current size
              $('.equal-height > .col').each(function () {
                var $col = $(this);
                $col.data('old-width', $col.width()).data('old-height', $col.innerHeight());
              });
            };

            equalHeight();
            var videoPlay = function () {
              $('.ja-video-list').each(function () {
                var container = $(this);

                var btnPlay = container;
                if (container.find('.btn-play').length) {
                  btnPlay = container.find('.btn-play');
                }
                btnPlay.click(function () {
                  var width = container.outerWidth(true);
                  var height = container.outerHeight(true);

                  if (container.data('video')) {
                    var mainPlayer = $('#ja-main-player');
                    if (!mainPlayer.length) {
                      video = container.find('.video-wrapper');
                      clearContent = true;
                    } else {
                      video = mainPlayer;
                      var width = video.width();
                      var height = video.outerHeight();
                      var clearContent = false;

                      if (container.data('url') && typeof (window.history.pushState) == 'function') {
                        window.history.pushState('string', container.data('title'), container.data('url'));
                      }
                    }

                    if (video.length) {
                      $('.ja-video-list').removeClass('video-playing');
                      container.addClass('video-playing');
                      video.html(container.data('video'));
                      video.find('iframe.ja-video, video').removeAttr('width').removeAttr('height');
                      video.find('iframe.ja-video, video, .jp-video, .jp-jplayer').css({ width: width, height: height });
                      video.show();
                      if (clearContent) {
                        container.data('video', '');
                      }
                      if (mainPlayer.length) {
                        setTimeout(function () {
                          $('html, body').animate({
                            scrollTop: mainPlayer.offset().top
                          }, 200);
                        }, 500);
                      }
                    }
                  }
                });
              });
            }
            videoPlay();
          }, 2000);
        }
      },
      state: {
        isDuringAjax: false,
        isInvalidPage: false,
        isDestroyed: false,
        isDone: false, // For when it goes all the way through the archive.
        isPaused: nextbtn.data('mode') == 'manual' ? true : false,
        currPage: 1
      },
      binder: $container,
      path: function (page) {
        url = $('#infinity-next').data('url') + '?limit=' + $('#infinity-next').data('limit') + '&start=' + ((page - 1) * $('#infinity-next').data('limit')) + '&tmpl=component';
        return url;
      },
      binder: $(window), // used to cache the selector for the element that will be scrolling
      extraScrollPx: 150,
      dataType: 'html',
      appendCallback: true,
      bufferPx: 350,
      debug: false,
      errorCallback: function () {
        nextbtn.removeClass('hidden').addClass('disabled').html(nextbtn.data('finishedmsg'));
        $container.infinitescroll('destroy');
      },
      prefill: false, // When the document is smaller than the window, load data until the document is larger or links are exhausted
      maxPage: parseInt(nextbtn.data('pages')) // to manually control maximum page (when maxPage is undefined, maximum page limitation is not work)
    },


      // call Isotope as a callback
      function (items) {
        if ($container.data('isotope')) {
          $('.infinity-wrap').hide();
          setTimeout(function () {
            $container.isotope('appended', $(items));
            $('.infinity-wrap').show();
          }, 900);
        }

        //update disqus if needed
        if (typeof DISQUSWIDGETS != 'undefined') {
          DISQUSWIDGETS.getCount();
        }
      });


    var btnEvent = 'ontouchstart' in document.documentElement ? 'touchstart' : 'click';
    if (nextbtn.length) {
      nextbtn.on(btnEvent, function () {
        if (!nextbtn.hasClass('finished')) {
          $container.infinitescroll('retrieve');
        }
        return false;
      });
    }
  });

})(jQuery);
