<?php
global $wp_query;

$sticky = get_option( 'sticky_posts' );
$paged = (get_query_var('paged')) ? get_query_var( 'paged' ) : 1;
$categories_types = isset($_GET['categories_types']) ?  $_GET['categories_types'] : NULL;
$get_events_dates = isset($_GET['events_dates']) ?  $_GET['events_dates'] : '';
$get_news_dates = isset($_GET['news_dates']) ?  $_GET['news_dates'] : '';

$post_type = !empty($_GET['post_type']) ? explode(',', $_GET['post_type']) : ['post', 'events'];

//get categories
$selected_categories = ['category', 'events_categories'];
if($post_type === 'post') {
  $selected_categories = 'category';
} else if($post_type === 'events') {
  $selected_categories = 'events_categories';
}

$categories = Utility::geCustomCategories($selected_categories);
$filter_dates = Utility::geCustomCategories($selected_categories);

$sticky_args = [
  'post_type'      => ['post', 'events'],
  'posts_per_page'  => 1,
  'post__in'        => $sticky,
  'ignore_sticky_posts' => 0
];

$no_sticky_args = [
  'post_type'      => ['post', 'events'],
  'posts_per_page'  => 1,
];

$args = [
  'post_type'      => $post_type,
  'paged'           => $paged,
  'post__not_in'    => $sticky,
  'ignore_sticky_posts' => 1,
  'tax_query'           => [],
  'order'				=> 'DESC',
];

if(!empty($categories_types)) {
  $categories_types_args = [
    [
      'taxonomy' => 'category',
      'field' => 'slug',
      'terms' => $categories_types,
    ],
    'relation'    => 'OR',
    [
      'taxonomy' => 'events_categories',
      'field' => 'slug',
      'terms' => $categories_types,
    ],
  ];
  $args['tax_query'] = array_merge($categories_types_args, $args['tax_query']);
}

if(!empty($get_events_dates) && !empty($get_news_dates)) {
  $get_first_last_events_dates = Utility::get_first_and_last_day_month($get_events_dates);
  $get_first_last_news_dates = Utility::get_first_and_last_day_month($get_news_dates);
  $date_event_range = [
    date('Y-m-d', $get_first_last_events_dates['first_date']),
    date('Y-m-d', $get_first_last_events_dates['last_date']),
  ];
  $date_news_range = [
    date('Y-m-d', $get_first_last_news_dates['first_date']),
    date('Y-m-d', $get_first_last_news_dates['last_date']),
  ];
  $events_date_args  = [
    'relation'  => 'OR',
    [
      'key'     => 'event_date',
      'value'   => $date_event_range,
      'compare' => 'BETWEEN',
      'type'    => 'date',
    ],
    [
      'key'     => 'date_query',
      'value'   => $date_news_range,
      'compare' => 'BETWEEN',
      'type'    => 'date',
    ]
  ];
  $args['meta_query'] = $events_date_args;
} else if(!empty($get_events_dates)) {
  $get_first_last_dates = Utility::get_first_and_last_day_month($get_events_dates);
  $args['post_type'] = 'events';
  $date_range = [
    date('Y-m-d', $get_first_last_dates['first_date']),
    date('Y-m-d', $get_first_last_dates['last_date']),
  ];
  $events_date_args  = [
    [
      'key'     => 'event_date',
      'value'   => $date_range,
      'compare' => 'BETWEEN',
      'type'    => 'date',
    ],
  ];
  $args['meta_query'] = $events_date_args;
} else if(!empty($get_news_dates)) {
  $get_first_last_dates = Utility::get_first_and_last_day_month($get_news_dates);
  $args['post_type'] = 'post';
  $args['date_query'] = Utility::get_dates_by_posts($get_first_last_dates);
}

$stickyquery = new WP_Query($sticky_args);
$nosticky_query = new WP_Query($no_sticky_args);
$wp_query = new WP_Query($args);


?>
@extends('layouts.app')

@section('content')
  @if($wp_query->have_posts())
    @include('partials.content-'.get_post_type())
  @endif
  @if(!$wp_query->have_posts())
    @include('partials.empty', ['title' => 'Posts'])
  @endif
@endsection
