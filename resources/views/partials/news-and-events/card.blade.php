<div class="hover-bg" style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ get_the_post_thumbnail_url($query['id'])  }}');" onclick="location.href='{{ the_permalink($query['id']) }}'">
  <div class="content-bg without-hover flex justify-start">
    <div class="content flex justify-start flex-col relative">
      <div class="block xl:hidden w-full mobile-only-image">
        <img src="{{ get_the_post_thumbnail_url($query['id']) }}" alt="{{ get_the_title($query['id']) }}" title="{{ get_the_title($query['id']) }}" />
      </div>
      @if($post['type'] == 'post')
        <div class="tag">
          <span>{{ Utility::getPostCategories($query['id'])[0]['name'] }}</span>
        </div>
      @else
        <div class="tag events">
          <span class="text-purple">Events</span>
        </div>
        <div class="date flex justify-between items-center contents-center">
          @if(!empty(get_field('event_date', $query['id'])))
            <div>
              <p><?= __('When:', 'covid-circle-wp'); ?> {{ get_field('event_date', $query['id']) }}</p>
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
        <h3>{{ Utility::limitStr(get_the_title($query['id']), 150) }} </h3>
      </div>
      <div class="description">
        <p>
          {{ Utility::limitStr(get_the_excerpt($query['id']), 50) }}
        </p>
      </div>
      <div class="link">
        <a href="{{ the_permalink($query['id']) }}" class="primary-link" title="{{ get_the_title($query['id']) }}">
          <span>@if($post['type'] == 'post') Read more @else Register @endif</span>
          <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>
        </a>
      </div>
    </div>
  </div>
</div>
