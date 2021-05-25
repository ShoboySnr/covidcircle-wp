{{--
  Template Name: Home Template
--}}
<?php
$home_fields = FrontPage::home_page_fields();
?>
@extends('layouts.app')

@section('content')
  @include('partials.home.slideshows', ['slideshows' => $home_fields['slides']])

  @include('partials.home.home-featured', ['featured_home' => $home_fields['featured_home'], 'introducing_video' => $home_fields['introducing_video'], 'introducing_short_video'   => $home_fields['introducing_short_video']])

  @include('partials.home.news-and-events',  ['news_and_events' => $home_fields['news_and_events']])

  @include('partials.home.resources', ['resources_hub' => $home_fields['resources_hub']])

  @if(!empty($home_fields['clients']))
    @include('partials.home.clients', ['clients'  => $home_fields['clients']])
  @endif
@endsection
