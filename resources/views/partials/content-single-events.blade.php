<?php
$register_link = get_field('event_register_link');
$category = Utility::getSingleCustomCategory('events_categories')[0]['name']

?>

<section id="single-event" class="w-screen">
  <div class="container">
    @include('partials.news-and-events.feeatured-image')
  </div>

  <div class="content bg-white">
    <div class="container">
      <div class="items-container flex w-full justify-start flex-col xl:flex-row">
        <div class="title-container">
          <ul>
            @if(!empty($register_link))
              <li class="register-link">
                <a href="{{ $register_link['url'] }}" title="{{ $register_link['title'] }}" target="{{ $register_link['target'] }}" class="primary-link flex justify-start items-center">
                  <span class="span">
                    {{ $register_link['title'] }}
                  </span>
                  <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.246a.901.901 0 011.276 0l5.41 5.4a.902.902 0 010 1.275l-5.41 5.4a.903.903 0 01-1.54-.637.9.9 0 01.264-.637l4.772-4.763L11.05 2.52a.899.899 0 010-1.275z" fill="#00B5B4" stroke="#00B5B4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.284a.9.9 0 01.901-.9h14.295a.902.902 0 01.901.9.9.9 0 01-.901.9H1.9a.902.902 0 01-.901-.9z" fill="#00B5B4" stroke="#00B5B4"/></svg>
                </a>
              </li>
            @endif
            <li>
              <?php
              $event_date = Utility::switch_date(get_field('event_date'));
              $event_end_date = Utility::switch_date(get_field('event_end_date'));

              if(!empty($event_end_date)) {
                if(strtotime($event_end_date) < Utility::get_tomorrow_date()) {
                  $ended = true;
                }
              } else if(strtotime($event_date) < Utility::get_tomorrow_date()) {
                $ended = true;
              }

                if(!empty(get_field('event_date'))) {
              ?>
                <div class="title">
                  <?= __('Date', 'covid-circle-wp') ?>
                </div>
                <div class="details">
                  <p><?=  !empty(get_field('event_date')) ? get_field('event_date')  : '' ?>
                    <?= !empty(get_field('event_end_date')) ? ' - '. get_field('event_end_date') : ''  ?></p>
                </div>
              <?php } ?>
            </li>
            <li>
              <div class="title">
                <?= __('Time', 'covid-circle-wp') ?>
              </div>
              <div class="details">
                <p>{{ get_field('event_time') }}</p>
              </div>
            </li>
            <li>
              <div class="title">
                <?= __('Location', 'covid-circle-wp') ?>
              </div>
              <div class="details">
                <p>{!! get_field('event_location') !!}</p>
              </div>
            </li>
            <li>
              <div class="title">
                <?= __('Organisation', 'covid-circle-wp') ?>
              </div>
              <div class="details">
                <p>{!! get_field('organisation') !!}</p>
              </div>
            </li>
          </ul>
        </div>
        <div class="details-container w-full">
          <div class="category-content-container flex justify-start items-center">
            @if(isset($category) && $category != '')
              <div class="category-content mx-1 flex justify-between w-full items-center">
                <p>{{ $category }}</p>
              </div>
            @endif
            @if(isset($ended) && $ended)
                <div class="event-ended">
                  <p><?= __('event ended', 'covid-circle-wp') ?></p>
                </div>
              @endif
          </div>
          <div class="full-details">
            <h1 class="title">{{ the_title() }}</h1>

            {{ the_content() }}

            @if(!empty($register_link))
              <div class="register-link">
                <a href="{{ $register_link['url'] }}" title="{{ $register_link['title'] }}" target="{{ $register_link['target'] }}" class="primary-link flex justify-start items-center">
                    <span class="span">
                      {{ $register_link['title'] }}
                    </span>
                  <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.246a.901.901 0 011.276 0l5.41 5.4a.902.902 0 010 1.275l-5.41 5.4a.903.903 0 01-1.54-.637.9.9 0 01.264-.637l4.772-4.763L11.05 2.52a.899.899 0 010-1.275z" fill="#00B5B4" stroke="#00B5B4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.284a.9.9 0 01.901-.9h14.295a.902.902 0 01.901.9.9.9 0 01-.901.9H1.9a.902.902 0 01-.901-.9z" fill="#00B5B4" stroke="#00B5B4"/></svg>
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
$args = [
  'post__not_in' => [$post->ID],
  'post_type'      => 'events',
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
      <div class="flex justify-center w-full flex-wrap">
        @include('partials.news-and-events.related-news', ['queries' => Utility::sort_date_and_events_wp_query($query)])
      </div>
    </div>
  </div>
</section>
@endif
