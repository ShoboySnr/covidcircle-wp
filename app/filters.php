<?php

namespace App;

use App\Controllers\Utility;

/**
 * Add <body> classes
 */
add_filter('body_class', function (array $classes) {
    /** Add page slug if it doesn't exist */
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    /** Add class if sidebar is active */
    if (display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    /** Clean up class names for custom templates */
    $classes = array_map(function ($class) {
        return preg_replace(['/-blade(-php)?$/', '/^page-template-views/'], '', $class);
    }, $classes);

    return array_filter($classes);
});

/**
 * Add "… Continued" to the excerpt
 */
add_filter('excerpt_more', function () {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
});

/**
 * Template Hierarchy should search for .blade.php files, NB: no 404 page
 */
collect([
    'index', 'archive', 'author', 'category', 'tag', 'taxonomy', 'date', 'home',
    'frontpage', 'page', 'paged', 'search', 'single', 'singular', 'attachment', 'embed',
])->map(function ($type) {
    add_filter("{$type}_template_hierarchy", __NAMESPACE__.'\\filter_templates');
});

/**
 * Render page using Blade
 */
add_filter('template_include', function ($template) {
    collect(['get_header', 'wp_head'])->each(function ($tag) {
        ob_start();
        do_action($tag);
        $output = ob_get_clean();
        remove_all_actions($tag);
        add_action($tag, function () use ($output) {
            echo $output;
        });
    });
    $data = collect(get_body_class())->reduce(function ($data, $class) use ($template) {
        return apply_filters("sage/template/{$class}/data", $data, $template);
    }, []);
    if ($template) {
        echo template($template, $data);
        return get_stylesheet_directory().'/index.php';
    }
    return $template;
}, PHP_INT_MAX);

/**
 * Render comments.blade.php
 */
add_filter('comments_template', function ($comments_template) {
    $comments_template = str_replace(
        [get_stylesheet_directory(), get_template_directory()],
        '',
        $comments_template
    );

    $data = collect(get_body_class())->reduce(function ($data, $class) use ($comments_template) {
        return apply_filters("sage/template/{$class}/data", $data, $comments_template);
    }, []);

    $theme_template = locate_template(["views/{$comments_template}", $comments_template]);

    if ($theme_template) {
        echo template($theme_template, $data);
        return get_stylesheet_directory().'/index.php';
    }

    return $comments_template;
}, 100);

/**
 * Fix Search form
 *
 */
add_filter('get_search_form', function($form) {
    $return_types = [];
    $types = Utility::get_all_custom_post_types();
    $content_type = isset($_GET['content_type']) ? $_GET['content_type'] : '';
    $get_category = isset($_GET['category']) ? $_GET['category'] : '';
    $get_sub_category = isset($_GET['sub_category']) ? $_GET['sub_category'] : '';

    $categories_main = [];
    if(!empty($content_type)) {
        $categories_main =  Utility::geCustomCategories($content_type);
    }

    $resources_types = [];
    if($content_type === 'resources_categories') {
        $resources_types = Utility::geCustomCategories('resources_types');
    }

    foreach ($types as $key => $type) {
        $return_types[$key]['name'] = $type['name'] === 'Posts' ? 'News' : $type['name'];
        $taxonomies = get_object_taxonomies($type['slug'], 'names');
        unset($taxonomies['nav_menu'], $taxonomies['post_tag'], $taxonomies['link_category'], $taxonomies['post_format'], $taxonomies['resources_types']);
        if(isset($taxonomies[0]) && $taxonomies[0]  === 'post_tag') {
            $get_taxonomy = $taxonomies[1];
        } else if(isset($taxonomies[0])) {
            $get_taxonomy = $taxonomies[0];
        } else $get_taxonomy = $type['slug'];

        $return_types[$key]['slug'] = $get_taxonomy;
    }

    $form = '<div class="search-section">
        <form role="search" method="get" id="search-form" action="' . home_url( '/' ) . '" >
        <div class="search-group">
            <label for="s">
                <input type="search" value="' . get_search_query() . '" name="s" id="s" placeholder="Enter your search term here" />
            </label>
            <input type="submit" id="searchsubmit" value="'. esc_attr__('Search', 'covid-circle-wp') .'" />
        </div>
        <div class="category-search-group flex justify-start items-center">
           <p>'.esc_attr__('Filter by:', 'covid-circle-wp').'</p>
           <select class="select-control" name="content_type" id="resources_types">
                <option value="" selected>'. esc_attr__('Content type', 'covid-circle-wp'). '</option>';
                foreach ($return_types as $type) {
                    $selected = $type['slug'] == $content_type ? 'selected' : '';
                    $form .= '<option value="'.$type['slug'] .'" '. $selected .'>'.$type['name'].'</option>';
                }
                $form .= '</select>
            <select class="select-control" name="category" id="category_slug">
                            <option value="">'. esc_attr__('Category', 'covid-circle-wp'). '</option>';
                if(!empty($categories_main)) {
                    foreach ($categories_main as $category) {
                        $selected = $category['category'].','.$category['slug'] == $get_category ? 'selected' : '';
                        $form .= '<option value="'. $category['category'].','.$category['slug'] .'"'. $selected .'>'.$category['name'].'</option>';
                    }
                }
                $form .= '</select>
                <select class="select-control" name="sub_category" id="sub_category_slug">
                            <option value="">'. esc_attr__('Sub Category', 'covid-circle-wp'). '</option>';
                if(!empty($resources_types)) {
                    foreach ($resources_types as $category) {
                        $selected = $category['category'].','.$category['slug'] == $get_sub_category ? 'selected' : '';
                        $form .= '<option value="'. $category['category']. ','.$category['slug'] .'"'. $selected .'>'.$category['name'].'</option>';
                    }
                }
    $form .= '</select>
        </div>
     </form></div>';
    return $form;
});

//return other posts in key doesn't exists
add_filter('get_meta_sql', function($clauses) {
    global $wp_query;

    // check for order by custom_order
    if ($wp_query->get('meta_key') == 'events_date' && $wp_query->get('orderby') == 'meta_value')
    {
        // change the inner join to a left join,
        // and change the where so it is applied to the join, not the results of the query
        $clauses['join'] = str_replace('INNER JOIN', 'LEFT JOIN', $clauses['join']).$clauses['where'];
        $clauses['where'] = '';
    }
    return $clauses;
}, 10, 1);

add_filter('posts_orderby', function($orderby) {
    global $wp_query, $wpdb;

    // check for order by custom_order
    if ($wp_query->get('meta_key') == 'custom_order' && $wp_query->get('orderby') == 'meta_value_num')
    {
        $orderby = "{$wpdb->postmeta}.meta_value='', ".$orderby;
    }
    return $orderby;
}, 10, 1);

//remove the current page css in menu
add_filter( 'nav_menu_css_class', function($classes, $item) {
    if(is_post_type_archive( 'resources_hub' ) || is_singular( 'resources_hub' )) {
        $classes = array_diff( $classes, array( 'current_page_parent' ) );
    }
    return $classes;
}, 10, 2 );

add_filter('filter_pagination', function($pagination_links, $current_page) {
    $return_pagination = [];
    if(!empty($pagination_links)) {
        $number_of_pages = count($pagination_links);
        foreach($pagination_links as $key => $pagination) {
            if ($key == 0) {
                $return_pagination[$key] = $pagination;
            }
            else if ($current_page == 1 & ($key == $current_page || $key == $current_page + 1 || $key == $current_page + 2)) {
                $return_pagination[$key] = $pagination;
            }  else if ($current_page != 1 & ($key == $current_page || $key == $current_page + 1 || $key == $current_page + 2)) {
                $return_pagination[$key] = $pagination;
            }
            else if($key == ($number_of_pages - 1)) {
                $return_pagination[$key] = $pagination;
            }
        }
    }
    return $return_pagination;
}, 100, 2);

//register search query variables
//add_filter( 'query_vars', function($vars) {
//    $vars[] = 'content_type';
//    $vars[] = 'category';
//    $vars[] = 'sub_category';
//    return $vars;
//} );

