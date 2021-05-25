<?php
$types = Utility::getSingleCustomCategory('resources_types', 'documents');
$featured_image = Utility::filterDocumentBackgroundImage(get_the_post_thumbnail_url(), $types[0]['id']);
$resource_categories = Utility::getSingleCustomCategory('resources_categories', '');

//get the path back to the resources hub
$resource_hub_path = get_permalink(get_page_by_path('resource-hub'));

//get the custom fields
$developed_by = get_field('developed_by', $post);
$sample_site = get_field('sample_site', $post);
$resources_hub_link = get_field('resources_hub_link', $post);
$resources_hub_text = get_field('resources_hub_text', $post);

?>
<section id="single-resource-hub">
  <div class="container">
    <div class="justify-end flex items-center back-arrow">
      <a href="{{ $resource_hub_path }}" class="flex items-center justify-center" title="Back to Resources Hub">
        <svg width="11" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.189 1.494l1.53 1.526-4.97 4.968 4.97 4.968-1.53 1.526-6.51-6.494 6.51-6.494z" fill="#222" stroke="#222"/></svg>
        <span><?= __('back', 'covid-circle-wp') ?></span>
      </a>
    </div>
    <div class="resource-header">
      <div class="flex w-full justify-start items-start relative flex-col xl:flex-row">
        <div class="title-bg">
          @if(!empty($resource_categories[0]['name']))
            <span class="tag">{{ $resource_categories[0]['name'] }}</span>
          @endif
          <h1>
            {{ the_title() }}
          </h1>
          <p class="date">
           {{ Utility::get_the_date_filter() }}
          </p>
          @if($resources_hub_link != NULL)
          <a href="{{ $resources_hub_link['url'] }}" title="{{ $resources_hub_link['title'] }}" target="{{ $resources_hub_link['target'] }}">
            <span>{{ $resources_hub_link['title'] }}</span>
            <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.246a.901.901 0 011.276 0l5.41 5.4a.902.902 0 010 1.275l-5.41 5.4a.903.903 0 01-1.54-.637.9.9 0 01.264-.637l4.772-4.763L11.05 2.52a.899.899 0 010-1.275z" fill="#00B5B4" stroke="#00B5B4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.284a.9.9 0 01.901-.9h14.295a.902.902 0 01.901.9.9.9 0 01-.901.9H1.9a.902.902 0 01-.901-.9z" fill="#00B5B4" stroke="#00B5B4"/></svg>
          </a>
          @endif
        </div>
        <div class="featured-image">
          <img src="{{ $featured_image }}" title="{{ the_title() }}" alt="{{ the_title() }}" />
        </div>
      </div>
    </div>
    <hr />
    <div class="post-content-container w-full">
      <div class="flex justify-start items-start w-full flex-col xl:flex-row">
        <div class="info-box">
          <ul>
            @if(!empty($types[0]))
              <li>
                <div class="title">
                  <?= __('Resource Type', 'covid-circle-wp') ?>
                </div>
                <div class="details">
                  {{ $types[0]['name'] }}
                </div>
              </li>
            @endif
            @if($developed_by != '')
              <li>
                <div class="title">
                  <?= __('Developed By', 'covid-circle-wp') ?>
                </div>
                <div class="details">
                  {{ $developed_by }}
                </div>
              </li>
            @endif
            @if($sample_site != '')
              <li>
                <div class="title">
                  <?= __('Sample Site', 'covid-circle-wp') ?>
                </div>
                <div class="details">
                  {{ $sample_site }}
                </div>
              </li>
            @endif
          </ul>
        </div>
        <div class="post-content">
          {!! the_content() !!}

          <div class="post_content_link">
            @if($resources_hub_link != NULL)
              <a href="{{ $resources_hub_link['url'] }}" title="{{ $resources_hub_link['title'] }}" target="{{ $resources_hub_link['target'] }}">
                <span>{{ $resources_hub_link['title'] }}</span>
                <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.246a.901.901 0 011.276 0l5.41 5.4a.902.902 0 010 1.275l-5.41 5.4a.903.903 0 01-1.54-.637.9.9 0 01.264-.637l4.772-4.763L11.05 2.52a.899.899 0 010-1.275z" fill="#00B5B4" stroke="#00B5B4"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.284a.9.9 0 01.901-.9h14.295a.902.902 0 01.901.9.9.9 0 01-.901.9H1.9a.902.902 0 01-.901-.9z" fill="#00B5B4" stroke="#00B5B4"/></svg>
              </a>
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
  'post_type'      => 'resource_hub',
  'posts_per_page'  => 3,
  'ignore_sticky_posts' => 1
];

$query = new WP_Query($args);
?>
<section id="related-posts">
  <div class="container">
    <div class="title-container">
      <h3>
        <?= __('You may also be interested in', 'covid-circle-wp') ?>
      </h3>
    </div>
    <div id="resources-hub" class="w-full">
      <div class="container">
        <div class="resources-container">
          <div class="flex w-full justify-start">
            <div class="content-width w-full">
              <div id="resources-content" class="w-full">
                <div class="flex justify-center items-center flex-col xl:flex-row">
                  <div class="resources-loop-content w-full" style="max-width: 65.875rem">
                    @if($query->have_posts())
                      <div class="resources-content-2 flex justify-start items-start w-full flex-wrap">
                        <?php while($query->have_posts()) : $query->the_post(); ?>
                        <?php
                        $posts = $query->posts;
                        $types = Utility::getSingleCustomCategory('resources_types', 'documents');
                        ?>
                        @if($types[0]['slug'] === 'link')
                          @include('partials.resources-hub.single-link', ['post' => $post, 'types'  => $types])
                        @else
                          @include('partials.resources-hub.single-default', ['post' => $post, 'types'  => $types[0]])
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
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php wp_reset_postdata(); ?>
