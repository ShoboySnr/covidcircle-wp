<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class FrontPage extends Controller
{

    public static function home_page_fields()
    {
        $return_data = [];
        $frontpage_id = get_option( 'page_on_front' );

        //get the fields
        $post = get_post($frontpage_id);

        $return_data['slides'] = self::get_home_sliders($post->ID);

        $return_data['clients'] = self::get_funded_by_logos($post->ID);

        $return_data['introducing_video'] = get_field('introducing_video', $frontpage_id);
        $return_data['introducing_short_video'] = get_field('introducing_short_video', $frontpage_id);

        //featured home posts
        $return_data['featured_home'] = self::get_featured_home($frontpage_id);

        $return_data['resources_hub'] = self::get_home_resources();

        $return_data['news_and_events'] = self::get_news_and_events();

        return array_filter($return_data);
    }


    public static function get_funded_by_logos($post_id) {
        $funded_by = [];
        $get_logos = acf_photo_gallery('funded_by_logo', $post_id);

        if(!empty($get_logos)) {
            foreach($get_logos as $get_logo) {
                $funded_by[] = [
                    'id'            => $get_logo['id'],
                    'title'         => $get_logo['title'],
                    'image'         => $get_logo['full_image_url'],
                    'link'       => get_field('client_url', $get_logo['id']),
                    'target'       => $get_logo['target'],
                ];
            }
        }

        return $funded_by;
    }

    public static function get_news_and_events() {
        $sticky = get_option( 'sticky_posts' );

        $stickyargs = [
            'post_type'             => ['post', 'events'],
            'posts_per_page'        => 1,
            'post__in'              => $sticky,
            'ignore_sticky_posts'   => 0
        ];

        $args = [
            'post_type'             => ['post', 'events'],
            'posts_per_page'        => 5,
            'order'                 => 'DESC',
            'post__not_in'          => $sticky,
            'orderby'               => 'meta_value',
            'meta_query'            => [
                    [
                        'value' => date('Y-m-d', strtotime('+2 years')),
                        'compare' => '<=',
                        'type' => 'DATE',
                    ]
            ]
        ];

        $stickyposts = new \WP_Query($stickyargs);
        $posts = new \WP_Query($args);

        $sticky_news_events = [];
        if($stickyposts->have_posts()) {
            foreach($stickyposts->posts as $key => $value) {
                if(is_sticky($value->ID)) {
                    $event_start_date = Utility::switch_date(get_field('event_date', $value->ID));
                    $event_end_date = Utility::switch_date(get_field('event_end_date', $value->ID));
                    $sticky_news_events[$key]['id']       = $value->ID;
                    $sticky_news_events[$key]['title']    = $value->post_title;
                    $sticky_news_events[$key]['content']    = strip_tags($value->post_content);
                    $sticky_news_events[$key]['type']    = $value->post_type;
                    if($value->post_type === 'events') {

                        $sticky_news_events[$key]['date'] = $event_start_date;
                    } else {
                        $sticky_news_events[$key]['date'] = Utility::switch_date(date('d/m/Y', strtotime($value->post_date)));
                    }
                    $sticky_news_events[$key]['featured_image'] = get_the_post_thumbnail_url($value->ID);
                    $sticky_news_events[$key]['link'] = get_the_permalink($value->ID);
                    $sticky_news_events[$key]['categories'] =  isset(Utility::getPostCategories($value->ID)[0]) ?  Utility::getPostCategories($value->ID)[0]['name'] : '';
                    if(!empty($event_end_date)) {
                        if(strtotime($event_end_date) < Utility::get_tomorrow_date()) {
                            $sticky_news_events[$key]['ended'] = true;
                        }
                    } else if(strtotime($event_start_date) < Utility::get_tomorrow_date()) {
                        $sticky_news_events[$key]['ended'] = true;
                    }
                }
               }
        }

        $news_events = [];
        foreach($posts->posts as $key => $value) {
            $event_start_date = Utility::switch_date(get_field('event_date', $value->ID));
            $event_end_date = Utility::switch_date(get_field('event_end_date', $value->ID));
            $news_events[$key]['id']       = $value->ID;
            $news_events[$key]['title']    = $value->post_title;
            $news_events[$key]['content']    = strip_tags($value->post_content);
            $news_events[$key]['type']    = $value->post_type;
            if($value->post_type === 'events') {
                $news_events[$key]['date'] = $event_start_date;
            } else {
                $news_events[$key]['date'] = Utility::switch_date(date('d/m/Y', strtotime($value->post_date)));
            }
            $news_events[$key]['featured_image'] = get_the_post_thumbnail_url($value->ID);
            $news_events[$key]['link'] = get_the_permalink($value->ID);
            $news_events[$key]['categories'] =  isset(Utility::getPostCategories($value->ID)[0]) ?  Utility::getPostCategories($value->ID)[0]['name'] : '';
            if(!empty($event_end_date)) {
                if(strtotime($event_end_date) < Utility::get_tomorrow_date()) {
                    $news_events[$key]['ended'] = true;
                }
            } else if(strtotime($event_start_date) < Utility::get_tomorrow_date()) {
                $news_events[$key]['ended'] = true;
            }
        }

        $news_events = Utility::sort_date_by_events_news($news_events);

        wp_reset_postdata();

        if(!empty($sticky_news_events)) {
            $news_events = array_merge($sticky_news_events, $news_events);

            $lastvalue = end($news_events);
            $lastkey = key($news_events);
            $new_array = array($lastkey=>$lastvalue);

            array_pop($news_events);

            $news_events = array_merge($news_events, $new_array);
        }

        $data['news_and_events'] = array_slice($news_events, 0, 5);
        $data['more_link'] = get_permalink(get_option('page_for_posts'));

        return $data;
    }


    public static function get_home_sliders($post_id) {
        $slides = [];
        for ($i = 1; $i <= 3; $i++)
        {
            $slider = get_field('slider_'.$i, $post_id);
            if(isset($slider['title']) && !empty($slider['title']) && !is_null($slider['title']))
            {
                $slides[$i]['subtitle'] = $slider['subtitle'];
                $slides[$i]['title']    = $slider['title'];
                $slides[$i]['link']     = $slider['link'];
                $slides[$i]['image']    = $slider['image'];
                $slides[$i]['logos']    = acf_photo_gallery('slider_logo_'.$i, $post_id);
            }
        }

        return array_filter($slides);
    }

    public static function get_home_resources() {
        $sticky = get_option( 'sticky_posts' );

        $stickyargs = [
            'post_type'             => ['resource_hub'],
            'posts_per_page'        => 1,
            'post__in'              => $sticky,
            'ignore_sticky_posts'   => 0
        ];

        $args = [
            'post_type'     => 'resource_hub',
            'numberofposts'         => 10,
        ];


        $stickyposts = new \WP_Query($stickyargs);
        $posts = get_posts($args);

        $sticky_resources = [];
        if($stickyposts->have_posts()) {
            foreach($stickyposts->posts as $key => $value) {
                if(is_sticky($value->ID)) {
                    $types = Utility::getSingleCustomCategory('resources_types', 'documents', $value->ID);
                    $featured_image = Utility::filterDocumentBackgroundImage(get_the_post_thumbnail_url($value->ID), $types[0]['id']);
                    $sticky_resources[$key]['id']       = $value->ID;
                    $sticky_resources[$key]['title']    = $value->post_title;
                    $sticky_resources[$key]['featured_image'] = $featured_image;
                    $sticky_resources[$key]['link'] = get_the_permalink($value->ID);
                    $sticky_resources[$key]['categories'] = App::filterCategory(get_the_terms($value->ID, 'resources_categories')) ? App::filterCategory(get_the_terms($value->ID, 'resources_categories'))[0] : self::get_default_taxonomy('resources_categories', '');
                    $sticky_resources[$key]['types'] = App::filterCategory(get_the_terms($value->ID, 'resources_types')) ? App::filterCategory(get_the_terms($value->ID, 'resources_types'))[0] : self::get_default_taxonomy('resources_types', 'documents');
                }
            }
        }

        $resources = [];
        foreach($posts as $key => $value) {
            $types = Utility::getSingleCustomCategory('resources_types', 'documents', $value->ID);
            $featured_image = Utility::filterDocumentBackgroundImage(get_the_post_thumbnail_url($value->ID), $types[0]['id']);
            $resources[$key]['id']       = $value->ID;
            $resources[$key]['title']    = $value->post_title;
            $resources[$key]['featured_image'] = $featured_image;
            $resources[$key]['link'] = get_the_permalink($value->ID);
            $resources[$key]['categories'] = App::filterCategory(get_the_terms($value->ID, 'resources_categories')) ? App::filterCategory(get_the_terms($value->ID, 'resources_categories'))[0] : self::get_default_taxonomy('resources_categories', '');
            $resources[$key]['types'] = App::filterCategory(get_the_terms($value->ID, 'resources_types')) ? App::filterCategory(get_the_terms($value->ID, 'resources_types'))[0] : self::get_default_taxonomy('resources_types', 'documents');

        }

        if(!empty($sticky_resources)) {
            $resources = array_merge($sticky_resources, $resources);
        }

        $data['resources'] = $resources;
        $data['more_link'] = get_permalink(get_page_by_path('resource-hub'));

        return $data;
    }

    public static function get_featured_home($frontpage_id) {
        return [
            'image'             => get_field('image', $frontpage_id),
            'coloured_text'     => get_field('coloured_text', $frontpage_id),
            'content'           => get_field('content', $frontpage_id),
            'link'              => get_field('link', $frontpage_id)
        ];
    }

    public static function get_default_taxonomy($category, $default_term_slug = 'uncategoized') {
        $default_term = get_term_by('slug', $default_term_slug, $category);
        $return_data = [];
        if($default_term) {
            $return_data = [
                'id'             => $default_term->term_id,
                'slug'           => $default_term->slug,
                'name'           => $default_term->name,
                'category'       => $default_term->taxonomy,
                'link'           => get_category_link( $default_term->term_id ),
            ];
        }


        return $return_data;
    }

    public static function get_homepage_clients($post_id) {
        $clients = [];
        $client_logo = get_field('clients', $post_id);
        for ($i = 1; $i <= 7; $i++)
        {
            if(isset($client_logo['client_logo_'.$i]['url']) && !empty($client_logo['client_logo_'.$i]['url']) && !is_null($client_logo['client_logo_'.$i]['url']))
            {
                $clients[$i]['image'] = $client_logo['client_logo_'.$i];
                $clients[$i]['link'] = $client_logo['link_'.$i];
            }
        }

        return array_filter($clients);
    }
}
