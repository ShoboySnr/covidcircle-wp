<?php

namespace App\Controllers;

use Sober\Controller\Controller;
use function App\asset_path;

class Utility extends Controller
{
    public static function limitStr($string, $limit = 100) {
        if(strlen($string) >= $limit) {
            return html_entity_decode(str_limit($string, $limit));
        }

        return html_entity_decode($string);
    }

    public static function geCustomCategories($categories = [])
    {
        $return_data = [];

        $args = [
            'taxonomy'      => $categories,
            'hide_empty'    => true,
            'parent' => 0
        ];

        if(empty($categories)) {
            return [];
        }

        $terms = get_terms($args);

        if(!empty($terms)) {
            foreach ($terms as $key => $value) {
                if(isset($value->term_id)) {
                    $return_data[$key]['id'] = $value->term_id;
                    $return_data[$key]['slug'] = $value->slug;
                    $return_data[$key]['name'] = $value->name;
                    $return_data[$key]['category'] = $value->taxonomy;
                    $return_data[$key]['link'] = get_category_link($value->term_id);
                }
            }
        } else return $return_data;

        return $return_data;
    }

    public static function getSingleCustomCategory($category, $default_term_slug = [], $post_id = '')
    {
        global $post;

        if(!empty($post_id)) $post = $post_id;

        $return_data = [];
        if(empty($category)) {
            return [];
        }

        $terms = get_the_terms($post, $category);

        if($terms) {
            foreach ( $terms as $key => $value ) {
                $return_data[ $key ]['id']       = $value->term_id;
                $return_data[ $key ]['slug']     = $value->slug;
                $return_data[ $key ]['name']     = $value->name;
                $return_data[ $key ]['category'] = $value->taxonomy;
                $return_data[ $key ]['link']     = get_category_link( $value->term_id );
            }
        } else {
           $return_data[0] = [
               'id'             => '',
               'slug'           => '',
               'name'           => '',
               'category'       => '',
               'link'           => '',
           ];
        }

        return  $return_data;
    }

    public static function filterDocumentBackgroundImage($image_url, $term_id) {
        $default_path = get_field('default_image',  'term_' . $term_id);

        if(empty($default_path)) {
            return asset_path('images/resources-default.png');
        }

        if (empty($image_url)) {
            return $default_path;
        }

        return $image_url;
    }

    public static function get_the_date_filter() {
        global $post;

        return get_the_date('l jS F Y', $post);
    }

    public static function getTagLists() {
        global $post;

        $tags = get_the_tags($post);
    }

    public static function getPostCategories($post_id = '')
    {
        global $post;

        if (!empty($post_id))  {
            $post = $post_id;
        }

        $return_data = [];
        $terms = get_the_category($post);

        foreach ( $terms as $key => $value ) {
            $return_data[ $key ]['id']       = $value->term_id;
            $return_data[ $key ]['slug']     = $value->slug;
            $return_data[ $key ]['name']     = $value->name;
            $return_data[ $key ]['category'] = $value->taxonomy;
            $return_data[ $key ]['link']     = get_category_link( $value->term_id );
        }

        return  $return_data;
    }

    public static function convert_to_theme_date($timestamps) {
        $dob1 = trim($timestamps);
        list($d, $m, $y) = explode('/', $dob1);
        $make_time = mktime(0, 0, 0, $m, $d, $y);

        return date('jS F Y', $make_time);;
    }

    public static function getTaxonomies() {
        $return_data = [];
        $taxonomies = get_taxonomies([], 'objects');
        unset($taxonomies['nav_menu'], $taxonomies['post_tag'], $taxonomies['link_category'], $taxonomies['post_format'], $taxonomies['resources_types']);

        foreach($taxonomies as $key => $value) {
                $return_data[$key]['slug'] = $value->name;
                $return_data[$key]['name'] = $value->label;
        }

        return $return_data;
    }

    public static function getAllPostCategories() {
        $categories = get_categories( array(
            'taxonomy'   => 'category',
            'orderby'    => 'name',
            'parent'     => 0,
            'hide_empty' => 0,
        ) );
    }

    public static function getAllDates($post_type = []) {
        $current_month = '';

        $args = [
            'post_type'     => $post_type,
            'meta_key'      => 'events_date',
            'meta_compare' => '>',
            'meta_value' => date ('2011-01-01'),
            'meta_type'  => 'DATE',
            'post_status' => 'publish',
            'posts_per_page' => '-1',
            'orderby' => 'meta_value',
            'order' => 'DESC'
        ];

        $query_posts = new \WP_Query($args);
    }

    public static function get_all_custom_post_types() {
        $return_data = [];
        $args = [
            'public'    => true,
        ];

        $post_types = get_post_types($args, 'object', 'or');

        $filter_array = ['attachment'];

        foreach($post_types as $key => $post_type) {
            if(!in_array($post_type->name, $filter_array)) {
                $return_data[$key]['name'] =  $post_type->label;
                $return_data[$key]['slug'] =  $post_type->name;
            }
        }

        return $return_data;
    }

    public static function getTaxonomiesList($post_type) {
        $return_data = [];
        $taxonomies = get_object_taxonomies($post_type, 'object');
        unset($taxonomies['nav_menu'], $taxonomies['post_tag'], $taxonomies['link_category'], $taxonomies['post_format'], $taxonomies['resources_types']);

        foreach($taxonomies as $key => $value) {
            $return_data[$key]['slug'] = $value->name;
            $return_data[$key]['name'] = $value->label;
        }

        return $return_data;
    }

    public static function get_networks() {
        //get all posts that has the taxonomy
        $args = [
            'post_type' => 'network_types',
            'numberposts' => -1,
        ];
        $contents = get_posts($args);

        $show_contents = [];
        foreach($contents as $key => $value) {
            $show_contents[$key]['id']    = $value->ID;
            $show_contents[$key]['title']    = $value->post_title;
            $show_contents[$key]['slug']    = $value->post_name;
            $show_contents[$key]['image']    = get_the_post_thumbnail_url($value->ID);
            $show_contents[$key]['link']     = get_field('network_link', $value->ID);
            $show_contents[$key]['organisation_name']     = get_field('organisation_name', $value->ID);
            $show_contents[$key]['themic_area']     = get_field('themic_area', $value->ID);
            $show_contents[$key]['content']   = $value->post_content;
        }

        $return_data['contents'] = $show_contents;
        $return_data['regions'] = [];

        return $return_data;
    }

    public static function return_details_of_terms($term_name, $taxonomy = 'categories') {
        $return_data = [];

        $continents = get_term_by('name', $term_name, $taxonomy);
        $term_id = $continents->term_id;

        //get the sub categories of the taxonomy
        $terms_args = [
            'parent'        => $term_id,
            'hide_empty'    => false,
            'include_parent'    => false,
        ];
        $terms = get_terms($taxonomy, $terms_args);

        $regions = [];
        foreach ( $terms as $key => $value ) {
            if ($value->parent != 0) {
                $regions[ $key ]['id']       = $value->term_id;
                $regions[ $key ]['slug']     = $value->slug;
                $regions[ $key ]['name']     = $value->name;
                $regions[ $key ]['category'] = $value->taxonomy;
                $regions[ $key ]['link']     = get_category_link( $value->term_id );
            }
        }

        $return_data['regions'] = $regions;

        //get all posts that has the taxonomy
        $args = [
            'post_type' => 'network_types',
            'numberposts' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term_id,
                )
            )
        ];
        $contents = get_posts($args);

        $show_contents = [];
        foreach($contents as $key => $value) {
            $show_contents[$key]['id']    = $value->ID;
            $show_contents[$key]['title']    = $value->post_title;
            $show_contents[$key]['slug']    = $value->post_name;
            $show_contents[$key]['image']    = get_the_post_thumbnail_url($value->ID);
            $show_contents[$key]['link']     = get_field('network_link', $value->ID);
            $show_contents[$key]['organisation_name']     = get_field('organisation_name', $value->ID);
            $show_contents[$key]['themic_area']     = get_field('themic_area', $value->ID);
            $show_contents[$key]['content']   = $value->post_content;
        }

        $return_data['contents'] = $show_contents;

        return $return_data;
    }

    public static function return_details_of_regions($term_name, $parent_term_name, $taxonomy = 'categories') {
        $return_data = [];

        //get all posts that has the taxonomy
        $continents = get_term_by('name', $parent_term_name, $taxonomy);
        $term_id = $continents->term_id;

        $args = [
            'post_type' => 'network_types',
            'numberposts' => -1,
            'tax_query' => [
                [
                    'taxonomy' => $taxonomy,
                    'field' => 'term_id',
                    'terms' => $term_id,
                ]
            ],
        ];
        if(empty($term_id)) {
            $args = [
                'post_type' => 'network_types',
                'numberposts' => -1,
            ];
        }

        if(!empty($term_name)) {
            $args['tax_query'][] = [
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $term_name,
            ];
        }
        $contents = get_posts($args);

        foreach($contents as $key => $value) {
            $return_data[$key]['id']    = $value->ID;
            $return_data[$key]['title']    = $value->post_title;
            $return_data[$key]['slug']    = $value->post_name;
            $return_data[$key]['image']    = get_the_post_thumbnail_url($value->ID);
            $return_data[$key]['link']     = get_field('network_link', $value->ID);
            $return_data[$key]['organisation_name']     = get_field('organisation_name', $value->ID);
            $return_data[$key]['themic_area']     = get_field('themic_area', $value->ID);
            $return_data[$key]['content']   = $value->post_content;
        }

        return $return_data;
    }

    public static function getTaxonomiesAttachedToPostType($post_type = 'post') {
        $return_data = [];
        $taxonomies = get_object_taxonomies($post_type, 'object');
        unset($taxonomies['nav_menu'], $taxonomies['post_tag'], $taxonomies['link_category'], $taxonomies['post_format'], $taxonomies['resources_types']);

        foreach($taxonomies as $key => $value) {
            $return_data['slug'] = $value->name;
            $return_data['name'] = $value->label;
            $return_data['post_type'] = $post_type;
        }

        return $return_data;
    }

    public static function return_category_subcategory() {
        global $post;
        $return_data = [];

        $post_type = get_post_type(get_the_ID());
        $taxonomies = get_object_taxonomies($post_type, 'names');
        $terms = [];
        foreach($taxonomies as $key => $taxonomy) {
            $terms[] = (array) get_the_terms($post, $taxonomy, array("fields" => "names"));
        }


        foreach($terms as $key => $value) {
            $return_data[$key]['slug'] = isset($value[0]->slug) ? $value[0]->slug : '';
            $return_data[$key]['name'] = isset($value[0]->name) ? $value[0]->name : '';
        }

        return $return_data;
    }

    public static function sort_date_by_events_news($date = []) {
        usort($date, function($a, $b) {
            $t1 = strtotime($a['date']);
            $t2 = strtotime($b['date']);
            return $t2 - $t1;
        });

        return $date;
    }

    public static function sort_date_and_events_wp_query($query) {
        $posts = $query->posts;
        $return_query = [];
        foreach($posts as $key => $value) {
            $event_start_date = Utility::switch_date(get_field('event_date', $value->ID));
//            $event_end_date = Utility::switch_date(get_field('event_end_date', $value->ID));
            $return_query[$key]['id']       = $value->ID;
            $return_query[$key]['title']    = $value->post_title;
            $return_query[$key]['content']    = strip_tags($value->post_content);
            $return_query[$key]['type']    = $value->post_type;
            if($value->post_type === 'events') {

                $return_query[$key]['date'] = $event_start_date;
            } else {
                $return_query[$key]['date'] = self::switch_date(date('d/m/Y', strtotime($value->post_date)));
            }
            $return_query[$key]['featured_image'] = get_the_post_thumbnail_url($value->ID);
            $return_query[$key]['link'] = get_the_permalink($value->ID);
            $return_query[$key]['categories'] =  isset(Utility::getPostCategories($value->ID)[0]) ?  Utility::getPostCategories($value->ID)[0]['name'] : '';
        }

        return self::sort_date_by_events_news($return_query);
    }

    public static function get_filter_date($post_type = ['post', 'events']) {
        $args = [
            'post_type'             => $post_type,
            'posts_per_page'        => -1,
        ];

        $posts = new \WP_Query($args);

        $return_query = [];
        foreach($posts->posts as $key => $value) {
            $return_query[$key]['id']       = $value->ID;
            if($value->post_type === 'events') {

                $return_query[$key]['date'] = get_field('event_date', $value->ID);
            } else {
                $return_query[$key]['date'] = date('d/m/Y', strtotime($value->post_date));
            }
        }

        $return_query = self::sort_date_by_events_news($return_query);

        $return_dates = [];
        foreach($return_query as $key => $value) {
            $event_month = date('F Y', strtotime($value['date']));

            if(!in_array($event_month, $return_dates) && !empty($value['date'])) {
                $return_dates[strtotime($event_month)] = $event_month;
            }
        }

        return array_unique($return_dates);
    }

    public static function switch_date($date) {
        if(!empty($date)) {
            $explode_date = explode('/', $date);
            $tmp = $explode_date[2];
            $explode_date[2] = $explode_date[0];
            $explode_date[0] = $tmp;
            unset($tmp);


            return implode('/', $explode_date);
        } else return "";
    }


    public static function get_tomorrow_date() {
        return strtotime("-1 day");
    }

    public static function get_first_and_last_day_month($time) {
        return [
            'first_date'    => strtotime(date('Y-m-01', $time)),
            'last_date'    => strtotime(date('Y-m-t', $time)),
        ];
    }

    public static function get_dates_by_posts($get_first_last_dates) {
        $dates_args = [
            [
                'after'     => date('Y-m-d', $get_first_last_dates['first_date']),
                'before'    => date('Y-m-d', $get_first_last_dates['last_date']),
                'inclusive' => true,
            ]
        ];

         return $dates_args;
    }

    /**
     * @return array|object|null
     */
    public static function get_all_meta_fields($type)
    {
        global $wpdb;
        $result = $wpdb->get_results($wpdb->prepare(
            "SELECT post_id,meta_key,meta_value FROM wp_posts,wp_postmeta WHERE post_type = %s
                    AND wp_posts.ID = wp_postmeta.post_id", $type
        ), ARRAY_A);
        return $result;
    }

    /**
     * @return array
     */
    public static function get_acf_custom_fields()
    {
        $options = [];
        $acf = Utility::get_all_meta_fields('acf');
        foreach($acf as $key => $value){
            $options['post_type'][$value['post_id']]['post_id'] = $value['post_id'];
            $test = substr($value['meta_key'], 0, 6);
            if($test === 'field_'){
                $post_types = maybe_unserialize( $value['meta_value'] );
                $options['post_type'][$value['post_id']]['key'][] = $post_types['key'];
                $options['post_type'][$value['post_id']]['key'][] = $post_types['name'];
                $options['post_type'][$value['post_id']]['key'][] = $post_types['type'];
            }
            if($value['meta_key'] == 'rule'){
                $post_types = maybe_unserialize( $value['meta_value'] );

                $options['post_type'][$value['post_id']]['post_types'] = $post_types['value'];
            }
        }
        return $options;
    }

    public static function get_all_acf_custom_fields() {
        $return_data = [];
        $post_types = get_post_types([], 'names');

        $args = [
            'post_type'     => $post_types,
            'numberposts'   => -1
        ];

        $all_posts = get_posts($args);

        foreach($all_posts as $key => $post) {
//            $metas = get_post_meta($post->ID);
//            foreach($metas as $meta_key => $value) {
//                $return_data[$meta_key] = $meta_key;
//            }
//            $acf_objects = get_field_objects($post->ID);
//
//            if($acf_objects && is_array($acf_objects)) {
//
//                foreach($acf_objects as $acf_key => $acf_object) {
//                    if($acf_object['type'] == 'group') {
//                        foreach($acf_object['value'] as $value_key => $value_subtext) {
//                            $return_data[$value_key] = $value_key;
//                        }
//                    }
//                    $return_data[$acf_object['name']] = $acf_object['name'];
//                }
//            }
        }

        return $return_data;
    }
}
