<?php

namespace App;

use App\Controllers\Utility;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {

    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
            bloginfo('name');
        }
    ]);

    // theme light logo
    $wp_customize->add_setting('theme_logo');
    $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'theme_logo',
        array(
            'label' => 'Upload Light Logo',
            'section' => 'title_tagline',
            'settings' => 'theme_logo',
        )
    ));

    //theme dark logo
    $wp_customize->add_setting('theme_dark_logo');
    $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'theme_dark_logo',
        array(
            'label' => 'Upload Dark Logo',
            'section' => 'title_tagline',
            'settings' => 'theme_dark_logo',
        )
    ));

    //theme dark logo
    $wp_customize->add_setting('theme_footer_logo');
    $wp_customize->add_control(new \WP_Customize_Image_Control($wp_customize, 'theme_footer_logo',
        array(
            'label' => 'Upload Footer Logo',
            'section' => 'title_tagline',
            'settings' => 'theme_footer_logo',
        )
    ));

    //add social media section
    $wp_customize->add_section('social_link_info', array(
        'title' => 'Social Media Info',
        'description' => 'Your social media information',
        'priority' => 110,
    ));
});

/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});

//change post to news
add_action( 'admin_menu', function() {
        global $menu;
        global $submenu;

        $menu[5][0] = 'News'; // Change Posts to News
        $submenu['edit.php'][5][0] = 'News';
        $submenu['edit.php'][10][0] = 'Add News';
});
add_action( 'init', function () {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;

        $labels->name = 'News';
        $labels->singular_name = 'News';
        $labels->add_new = 'Add News';
        $labels->add_new_item = 'Add News';
        $labels->edit_item = 'Edit News';
        $labels->new_item = 'News';
        $labels->view_item = 'View News';
        $labels->search_items = 'Search News';
        $labels->not_found = 'No News found';
        $labels->not_found_in_trash = 'No News found in Trash';
        $labels->all_items = 'All News';
        $labels->menu_name = 'News';
        $labels->name_admin_bar = 'News';

});

add_action('init', function () {
    register_taxonomy_for_object_type('post_tag', 'events');
});

//combine both posts(news) and events in one query
//add_action( 'pre_get_posts', function($query) {
//    $get_post_type = isset($_GET['post_type']) ? $_GET['post_type'] : ['post', 'events'];
//    if ( !is_admin() || ! $query->is_main_query()) {
//        $custom_fields = Utility::get_all_acf_custom_fields();
//        $custom_fields_args = [];
//        foreach($custom_fields as $key => $custom_field) {
//            $custom_fields_args[] = [
//                'key'       =>    $custom_field,
//                'value'     =>    get_search_query(),
//                'compare'   =>    'LIKE',
//            ];
//        }
//        $custom_fields_args['relation'] = 'OR';
//
//        if( count( $custom_fields_args ) > 0 ) {
//            $query->set('meta_query', $custom_fields_args);
//        }
//    }
//});

