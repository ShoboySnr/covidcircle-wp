<section class="w-screen" id="single-news">
  <div class="container">
    @include('partials.news-and-events.feeatured-image')
  </div>

  <div class="content bg-white">
    <div class="container">
      <div class="items-container flex w-full justify-start flex-col xl:flex-row">
        <div class="title-container">
          <hr >
          <h1>
            {{ the_title() }}
          </h1>
        </div>
        <div class="details-container w-full">
          <div class="date-content flex justify-between w-full items-center">
            <p>Published on {{ Utility::get_the_date_filter() }}</p>
            <div class="tag">
              <span>{{ Utility::getPostCategories()[0]['name'] }}</span>
            </div>
          </div>
          <div class="full-details">
            {{ the_content() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  $args = [
    'post__not_in' => [$post->ID],
    'post_type'      => 'post',
    'posts_per_page'  => 3,
    'ignore_sticky_posts' => 1
  ];

  $query = new WP_Query($args);
?>
@if($query->have_posts())
<section id="related-posts">
  <div class="container">
    <div class="title-container">
      <h3>
        <?= __('You may also be interested in', 'covid-circle-wp') ?>
      </h3>
    </div>
    <div class="related-container" id="news-events-content">
      <div class="flex justify-center w-full">
          @include('partials.news-and-events.related-news', ['queries' => Utility::sort_date_and_events_wp_query($query)])
      </div>
    </div>
  </div>
</section>
@endif

