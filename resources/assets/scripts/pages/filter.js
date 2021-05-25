import path from '../util/path';
import Cookies from 'js-cookie';

//resources types filter
$(document).on('click', '#resources-hub .resources-filter button', function(event) {
  event.preventDefault();
  const resources_types = $(this).val();
  const name = $(this).attr('name');

  document.location.href = path(window.location.href, name, resources_types);
});

$(document).on('change', '#resources-hub .resources-filter select', function(event) {
  event.preventDefault();
  const resources_types = $(this).val();
  const name = $(this).attr('name');

  if(resources_types === '') {
    return window.location.href;
  }

  return document.location.href = path(window.location.href, name, resources_types);
});

//resources categories filter
$(document).on('click', '#resources-hub .checkbox-group', function(event) {
  event.preventDefault();

  let resources_categories = [];
  resources_categories.push($(this).find('input[type=checkbox]').val());
  $.each($('.checkbox-group input:checked'), function() {
    if (resources_categories.includes($(this).val())) {
      resources_categories.splice($(this).val(), 1);
    } else {
      resources_categories.push($(this).val());
    }
  });

  const value = resources_categories.join(',');
  const name = $(this).find('input[type=checkbox]').attr('name');

  document.location.href = path(window.location.href, name, value);
});

//news and events filter
$(document).on('click', '#post-filter .filter-news-events button', function(event) {
  event.preventDefault();
  const resources_types = $(this).val();
  const name = $(this).attr('name');

  document.location.href = path(window.location.href, name, resources_types);
});

//news and events categories filter
$(document).on('change', '#post-filter .all-categories select', function(event) {
  event.preventDefault();
  const categories = $(this).val();
  const name = $(this).attr('name');

  document.location.href = path(window.location.href, name, categories);
});

//remove margin top when top bar is closed
$(document).on('click', '#notibar button.hide-close-button', function() {
  $(this).parents('#notibar').addClass('hide-notibar');
  $(this).parents('header').addClass('hide-notibar-container');

  const show_notice = Cookies.get('show_notibar');
  if(show_notice === undefined) {
    Cookies.set('show_notibar', true, { expires: 365 });
  }
});

$(window).on('load', function() {
  const show_notibar = Cookies.get('show_notibar');
  if (show_notibar) {
    $('#notibar').addClass('hide-notibar');
    $('header').addClass('hide-notibar-container');
  }
});

//enable accessibility
$(document).on('click', 'button#enable-accessibility', function (event) {
  event.preventDefault();
  $('#preloader').show();

  setTimeout(function() {
    Cookies.remove('show_notibar');

    //remove cookies stored
    $('#notibar').removeClass('hide-notibar');
    $('header').removeClass('hide-notibar-container');
    $('#preloader').hide();
  }, 1000);
});

$(document).on('ready', function() {
  if ($(window).width() > 992) {
    enable_carousel();
  } else {
    $('#news-and-events .owl-carousel, #resources .owl-carousel').addClass('off');
  }
});

$(window).resize(function() {
  if ($(window).width() < 992) {
    disable_carousel();
  } else {
    enable_carousel();
  }
});

function enable_carousel() {
  //carousel on news and events section
  $('#news-and-events .owl-carousel').owlCarousel({
    loop: false,
    responsiveClass: true,
    items: 2,
    dots: false,
    nav: true,
    autoplay: false,
    slideBy: 1,
    navText: [
      '<svg width="24" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 20.333l-9-9 9-9m11 9h-20 20z" stroke="#222" stroke-width="4"/></svg>',
      '<svg width="24" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.5 1.667l9 9-9 9m-11-9h20-20z" stroke="#222" stroke-width="4"/></svg>',
    ],
    responsive: {
      0 : {
        items: 1,
      },

      992 : {
        items: 2,
      },
    },
  });

  //carousel on resources section
  $('#resources .owl-carousel').owlCarousel({
    loop: false,
    responsiveClass: true,
    items: 2,
    dots: false,
    margin: 26.64,
    nav: true,
    autoplay: false,
    autoWidth: true,
    navText: [
      '<svg width="24" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 20.333l-9-9 9-9m11 9h-20 20z" stroke="#222" stroke-width="4"/></svg>',
      '<svg width="24" height="22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.5 1.667l9 9-9 9m-11-9h20-20z" stroke="#222" stroke-width="4"/></svg>',
    ],
    responsive: {
      0 : {
        items: 1,
      },

      740 : {
        items: 2,
      },

      992 : {
        items: 2,
      },
    },
  });
}

function disable_carousel() {
  let owl = $('#news-and-events .owl-carousel, #resources .owl-carousel');
  owl.trigger('destroy.owl.carousel');
  owl.addClass('off');
}


