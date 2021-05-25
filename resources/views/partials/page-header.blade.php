<?php
if(empty($post)) {
  $page_header = App::title();
} else $page_header = get_field('page_title', $post->ID);
?>
<div class="page-header bg-gray-100" id="page-header">
  <div class="container">
    <div class="title-container">
      <h1>{!! $page_header !!}</h1>
    </div>
  </div>
</div>
