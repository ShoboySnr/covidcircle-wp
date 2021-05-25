<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class AboutUs extends Controller
{
    public static function get_contents() {
        global $post;
        $post_id = $post->ID;

        $returnData = [];
        //get the page title
        $returnData['page_title'] = get_field('page_title', $post_id);

        //get the section one
        $section_one = get_field('section_one', $post_id);
        $returnData['section_one'] = [
            'top_title'         => get_field('section_one_top_title', $post_id),
            'title'             => $section_one['title'],
            'image'             => get_field('section_one_image', $post_id),
            'content'           => $section_one['content'],
            'top_title_2'         => $section_one['top_title_2'],
            'title_2'             => $section_one['title_2'],
            'content_2'           => $section_one['content_2'],
        ];

        //get the section two
        $section_two = get_field('section_two', $post_id);
        $returnData['section_two'] = [
            'top_title'         => $section_two['top_title'],
            'title'         => $section_two['title'],
            'contents'         => $section_two['contents'],
            'image'         => App::filterDocumentBackgroundImage($section_two['featured_image']),
        ];

        //get the third section
        $section_three = get_field('section_three', $post_id);
        $returnData['section_three'] = [
            'title'             => $section_three['title'],
            'contents'          => $section_three['description'],
            'image'             => App::filterDocumentBackgroundImage($section_three['image']),
        ];

        //get the fourth section
        $section_three = get_field('section_four', $post_id);
        $returnData['section_four'] = [
            'title'             => $section_three['title'],
            'contents'          => $section_three['description'],
            'image'             => App::filterDocumentBackgroundImage($section_three['image']),
        ];

        //get the fifth section
        $section_three = get_field('section_five', $post_id);
        $returnData['section_five'] = [
            'title'             => $section_three['title'],
            'contents'          => $section_three['description'],
            'image'             => App::filterDocumentBackgroundImage($section_three['image']),
        ];

        //get the client section
        $returnData['clients'] = self::get_about_clients($post_id);

        $returnData['partnership'] = self::get_about_partnership($post_id);


        $returnData['funded_by'] = self::get_funded_by_logos($post_id);

        return array_filter($returnData);

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
                    'content'       => get_field('client_description', $get_logo['id']),
                ];
            }
        }

        return $funded_by;
    }


    public static function get_about_clients($post_id) {
        $clients = [];
        $funded_by = get_field('funded_by', $post_id);
        for ($i = 1; $i <= 6; $i++)
        {
            if(isset($funded_by['content_'.$i]) && !empty($funded_by['content_'.$i]) && !is_null($funded_by['content_'.$i]))
            {
                $clients[$i]['image'] = $funded_by['image_'.$i];
                $clients[$i]['content'] = $funded_by['content_'.$i];
            }
        }
        return array_filter($clients);
    }

    public static function get_about_partnership($post_id) {
        $return_partnership = [];
        $partnership = get_field('partnership', $post_id);

        if(!empty($partnership)) {
            $return_partnership = [
                'first_image'       => $partnership['first_logo'],
                'first_image_link'       => $partnership['first_logo_link'],
                'first_content'       => $partnership['first_content'],
                'second_image'       => $partnership['second_logo'],
                'second_image_link'       => $partnership['second_logo_link'],
                'second_content'       => $partnership['second_content'],
            ];
        }

        return array_filter($return_partnership);
    }

}
