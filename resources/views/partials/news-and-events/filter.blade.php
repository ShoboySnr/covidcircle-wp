<div id="post-filter">
  <div class="flex justify-between items-center flex-wrap">
    <div class="title">
      <p><?= __('Filter Posts:', 'covid-circle-wp') ?></p>
      <div class="all-categories flex">
        <select class="select-control" name="categories_types" id="categories">
          <option value=""><?= __('All Categories', 'covid-circle-wp') ?></option>
          @foreach($categories as $category)
            <option value="{{ $category['slug'] }}" @if($categories_types === $category['slug']) selected @endif>{{ $category['name'] }}</option>
          @endforeach
        </select>
        @if(in_array('post', $post_type) && !in_array('events', $post_type))
        <select class="select-control" name="news_dates" id="dates" data-type="post">
          <option value=""><?= __('All Months', 'covid-circle-wp') ?></option>
          <?php
          $news_and_events_date = Utility::get_filter_date('post');
          foreach($news_and_events_date as $key => $value) {
          ?>
          <option value="<?php echo $key ?>" @if (isset($_GET['news_dates']) && $_GET['news_dates'] == $key) selected @endif><?php echo $value ?></option>
          <?php } ?>
        </select>
        @endif
        @if(in_array('events', $post_type) && !in_array('post', $post_type))
        <select class="select-control" name="events_dates" id="dates">
          <option value=""><?= __('All Months', 'covid-circle-wp') ?></option>
          <?php
            $news_and_events_date = Utility::get_filter_date('events');
            foreach($news_and_events_date as $key => $value) {
          ?>
            <option value="<?php echo $key ?>" @if (isset($_GET['events_dates']) && $_GET['events_dates'] == $key) selected @endif><?php echo $value ?></option>
          <?php } ?>
        </select>
        @endif
      </div>
    </div>
    <div class="filter-news-events">
      <div class="hidden xl:flex jusitify-start">
        <button type="button" value="post,events" name="post_type" class="@if(in_array('post', $post_type) && in_array('events', $post_type)) active @endif"><?= __('All Posts', 'covid-circle-wp') ?></button>
        <button type="button" value="post" name="post_type" class="@if(in_array('post', $post_type) && !in_array('events', $post_type)) active @endif"><?= __('News', 'covid-circle-wp') ?></button>
        <button type="button" value="events" name="post_type" class="@if(in_array('events', $post_type) && !in_array('post', $post_type)) active @endif"><?= __('Events', 'covid-circle-wp') ?></button>
      </div>
      <div class="block xl:hidden">
        <select class="select-control" name="post_type" id="post_type">
          <option value="post,events" selected><?= __('All Posts', 'covid-circle-wp') ?></option>
          <option value="post" @if(in_array('post', $post_type) && !in_array('events', $post_type)) selected @endif><?= __('News', 'covid-circle-wp') ?></option>
          <option value="events" @if(in_array('events', $post_type) && !in_array('post', $post_type)) selected @endif><?= __('Events', 'covid-circle-wp') ?></option>
        </select>
      </div>
    </div>
  </div>
</div>
