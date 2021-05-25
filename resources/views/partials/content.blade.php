<section id="news-events">
  <div class="container">
      <div class="w-full flex justify-left items-center">
        @include('partials.news-and-events.fullcard', ['stickyquery' => $stickyquery, 'query' => $nosticky_query])
      </div>
    <div class="filter-bg w-full">
      @include('partials.news-and-events.filter', ['post_type' => $post_type, 'categories' => $categories, 'categories_types' => $categories_types])
    </div>
  </div>
</section>
@if($wp_query->have_posts())
  @include('partials.news-and-events.news-events', ['queries' => Utility::sort_date_and_events_wp_query($wp_query)])
  @include('partials.pagination', ['query' => $wp_query])
@else
  @include('partials.empty', ['title' => 'News & Events'])
@endif
