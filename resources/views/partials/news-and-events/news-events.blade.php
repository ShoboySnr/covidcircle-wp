<section id="news-events-content" class="w-screen bg-white">
  <div class="container">
    <div class="flex justify-start w-full flex-wrap flex-col xl:flex-row">
         @foreach($queries as $post)
      <?php
        $event_date = Utility::switch_date(get_field('event_date', $post['id']));
        $event_end_date = Utility::switch_date(get_field('event_end_date', $post['id']));
        $ended = false;
        if(!empty($event_end_date)) {
          if(strtotime($event_end_date) < Utility::get_tomorrow_date()) {
            $ended = true;
          }
        } else if(strtotime($event_date) < Utility::get_tomorrow_date()) {
          $ended = true;
        }
      ?>
        @include('partials.news-and-events.card', ['query' => $post, 'ended' => $ended])
      @endforeach
    </div>
  </div>
</section>

