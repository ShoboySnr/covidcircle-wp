<div class="featured-image relative">
  <img src="{{ get_the_post_thumbnail_url($post, 'full') }}" alt="{{ get_the_title() }}" title="{{ get_the_title() }}" />
  <div class="back-button absolute bg-white">
    <a href="{{ get_permalink(get_option('page_for_posts')) }}" title="Go back"  class="flex items-center justify-center">
      <svg width="11" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.189 1.494l1.53 1.526-4.97 4.968 4.97 4.968-1.53 1.526-6.51-6.494 6.51-6.494z" fill="#222" stroke="#222"/></svg>
      <?= __('Back', 'covid-circle-wp') ?>
    </a>
  </div>
  <div class="social-button absolute bg-white">
    @include('partials.social-share')
  </div>
</div>
