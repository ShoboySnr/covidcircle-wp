<?php
$default_continent = '';
$continents  = Utility::get_networks();

?>

{{--
  Template Name: Networks Template
--}}
@extends('layouts.app')

@section('content')
  @include('partials.page-header')
  @include('partials.networks.map', ['default_continent' => $default_continent])
  @include('partials.networks.regions', ['regions' => $continents['regions']])
  @include('partials.networks.content', ['contents' => $continents['contents']])
@endsection
