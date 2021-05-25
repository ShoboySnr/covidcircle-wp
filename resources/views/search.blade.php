<?php
global $wp_query;
$thesearch = get_search_query();
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$content_type = $_GET['content_type']  ? $_GET['content_type'] : '';
$category = $_GET['category'] ? $_GET['category'] : '';
$sub_category = $_GET['sub_category'] ? $_GET['sub_category'] : '';

$args = [
  's'   => $thesearch,
  'paged'           => $paged,
  'meta_query'    => [],
];

//get all post types
$args['post_type'] = get_post_types([], 'names');


if(!empty($content_type)) {
  $content_type_args = [
    'taxonomy' => $content_type,
    'operator' => 'EXISTS'
  ];
  $args['tax_query'][] = $content_type_args;
}

if(!empty($category)) {
  $category = explode(',', $category);
  $category_args = [
    'taxonomy' => $category[0],
    'field' => 'slug',
    'terms' => $category[1],
  ];
  $args['tax_query'][] = $content_type_args;
}

if(!empty($sub_category)) {
  $sub_category = explode(',', $sub_category);
  $content_type_args = [
    'taxonomy' => $sub_category[0],
    'field' => 'slug',
    'terms' => $sub_category[1],
  ];
  $args['tax_query'][] = $content_type_args;
}

$custom_fields = Utility::get_all_acf_custom_fields();
if(!empty($custom_fields)) {
  $custom_fields_args = [];
  foreach($custom_fields as $key => $custom_field) {
    echo $custom_field.'<br />';
    $custom_fields_args[] = [
      'key'       =>    $custom_field,
      'value'     =>    $thesearch,
      'compare'   =>    'LIKE',
    ];
  }

  $args['meta_query']['relation'] =  'OR';
  $args['meta_query'] =  array_merge($args['meta_query'], $custom_fields_args);
}

$wp_query = new WP_Query($args);


?>
@extends('layouts.app')

@section('content')
  @include('partials.page-header-search')

  @if (!$wp_query->have_posts())
    <section id="notfound">
      <div class="container">
        <div class="alert-container alert alert-warning">
          {{ __('Sorry, no results were found.', 'covid-circle-wp') }}
        </div>
      </div>
    </section>
  @endif

  @if($wp_query->have_posts())
    @include('partials.content-search', ['query' => $wp_query, ['thesearch' => $thesearch]])
  @endif

  @include('partials.pagination', ['query' => $wp_query])
@endsection
