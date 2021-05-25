<section id="search-results" class="w-screen bg-white">
  <div class="container">
    <div class="search-title">
      <h3><span>'{{ $query->found_posts }}'</span> search results found for <span>'{{ $thesearch }}'</span></h3>
    </div>
    <?php while($query->have_posts()) : $query->the_post(); ?>
    @php
      $permalink = get_the_permalink();
      $permalink_target = '_self';
      if(get_post_type() === 'network_types') {
          $permalink = get_field('network_link')['url'];
          $permalink_target = get_field('network_link')['target'];
      }
    @endphp
    <div class="search-results">
      <div class="flex justify-start flex-col">
        <div class="tag">
          <span>{{ get_post_type_object(get_post_type())->labels->singular_name }}</span>
        </div>
        <div class="header-title">
          <a href="{{ $permalink }}" title="Supporting the COP26" target="{{ $permalink_target }}">
            <h1>{{ the_title() }}</h1>
          </a>
        </div>
        <div class="header-content">
          <p>{!! Utility::limitStr(strip_tags(get_the_content()), 330) !!}</p>
        </div>
        <?php
          $get_categories = Utility::return_category_subcategory();
          if(!empty($get_categories)) :
        ?>
        <div class="tags-list flex -mx-4">
          @if(!empty($get_categories[0]['name']))
          <div class="tag mx-4">
            <p> Category: <span>{{ $get_categories[0]['name'] }} </span> </p>
          </div>
          @endif
          @if(!empty($get_categories[1]['name']))
          <div class="tag mx-4">
            <p> Subcategory: <span>{{ $get_categories[1]['name'] }}</span> </p>
          </div>
           @endif
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</section>
<?php wp_reset_postdata(); ?>

