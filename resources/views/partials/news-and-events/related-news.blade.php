@foreach($queries as $post)
<?php
  $event_date = Utility::switch_date(get_field('event_date', $post['id']));
  $event_end_date = Utility::switch_date(get_field('event_end_date', $post['id']));
  $ended = false;
  if(!empty($event_end_date)) {
    if(strtotime($event_end_date) < time()) {
      $ended = true;
    }
  } else if(strtotime($event_date) < time()) {
    $ended = true;
  }
?>

  @include('partials.news-and-events.card', ['query' => $post, 'ended' => $ended])
@endforeach
