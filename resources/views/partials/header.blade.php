<?php
$show_notibar = isset($_COOKIE['show_notibar']) ? $_COOKIE['show_notibar'] : '';
?>
<header class="bg-white banner z-10 w-full flex justify-between @if($show_notibar) hide-notibar-container @endif">
  <div class="njt-nofi-container-content @if($show_notibar) hide-notibar @endif" id="notibar">
    <div>
      <div class="items flex justify-between items-start xl:items-center flex-col xl:flex-row">
        <button type="button" class="hide-close-button">
          <svg width="14" height="14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.41 7l4.3-4.29a1.004 1.004 0 10-1.42-1.42L7 5.59l-4.29-4.3a1.004 1.004 0 00-1.42 1.42L5.59 7l-4.3 4.29a1 1 0 00.325 1.639 1 1 0 001.095-.219L7 8.41l4.29 4.3a1.001 1.001 0 001.639-.325 1 1 0 00-.22-1.095L8.41 7z" fill="#fff"/></svg>
          <span>Close</span>
        </button>
        <div class="text-section">
          <span><?= __('Turn on high contrast mode to make our website more', 'covid-circle-wp') ?> <a href="<?p get_permalink(get_page_by_path('accessibility') ?>">accessible.</a></span> <div id="accessibility"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="flex items-start" style="max-height: 99px;height: 100%;">
    <div class="banner-container">
      <a class="brand" href="{{ home_url('/') }}"  title="{{ get_bloginfo('name', 'display') }}">
        <img class="logo" src="<?= get_theme_mod('theme_logo', get_template_directory_uri(). '/assets/images/covid-circle-default-logo.png') ?>" alt="{{ get_bloginfo('name', 'display') }}" />
      </a>
      <nav class="nav-primary" id="nav-menu">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
        @endif
        <div class="only-login-button container">
          <a href="http://covidcircle.tribe.so/" class="login-button"><?= __('Login', 'covid-circle') ?></a>
        </div>
      </nav>
    </div>
    @include('partials.search-login')
    <div id="mobile-menu">
      <div class="mobile-container">
        <button class="hamburger hamburger--collapse" type="button">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
        </button>
      </div>
    </div>
  </div>
  <div id="progress-loader"></div>
</header>
