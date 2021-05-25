<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Search Results for %s', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Not Found', 'sage');
        }
        return get_the_title();
    }

    public static function get_footer()
    {
        $returnData = [];
        $footer = get_page_by_path('footer');

        $returnData['mailchimp_shortcode'] = get_field('mailchimp_shortcode', $footer->ID);
        $returnData['title'] = get_field('footer_title', $footer->ID);
        $returnData['email'] = get_field('footer_email', $footer->ID);
        $returnData['phone_number'] = get_field('footer_phone_number', $footer->ID);
        $returnData['address'] = get_field('footer_address', $footer->ID);
        $returnData['copyrights'] = get_field('copyrights', $footer->ID);

        $returnData['logos'] = self::get_footer_logos($footer->ID);

        return $returnData;
    }

    public static function get_footer_logos($page_id) {
        $footer_logo = [];
        for ($i = 1; $i <= 2; $i++)
        {
            $footer_logo[$i]['footer_logo_link'] = get_field('footer_logo_link_'.$i, $page_id);
            $footer_logo[$i]['footer_logo'] = get_field('footer_logo_'.$i, $page_id);
        }

        return array_filter($footer_logo);
    }

    public static function filterCategory($categories = []) {
        $filteredCategory = [];
        if (empty($categories)) {
            return  [];
        }
        foreach($categories as $key => $category) {
            $filteredCategory[$key]['id'] = $category->term_id;
            $filteredCategory[$key]['name'] = $category->name;
            $filteredCategory[$key]['slug'] = $category->slug;
            $filteredCategory[$key]['link'] = get_category_link($category->term_id);
        }

        return $filteredCategory;
    }

    public static function filterDocumentBackgroundImage($image_url) {
        $default_path = \App\asset_path('images/resources-default.png');

        if (empty($image_url)) {
            return $default_path;
        }

        return $image_url;
    }
}
