<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;
use App\Controllers\Utility;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

//    wp_enqueue_script('covid-circle-jquery', '//code.jquery.com/jquery-3.5.1.min.js', false, null, true);

    //enqueue styles and scripts for owl carousel
    wp_enqueue_style('owl-carousel-css', get_template_directory_uri().'/assets/owlcarousel/assets/owl.carousel.min.css', false, null);
    wp_enqueue_style('owl-carousel-css', get_template_directory_uri().'/assets/owlcarousel/assets/owl.theme.default.css', false, null);
    wp_enqueue_script('owl-carousel-js', get_template_directory_uri().'/assets/owlcarousel/owl.carousel.min.js', ['jquery'], null, true);
    wp_enqueue_script('custom-js', get_template_directory_uri().'/assets/scripts/pages/custom.js', ['covid-circle-jquery', 'owl-carousel-js'], null, true);

    //hamburger css
    wp_enqueue_style('custom-hamburger-css', get_template_directory_uri().'/assets/hamburger/hamburger.css', false, null);

    //animate.css
    wp_enqueue_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css', false, null);

    //enqueue IBMPlexSans google fonts
    wp_enqueue_style('poppins-font-google', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', false, null);
    //adding font awesome to project
    wp_enqueue_style('covid-circle-fontawesome', get_template_directory_uri().'/assets/font-awesome/fontawesome.css', false, null);
    wp_enqueue_style('covid-circle-fontawesome-brands', get_template_directory_uri().'/assets/font-awesome/brands.css', false, null);
    wp_enqueue_style('covid-circle-fontawesome-solid', get_template_directory_uri().'/assets/font-awesome/solid.css', false, null);
    wp_enqueue_style('covid-circle-lightweight-pop-up', get_template_directory_uri().'/assets/lightweight/video.popup.css', false, null);

    //smooth popup
    wp_enqueue_script('covid-circle-jquery', '//code.jquery.com/jquery-3.5.1.min.js', false, null, true);
    //video player

    wp_enqueue_script('covid-circle-videoplayer-js', get_template_directory_uri().'/assets/videoplayer/simplePlayer.js', ['covid-circle-jquery'], null, true);
    wp_enqueue_script('covid-circle-smooth-popup-js', get_template_directory_uri().'/assets/smooth-popup/needpopup.min.js', ['covid-circle-jquery'], null, true);

    wp_enqueue_style('covid-circle-smooth-popup-css', get_template_directory_uri().'/assets/smooth-popup/needpopup.min.css', false, null);
    wp_enqueue_script('covid-circle-smooth-popup-custom', get_template_directory_uri().'/assets/smooth-popup/custom.js', ['covid-circle-jquery', 'covid-circle-videoplayer-js'], null, true);
    wp_enqueue_script('covid-circle-lightweight-pop-up', get_template_directory_uri().'/assets/lightweight/video.popup.js', ['covid-circle-jquery'], null, true);

}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'covid-circle'),
        'footer_navigation_1' => __('Footer Navigation 1', 'covid-circle'),
        'footer_navigation_2' => __('Footer Navigation 2', 'covid-circle'),
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>',
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

/**
 * Add Action to rest api to get the sub categories
 *
 */
add_action('rest_api_init', function() {
    register_rest_route('covid-circle/v1', '/categories', array(
        'methods'   => 'POST',
        'callback'  => function($request) {
            $category_slug = $request->get_param('category_slug');
            $taxonomy = $request->get_param('resources_types');
            $return_types = [];

            $return_types['types'] =  Utility::geCustomCategories($taxonomy);

            if($taxonomy === 'resources_categories') {
                $return_types['subtypes'] = Utility::geCustomCategories('resources_types');
            }

           return json_encode($return_types);
        }
    ));

    register_rest_route('covid-circle/v1', '/networks', array(
        'methods'   => 'GET',
        'callback'  => function($request) {
            $network_name = $request->get_param('network_name');

            $return_types =  Utility::return_details_of_terms($network_name, 'networks_categories');

            return json_encode($return_types);
        }
    ));

    register_rest_route('covid-circle/v1', '/regions', array(
        'methods'   => 'GET',
        'callback'  => function($request) {
            $region_name = $request->get_param('region_name');
            $network_name = $request->get_param('network_name');

            $return_types =  Utility::return_details_of_regions($region_name, $network_name,'networks_categories');

            return json_encode($return_types);
        }
    ));
});

add_action('init', function () {
    add_shortcode('enable-accessibility', function($atts) {
        echo '<div class="enable-accessbility mb-4">
               <button type="button" id="enable-accessibility" value="enable-accessibility" class="primary-link primary-button"><span>Enable Accessibility</span>
               <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>
               </button>
            </div>';
    });
});
