<?php

  while($stickyquery->have_posts()) : $stickyquery->the_post();
    $event_date = Utility::switch_date(get_field('event_date'));
    $event_end_date = Utility::switch_date(get_field('event_end_date'));
    $ended = false;
    if(!empty($event_end_date)) {
      if(strtotime($event_end_date) < Utility::get_tomorrow_date()) {
        $ended = true;
      }
    } else if(strtotime($event_date) < Utility::get_tomorrow_date()) {
      $ended = true;
    }
?>
        <div class="news-events-fullcard">
          <div class="content flex justify-start flex-col">
            @if($stickyquery->post->post_type == 'post')
            <div class="tag">
              <span>{{ Utility::getPostCategories()[0]['name'] }}</span>
            </div>
            @else
            <div class="tag events">
              <span class="text-purple">Events</span>
            </div>
            <div class="date flex justify-between items-center contents-center">
              @if(!empty(get_field('event_date')))
              <div>
                <p>When: {{ get_field('event_date') }}</p>
              </div>
              @endif
              @if(isset($ended) && $ended)
                  <div class="event-ended">
                    <p><?= __('event ended', 'covid-circle-wp') ?></p>
                  </div>
              @endif
            </div>
            @endif
            <div class="title">
              <a href="{{ the_permalink() }}" title="{{ the_title() }}" >
                <h3>{{ Utility::limitStr(the_title(), 100) }} </h3>
              </a>
            </div>
            <div class="description">
              <p>
                {{ Utility::limitStr(get_the_excerpt(), 87) }}
              </p>
            </div>
            <div class="link">
              <a href="{{ the_permalink() }}" class="primary-link">
                <span>@if($stickyquery->post->post_type == 'post') Read more @else Register @endif</span>
                <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>
              </a>
            </div>
          </div>
          <div class="featured-image">
            <a href="{{ the_permalink() }}">
              <img src="{{ the_post_thumbnail_url($stickyquery->post->ID, 'full') }}" title="{{ the_title() }}" />
            </a>
          </div>
        </div>
<?php endwhile; wp_reset_postdata(); ?>
