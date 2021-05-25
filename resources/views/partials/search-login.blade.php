<div class="search-login-nav">
  <div class="flex justify-start relative h-full">
    <div id="pullout-search" class="pullout-search flex flex-end">
      <a class="search-icon-bg" href="{{ get_permalink(get_page_by_path('search')) }}">
        <svg width="25" height="25" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24.106 22.213l-4.532-4.518a10.558 10.558 0 002.252-6.532 10.663 10.663 0 10-10.663 10.663c2.368.003 4.669-.79 6.532-2.252l4.518 4.532a1.332 1.332 0 001.893 0 1.332 1.332 0 000-1.893zm-20.94-11.05a7.997 7.997 0 1115.995 0 7.997 7.997 0 01-15.995 0z" fill="#fff"/></svg>
      </a>
      {!! get_search_form(false) !!}
    </div>
    <a href="https://community.covidcircle.org/" class="login-bg">
      <?= __('Login', 'covid-circle') ?>
    </a>
  </div>
</div>
