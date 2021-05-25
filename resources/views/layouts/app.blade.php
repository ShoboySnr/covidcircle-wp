<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')
<body @php body_class() @endphp>
<div id="preloader">
  <div class="preloader-container">
    <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="40" height="40" viewBox="0 0 128 128"><g><path d="M64 9.75A54.25 54.25 0 009.75 64H0a64 64 0 01128 0h-9.75A54.25 54.25 0 0064 9.75z" fill="#019796"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="800ms" repeatCount="indefinite"/></g></svg>
  </div>
</div>
@php do_action('get_header') @endphp
@include('partials.header')
<div class="wrap" role="document">
  <div class="content">
    <main class="main">
      @yield('content')
    </main>
    @if (App\display_sidebar())
      <aside class="sidebar">
        @include('partials.sidebar')
      </aside>
    @endif
  </div>
</div>
@php do_action('get_footer') @endphp
@include('partials.footer')
@php wp_footer() @endphp
</body>
</html>
