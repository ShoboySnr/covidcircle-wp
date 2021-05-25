<div id="resources-content" class="w-full">
  <div class="flex justify-start items-start flex-col xl:flex-row">
    @include('partials.resources-hub.side-filter', ['categories' => $categories, 'resources_categories' => $resources_categories])
    <div class="resources-loop-content w-full">
      @if($query->have_posts())
      <div class="resources-content-2">
        <?php

        while($query->have_posts()) : $query->the_post(); ?>
        <?php
          $posts = $query->posts;
          $types = Utility::getSingleCustomCategory('resources_types', 'documents');
          $resource_category = Utility::getSingleCustomCategory('resources_categories', '');
        ?>
          @if($types[0]['slug'] === 'link')
            @include('partials.resources-hub.single-link', ['post' => $post, 'types'  => $types])
          @else
              @include('partials.resources-hub.single-default', ['post' => $post, 'types'  => $types[0], 'resource_category' => $resource_category[0]])
           @endif
        <?php endwhile; ?>
      </div>
      @else
        @include('partials.empty', ['title' => 'Resource Hub'])
      @endif
        <?php wp_reset_postdata(); ?>
    </div>
  </div>
</div>
