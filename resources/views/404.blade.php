@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <section id="notfound">
    <div class="container">
      @if (!have_posts())
        <div class="alert-container alert alert-warning">
          {{ __('Sorry, but the page you were trying to view does not exist.', 'sage') }}
        </div>
        {!! get_search_form(false) !!}
      @endif
    </div>
  </section>
@endsection
