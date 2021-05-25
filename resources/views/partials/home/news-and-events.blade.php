<section id="news-and-events">
  <div class="container news-and-events-container">
    <div class="title">
      <h2>{{ __('News and Events', 'covid-circle-wp') }}</h2>
    </div>

    <div class="news-content">
      <div class="flex justify-start">
        <div class="owl-carousel">
          @php $count = 0 @endphp
          @foreach($news_and_events['news_and_events'] as $post)
            @if($count == 0)
          <div class="content-bg flex justify-start first-width cursor-pointer" >
            <div class="content flex justify-start flex-col">
              @if($post['type'] === 'post')
                @if(!empty($post['categories']))
                  <div class="tag">
                    <span>{{ $post['categories'] }}</span>
                  </div>
                @endif
              @else
                  <div class="tag events">
                    <span class="text-purple">Events</span>
                  </div>
                <div class="date flex justify-between items-center">
                  <div>
                    <p>When: {{ get_field('event_date', $post['id']) }}</p>
                  </div>
                  @if(isset($post['ended']) && $post['ended'])
                    <div class="event-ended">
                      <p><?= __('event ended', 'covid-circle-wp') ?></p>
                    </div>
                  @endif
                </div>
              @endif
              <div class="title">
                <a href="{{ $post['link'] }}" title="{{ $post['title'] }}">
                  <h3>{{ Utility::limitStr($post['title'], 150) }}</h3>
                </a>
              </div>
              <div class="description">
                <p>
                 {{ Utility::limitStr($post['content'], 55) }}
                </p>
              </div>
              <div class="link">
                <a href="{{ $post['link'] }}" class="primary-link" target="_blank">
                  <span>Read more</span>
                  <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>
                </a>
              </div>
            </div>
            <div class="featured-image">
              <img src="{{ !empty($post['featured_image']) ? $post['featured_image'] : \App\asset_path('images/news-and-events.png') }}" title="{{ $post['title'] }}" />
            </div>
          </div>
            @else
              <div class="hover-bg" style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ $post['featured_image']  }}') no-repeat center center;" onclick="location.href='{{ $post['link'] }}'">
                <div class="content-bg flex justify-start default-width cursor-pointer without-hover"  onclick="location.href='{{ $post['link'] }}'">
                  <div class="content flex justify-start flex-col">
                    @if($post['type'] === 'post')
                      <div class="tag">
                        <span>{{ $post['categories'] }}</span>
                      </div>
                    @else
                      <div class="tag events">
                        <span class="text-purple">Events</span>
                      </div>
                      <div class="date flex justify-between items-center">
                        <div>
                          <p>When: {{ get_field('event_date', $post['id']) }}</p>
                        </div>
                        @if(isset($post['ended']) && $post['ended'])
                          <div class="event-ended">
                            <p><?= __('event ended', 'covid-circle-wp') ?></p>
                          </div>
                        @endif
                      </div>
                    @endif
                    <div class="title">
                      <a href="{{ $post['link'] }}" title="{{ $post['title'] }}">
                        <h3>{{ Utility::limitStr($post['title'], 150) }}</h3>
                      </a>
                    </div>
                    <div class="description">
                      <p>
                        {!! Utility::limitStr($post['content'], 55) !!}
                      </p>
                    </div>
                    <div class="link">
                      <a href="{{ $post['link'] }}" class="primary-link" target="_blank">
                        <span>Register</span>
                        <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            @endif
            @php $count++ @endphp
          @endforeach
        </div>
      </div>
      <div class="flex justify-end see-all">
        <a href="{{ $news_and_events['more_link'] }}" title="See all">{{ __('See all', 'covid-circle-wp') }}</a>
      </div>
    </div>
  </div>
</section>
