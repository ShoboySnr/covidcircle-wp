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
<section id="empty-posts" class="w-screen">
  <div class="container">
    <p><?= __('No '. $title. ' found here.', 'covid-circle-wp') ?></p>
  </div>
</section>
