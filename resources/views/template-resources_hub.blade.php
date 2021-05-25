{{--
  Template Name: Resources Hub Template
--}}
<?php
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$resources_filter = isset($_GET['resources_types']) ?  $_GET['resources_types'] : NULL;
$resources_categories = (isset($_GET['resources_categories']) && $_GET['resources_categories'] != '') ? $_GET['resources_categories'] : null;

$resources_categories = $resources_categories != null ? explode(',', $resources_categories) : [];

$args = [
  'post_type'   => 'resource_hub',
  'posts_per_page'  => 6,
  'paged'           => $paged,
  'tax_query' => [],
];

if(!empty($resources_filter)) {
  $resources_filter_args = [
    'taxonomy' => 'resources_types',
    'field' => 'slug',
    'terms' => $resources_filter,
  ];
  $args['tax_query'][] = array_merge($resources_filter_args, $args['tax_query']);
}

if (!empty($resources_categories)) {
  foreach($resources_categories as $category) {
    $resources_categories_filter[] = [
      'taxonomy'  => 'resources_categories',
      'field' => 'slug',
      'terms' => $category,
    ];
  }
  $resources_categories_filter['relation'] = 'AND';

  $args['tax_query'][] = array_merge($resources_categories_filter, $args['tax_query']);
}

$query = new WP_Query($args);

$types = Utility::geCustomCategories('resources_types');
$categories = Utility::geCustomCategories('resources_categories');

?>
@extends('layouts.app')

@section('content')
  @include('partials.page-header-custom-posts')

  <section id="resources-hub">
    <div class="container">
      <div class="resources-container flex-row">
        <div class="flex w-full justify-start flex-col">
          <div class="filter-width w-full">
            @include('partials.resources-hub.filter', ['types' => $types, 'resources_filter' => $resources_filter])
          </div>
          <div class="content-width">
              @include('partials.resources-hub.content', ['categories' => $categories, 'query' => $query, 'resources_categories' => $resources_categories])
          </div>
        </div>
      </div>
      @include('partials.pagination', ['query' => $query])
    </div>
  </section>
@endsection