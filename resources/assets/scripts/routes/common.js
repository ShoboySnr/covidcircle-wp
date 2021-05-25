import 'owl.carousel';
import '../pages/filter';
import path from '../util/path';

export default {
  init() {
    // JavaScript to be fired on all pages
    //ajax call on categories
    $(window).on('load', function() {
      //add the checkbox
      let $html = '<label class="switch">' +
        '<input type="checkbox" >' +
        '  <span class="slider round"></span>' +
        '</label>';

      $html += '<div class="resize_text_bg inline" id="resize_text_bg"><p>Text Size:</p>' +
        '<div class="resize-text"><button name="resize_text" value="smaller" class="smaller">A</button>' +
        '<button name="resize_text" value="normal" class="normal">A</button> ' +
        '<button name="resize_text" value="larger" class="larger">A</button></div></div>';

      $('#accessibility').append($html);
    });

    $(document).on('click', '.njt-nofi-notification-bar .njt-nofi-hide', function() {
      $('.njt-nofi-container, .noticearea').slideUp();
    });

    let click_count = 0;
    $(document).on('click', '#resize_text_bg button', function() {
      const get_value = $(this).val();
      if(get_value === 'smaller' && click_count >= -5) {
        click_count -= 1
      } else if (get_value === 'larger' && click_count <= 5) {
        click_count += 1;
      } else if (get_value === 'normal') {
        click_count = 0;
      } else return;
      $('div:not(.njt-nofi-container-content), h1, h2, h3, h4, h5, h6, p, span, li, a, ul, input, textarea, button').not('.njt-nofi-container-content *').each(function() {
        let size = parseFloat($(this).css('font-size'));
        let height = parseFloat($(this).css('line-height'));
        $(this).addClass('change-font-size');

        if($(this).hasClass('change-font-size')) {
          if (get_value === 'smaller' && click_count > -5) {
            size -= 1.5;
            height -= 0.45;
          } else if (get_value === 'larger' && click_count <= 6) {
            size += 1.5;
            height += 0.45;
          } else if(get_value === 'normal') {
            $(this).css({
              'font-size': '',
              'line-height': '',
            });
            $(this).removeClass('change-font-size');
            return;
          }
          $(this).css({
            'font-size': size + 'px',
            'line-height':  height + 'px',
          });
        } else {
          $(this).css({
            'font-size':  '',
            'line-height': '',
          });
        }
      });
    })

    $(document).on('change', '#search-form select#resources_types', function() {
      $('#preloader').show();
      $('form#search-form #subcategories').remove();

      const $this = $(this).parents('#search-form');
      const data = new FormData($this[0]);
      data.append('resources_types', $this.find('#resources_types').val());
      data.append('category_slug', $this.find('#category_slug').val());
      data.append('sub_category_slug', $this.find('#sub_category_slug').val());

      const url = $('form#search-form').attr('action') + 'wp-json/covid-circle/v1/categories';

      $.ajax({
        type: 'POST',
        url,
        data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data) {
          const parsed_data = JSON.parse(data);
          if(parsed_data.types !== '') {
              const $category_slug = $this.find('#category_slug');
              $category_slug.find('option').remove();
              $category_slug.append('<option value="">Category</option>');
              $.each(parsed_data.types, function(key, value)
              {
                $category_slug.append('<option value=' + value.category + ',' + value.slug + '>' + value.name + '</option>');
              });
          } else {
            const $category_slug = $this.find('#category_slug');
            $category_slug.find('option').remove();
            $category_slug.append('<option value="">Category</option>');
          }

          if(parsed_data.subtypes) {
            const $category_slug = $this.find('#sub_category_slug');
            $category_slug.find('option').remove();
            $category_slug.append('<option value="">Sub Category</option>');
            $.each(parsed_data.subtypes, function(key, value)
            {
              $category_slug.append('<option value=' + value.category + ',' + value.slug + '>' + value.name + '</option>');
            });
          } else {
            const $category_slug = $this.find('#sub_category_slug');
            $category_slug.find('option').remove();
            $category_slug.append('<option value="">Sub Category</option>');
          }
          $('#preloader').hide();
        },
        error: function() {
          $('#preloader').hide();
        },
      });

      const content_types = $(this).val();
      const name = $(this).attr('name');

      document.location.href = path(window.location.href, name, content_types);
    });

    //show map info
    $(document).on('mouseover', '#networks-maps svg .group-continent', function(e) {
      e.preventDefault();
      // var offset = $(this).offset();
      const left = (e.clientX + 40) + 'px';
      const top = (e.clientY - 40) +  'px';
      const continent = $(this).attr('data-continent');
      $('#networks-maps').find('.country-details').remove();
        $('#networks-maps').append('<button type="submit" class="country-details absolute country-fade-in" href="javascript::void(0);" name="country_details" style="margin-left: -140px; margin-top: -50px;top: ' + top + '; left: ' + left + ';">' +
          '<p>' + continent + '</p>' +
          '</button>');
    });

    //show map info when clicked on a particular country
    $(document).on('click', '#networks-maps svg .group-continent', function() {
      $('.show-map-content').show();
      $('#preloader').show();
      $(this).parent('svg').find('.active').removeClass('active');
      $(this).addClass('active');
      const network_name = $(this).attr('data-continent');

      const url = $('#networks-maps').attr('data-action') + '/wp-json/covid-circle/v1/networks?network_name=' + network_name;

      $.ajax({
        type: 'GET',
        url,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data) {
          const parsed_data = JSON.parse(data);
          $('.no-network-found').remove();
          if(parsed_data.regions != '') {
            const $add_regions = $('#add-regions');
            $add_regions.find('button').remove();
            $add_regions.append('<button type="button" value="" name="regions" class="active">All Regions</button>');
            $.each(parsed_data.regions, function(key, value)
            {
              $add_regions.append('<button name="regions" type="button"  value=' + value.slug + '>' + value.name + '</button>');
            });
            const $add_regions_select = $('#add-regions-select');
            $add_regions_select.find('option').remove();
            $add_regions_select.append('<option value="">All Regions</option>');
            $.each(parsed_data.regions, function(key, value) {
              $add_regions_select.append('<option value="' + value.slug + '">' + value.name + '</option>');
            });
          } else {
            const $add_regions = $('#add-regions');
            $add_regions.find('button').remove();
            $add_regions.html('<p class="no-network-found">No regions found.</p>');
            const $add_regions_select = $('#add-regions-select');
            $add_regions_select.find('option').remove();
            $add_regions_select.append('<option value="">No regions found </option>');
          }
          if(parsed_data.contents != '') {
            const $regions_container = $('#regions-container');
            $regions_container.find('.items-container').remove();
            $.each(parsed_data.contents, function(key, value)
            {
              const link = value.link ? value.link : {url: '', title: '', target: ''};

              let $return_text = '<div class="items-container">' +
            '<div class="item-bg">' +
            '<div class="flex justify-start items-center">';

            if(value.image) {
              $return_text += '<img src="' + value.image + '" title="' + value.title +'" />';
             }
            $return_text += '<div class="title-description">' +
            '<div class="title">';
            if(value.organisation_name) {
              $return_text +=  '<p class="organisation">' + value.organisation_name  + '</p>';
            }
            $return_text += '<a class="title-link" href="' + link.url + '" target="' + link.target + '" title="' + link.title + '">' + value.title + '</a>' +
            '<p>' + value.content + '</p>';
            if(value.themic_area) {
              $return_text += '<p class="themic_area">' + value.themic_area + '</p>';
            }

            if(value.link) {
              $return_text += '<a href="' + value.link.url + '" class="primary-link" title="' + value.link.title + '">' +
                '<span>' + value.link.title + '</span>' +
                '<svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>\n' +
                '</a>';
            }
            $return_text += '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
              $regions_container.append($return_text);
            });
          } else {
            const $regions_container = $('#regions-container');
            $regions_container.find('.items-container').remove();
            $regions_container.html('<div class="text-center w-full no-network-found"><p>No Network found in this region</p>');
          }
          $('#preloader').hide();
        },
        error: function() {
          $('#preloader').hide();
        },
      });
    });

    //show map info when clicked on a particular country
    $(document).on('click', '#regions-bg .add-regions button', function() {
      $('.show-map-content').show();
      $('#preloader').show();
      $(this).parent('.add-regions').find('.active').removeClass('active');
      $(this).addClass('active');
      const region_name = $(this).val();
      const network_name = $('#networks-maps svg .active').attr('data-continent') ? $('#networks-maps svg .active').attr('data-continent') : '';

      const url = $('#networks-maps').attr('data-action') + '/wp-json/covid-circle/v1/regions?region_name=' + region_name + '&network_name=' + network_name;

      $.ajax({
        type: 'GET',
        url,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data) {
          const parsed_data = JSON.parse(data);
          $('.no-network-found').remove();
          if(parsed_data != '') {
            const $regions_container = $('#regions-container');
            $regions_container.find('.items-container').remove();
            $.each(parsed_data, function(key, value)
            {
              const link = value.link ? value.link : {url: '', title: '', target: ''};

              let $return_text = '<div class="items-container">' +
                '<div class="item-bg">' +
                '<div class="flex justify-start items-center">';

              if(value.image) {
                $return_text += '<img src="' + value.image + '" title="' + value.title +'" />';
              }
              $return_text += '<div class="title-description">' +
                '<div class="title">';
                if(value.organisation_name) {
                  $return_text +=  '<p class="organisation">' + value.organisation_name  + '</p>';
                }
                $return_text += '<a class="title-link" href="' + link.url + '" target="' + link.target + '" title="' + link.title + '">' + value.title + '</a>' +
                  '<p>' + value.content + '</p>';
                if(value.themic_area) {
                  $return_text += '<p class="themic_area">' + value.themic_area + '</p>';
                }

              if(value.link) {
                $return_text += '<a href="' + value.link.url + '" class="primary-link" title="' + value.link.title + '">' +
                  '<span>' + value.link.title + '</span>' +
                  '<svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>\n' +
                  '</a>';
              }
              $return_text += '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
              $regions_container.append($return_text);
            });
          } else {
            const $regions_container = $('#regions-container');
            $regions_container.find('.items-container').remove();
            $regions_container.html('<div class="text-center w-full no-network-found"><p>No Network found in this region</p>');
          }
          $('#preloader').hide();
        },
        error: function() {
          $('#preloader').hide();
        },
      });
    });

    //show map info when clicked on a particular country
    $(document).on('change', '#regions-bg .filter-regions select', function() {
      $('.show-map-content').show();
      $('#preloader').show();
      $(this).parent('.add-regions').find('.active').removeClass('active');
      $(this).addClass('active');
      const region_name = $(this).val();
      const network_name = $('#networks-maps svg .active').attr('data-continent');

      const url = $('#networks-maps').attr('data-action') + '/wp-json/covid-circle/v1/regions?region_name=' + region_name + '&network_name=' + network_name;

      $.ajax({
        type: 'GET',
        url,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(data) {
          const parsed_data = JSON.parse(data);
          $('.no-network-found').remove();
          if(parsed_data != '') {
            const $regions_container = $('#regions-container');
            $regions_container.find('.items-container').remove();
            $.each(parsed_data, function(key, value)
            {
              const link = value.link ? value.link : {url: '', title: '', target: ''};

              let $return_text = '<div class="items-container">' +
                '<div class="item-bg">' +
                '<div class="flex justify-start items-center">';

              if(value.image) {
                $return_text += '<img src="' + value.image + '" title="' + value.title +'" />';
              }
              $return_text += '<div class="title-description">' +
                '<div class="title">';
              if(value.organisation_name) {
                $return_text +=  '<p class="organisation">' + value.organisation_name  + '</p>';
              }
              $return_text += '<a class="title-link" href="' + link.url + '" target="' + link.target + '" title="' + link.title + '">' + value.title + '</a>' +
                '<p>' + value.content + '</p>';
              if(value.themic_area) {
                $return_text += '<p class="themic_area">' + value.themic_area + '</p>';
              }

              if(value.link) {
                $return_text += '<a href="' + value.link.url + '" class="primary-link" title="' + value.link.title + '">' +
                  '<span>' + value.link.title + '</span>' +
                  '<svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>\n' +
                  '</a>';
              }
              $return_text += '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
              $regions_container.append($return_text);
            });
          } else {
            const $regions_container = $('#regions-container');
            $regions_container.find('.items-container').remove();
            $regions_container.html('<div class="text-center w-full no-network-found"><p>No Network found in this region</p>');
          }
          $('#preloader').hide();
        },
        error: function() {
          $('#preloader').hide();
        },
      });
    });

    //pull out search box
    $(document).on('click', '#pullout-search button.search-icon-bg', function() {
        $(this).parent('#pullout-search').find('.search-section').toggleClass('animate-search-pullout');
    });

    //toggle the contrast button
    $(document).on('click', '#accessibility .switch input', function() {
      $('html').toggleClass('dark');
      if($('html').hasClass('dark')) {
        localStorage.setItem('contrast-mode', true);
      } else localStorage.removeItem('contrast-mode');
    })

    //toggle the menu
    $(document).on('click', 'header #mobile-menu', function() {
      const $hamburger_menu = $(this);
      $('.banner img').toggleClass('img-drop-down');
      setTimeout($('.group-action-buttom-menu').toggleClass('show-drop-down'), 2000);
      $hamburger_menu.find('.hamburger').toggleClass('is-active');
      if($('#nav-menu').hasClass('mobileSlideFadeIn')) {
        $('#nav-menu').toggleClass('show-menu').toggleClass('mobileSlideFadeIn');
      } else {
        $('#nav-menu').toggleClass('show-menu').toggleClass('mobileSlideFadeIn');
      }
      $('.banner').toggleClass('fixed');
      $('.nav-menu').slideToggle('fast');
      $('body').toggleClass('fixed xl:relative');
    });

    //toggle the categories tab
    $(document).on('click', '#resources-content .side-filter .toggle-category', function(event) {
      event.preventDefault();

      $(this).parent('.side-filter').find('.category-show').toggleClass('hidden');
      $(this).find('svg').toggleClass('rotate-180');
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
