{{--
  Template Name: About Template
--}}
<?php
$about_fields = AboutUs::get_contents();
?>
@extends('layouts.app')

@section('content')
  @include('partials.page-header', ['page_title' => $about_fields['page_title']])

  @include('partials.about.featured', ['section_one'  => $about_fields['section_one']])

  @include('partials.about.elements', ['section_two'    => $about_fields['section_two']])

  @include('partials.about.mapping-analysis', ['section_three'    => $about_fields['section_three'], 'section_four'    => $about_fields['section_four'], 'section_five'    => $about_fields['section_five'] ])

  @if(isset($about_fields['partnership']))
    @include('partials.about.partnership', ['partnership'    => $about_fields['partnership']])
  @endif

  @if(!empty($about_fields['funded_by']))
    @include('partials.about.funded-by', ['clients'    => $about_fields['funded_by']])
  @endif

@endsection
