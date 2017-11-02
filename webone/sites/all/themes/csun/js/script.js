/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - http://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {

  /**
    * Make megamenus more keyboard-navigable with up, down, and esc keys.
    */

  // Fix issue with tabbing to hidden mobile only menu links
  $(document).ready(function() {
    var wid = $(window).width();
    if(wid >= 935){
      $(".mobile-only a").attr("tabindex", "-1");
    }
    $(window).resize(function() {
      wid = $(window).width();
      if(wid < 935){
        $(".mobile-only a").attr("tabindex", "0");
      } else {
        $(".mobile-only a").attr("tabindex", "-1");
      }
    });

    $("li").hover (function() {
      $('.mega-menu__wrapper').removeClass('hovered');
      $('.menu--expanded').removeClass('hovered');
    });

    // Capture keypresses when links are focused.
    $("a").keydown(function(e) {

      if ($(this).parents().hasClass('mega-menu__trigger')) {
        if (e.which == 27) {
          $('.mega-menu__wrapper').removeClass('hovered');
          $('.menu--expanded').removeClass('hovered');

          // Re-assign focus to the top-level item when closing menu.
          // Firefox won't focus a new thing unless we blur current one first.
          $(this).get(0).blur();
          // Use get() since focus() is defined on the DOM elements, not jQuery.
          $(this).parents('.menu--expanded').children(':first').get(0).focus();
          e.preventDefault();
        }
      }


      // If it's inside a megamenu trigger, do our stuff.
      if ($(this).parent().hasClass('mega-menu__trigger')) {

        // If its next sibling is a megamenu wrapper, act on that.
        //if ($(this).next().hasClass('mega-menu__wrapper')) {
         if ($(this).next().hasClass('mega-menu__wrapper')) {

          // Space bar adds "hovered" class.
          if (e.which == 32) {
            $(this).parent().addClass('hovered');
            // First close any already-open megamenus.
            $('.mega-menu__wrapper').removeClass('hovered');
            // Now open the relevant megamenu.
            $(this).next().addClass('hovered');
            e.preventDefault();
          }
        }
      }
    });

    // On focusing on anything outside of the megamenu, close open megamenus.
    $('*').focus(function(e) {
      if(!($(e.target).parents('.mega-menu').length)) {
        $('.hovered').removeClass('hovered');
        e.preventDefault();
      }
    });
    // On when hovering on a megamenu parent, close previously-open megamenus.
    $('.mega-menu--parent>a.menu--link').hover(function(e) {
        $('.hovered').removeClass('hovered');
        e.preventDefault();
    });

    // Accordion
    $('h2.ui-accordion-header').click(function() {
      accordion_open_close($(this));
    });

    $('h2.ui-accordion-header').keydown(function(e) {
      $('div.ui-accordion-content').removeAttr('tabindex');

      if((e.which == 13) || (e.which == 32)) {
        accordion_open_close($(this));
      }
      if((e.which == 38) || (e.which == 40)) {
        if($(this).hasClass('ui-state-active')){
          if(e.which == 38) {
            $(this).get(0).focus();
          }
          if(e.which == 40) {
            $('div.ui-accordion-content-active').attr('tabindex',0);
            $('div.ui-accordion-content-active').get(0).focus();
          }
        }

        $('h2.ui-accordion-header').attr('tabindex',0);
      }
    });

    function accordion_open_close(v){
      // Set tabindex back to 0
      $('h2.ui-accordion-header').attr('tabindex',0);

      if($(v).hasClass('ui-state-default')){
        $(v).attr('aria-expanded', 'false');
        $(v).next().attr('aria-hidden', 'true');
        // Focus bug in Chrome
        $('h2.ui-accordion-header').removeClass('ui-state-focus');
        $(v).addClass('ui-state-focus');
        $(v).get(0).focus();
      }
      else if($(v).hasClass('ui-state-active')){
        $('div.ui-accordion-content-active').attr('aria-hidden', "true");
        $(v).next().attr('aria-hidden', 'false');
      }
    }

  });

  Drupal.behaviors.csunThemeLoad = {
    attach: function (context, settings) {
      // Use jQuery UI Accordion.
      $accordion = $('#accordion', context);
      if ($accordion.length) {
        $accordion.accordion({
          collapsible: true,
          active: false,
          autoHeight:false
        });
      }
      // Add tr class on even/odd in wysiwyg
      $('.field-name-field-body tr:even').addClass('even');
      $('.field-name-field-body tr:odd').addClass('odd');
      // Remove tab index for accordian
      $('h2.ui-accordion-header').attr('tabindex',0);
      $('h2.ui-accordion-header').attr('aria-expanded', 'false');
      $('div.ui-accordion-content').attr('aria-hidden', 'true')
      //Alen's changes
      $('div.ui-accordion').wrapAll('<div id="accordion-instruction"  tabindex="0" />');
      $('#accordion').prepend('<span id="accordion-instruction-at-message">You have reached an accordion control. The following tabs will be activated by spacebar.</span>');
      $('h2.ui-accordion-header').append('<span id="accordion-header-guide-at-message">To activate tabpage press spacebar.');
      //End Alen's changes
    }
  };

  Drupal.behaviors.csunSlideshow = {
    attach: function(context, settings) {

      var $slideWrapper = $('.slide-wrapper', context);

      // If only one item, don't run flexslider.
      var slideshowSize = $slideWrapper.find('figure').size();

      if (slideshowSize > 1) {
        $slideWrapper
          // Setup the flexslider.
          .flexslider({
            animation: "slide",
            pauseOnHover: false, /* EZ CHANGE was true */
            pausePlay: true,  /* EZ CHANGE */
            keyboard: true
          })
          // Remove the "flexslider-off" class.
          .removeClass('flexslider-off');
        $slideWrapper
          .find('.flex-direction-nav li:first-child')
          .after('<li class="flex-control-wrapper"></li>');
        $slideWrapper
          .find('.flex-control-wrapper')
          .append($slideWrapper.find('.flex-control-nav'));
      }
    }
  };

  // Create a behavior for the dropdown nav displayed in the header.
  Drupal.behaviors.csunDropNav = {
    attach: function(context, settings) {
      // Move the drop down links to the proper containers.
      var $mobile = $('.pane-menu-block-custom-primary-mobile', context)
        .detach()
        .find('.menu-block-custom-primary-mobile');
      $('.nav-dropdown__links', context)
        .prepend($mobile);

      var $links = $('.nav-dropdown__constituency-links');
      // Move constituency links to container.
      var $secondary = $('.field-name-field-group-constituency-links', context).clone();
      if ($secondary.length) {
        $secondary
          .removeClass('field-name-field-group-constituency-links');
        $links
          .find('li')
          .append($secondary);
      }
      else {
        $links
          .empty();
      }

      // Custom logic for the myNorthridge Portal link
      if ($secondary.length) {
        $.each($('.nav-dropdown__constituency-links li'), function(){
          if ($('a', this).html() == 'MyNorthridge Portal') {
            $('a', this).attr('href', 'https://auth.csun.edu/cas/login?service=https://mynorthridge.csun.edu/psp/PANRPRD/?cmd=login&languageCd=ENG&embedform=true');
          }
        })
      }

      // Attach a click event that opens the child nav.
      var $dropdown = $('.nav-dropdown__container', context);
      $('.nav-dropdown__label', context).click(function() {
        // Find the links wrapper. Using a wrapper since there are multiple menus.
        // toggle the links open or close. Currently no animation being used.
        $dropdown.slideToggle();
        $(this).toggleClass('active expanded-open');
      });
      // Use an accordion on child nav links.
      var $accordion = $('.menu-block-custom-primary-mobile > .menu, .nav-dropdown__constituency-links', context);
      if ($accordion.length) {
        $accordion
          .find('> .menu--expanded > .menu--link')
          .addClass('accordion-trigger expandable')
          .click(function(e) {
            // Close other accordions.
            $accordion.find('.accordion-trigger').not(e.target).removeClass('expanded-open').next('ul').slideUp();
            //Toggle open/close on the <ul> after the <a>.
            $(e.target).toggleClass('expanded-open').next('ul').slideToggle();
            return false;
          });
      }
    }
  };

  // Create a behavior for the sidebar accordions.
  Drupal.behaviors.csunSidebarAccordion = {
    attach: function(context, settings) {
      var $accordion = $('.sidebar .pane-title');

      $.each($accordion, function(){
        $(this).nextAll('div').wrapAll('<div class="accordio-wrapper" />');
      })

      $accordion.click(function(e) {
        $(e.target)
          .filter('.accordion')
          .toggleClass('expanded-open')
          .next('div')
          .slideToggle();
      });

      $(window)
        .bind('orientationchange resize', function(e) {
          $accordion.removeClass('expanded-open');
          if ($(window).width() <= 950) {
            $accordion
              .addClass('accordion')
              .next('div')
              .slideUp();
          }
          else {
            $accordion
              .removeClass('accordion')
              .next('div')
              .slideDown();
          }
        })
        .trigger('resize');
    }
  };
})(jQuery, Drupal, this, this.document);
