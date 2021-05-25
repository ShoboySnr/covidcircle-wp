<div class="document content-bg relative h-full flex" title="{{ the_title() }}" onclick="location.href='{{ the_permalink() }}'">
  <div class="h-full">
    <?php
      $featured_image = Utility::filterDocumentBackgroundImage(get_the_post_thumbnail_url(), $types['id']);
    ?>
    <div class="content-bg-img flex justify-start" style="background-image: url('{{ $featured_image }}');">
      @if(!empty($resource_category['name']))
      <div class="tag flex justify-between items-start w-full">
          <a href="{{ the_permalink() }}" title="{{ $resource_category['name'] }}">{{ $resource_category['name'] }}</a>
      </div>
      @endif
    </div>
    <div class="content-bg-title">
      <div class="text-title">
        <a href="{{ the_permalink() }}" title="{{ the_title() }}"> <?= Utility::limitStr(html_entity_decode(get_the_title()), 52) ?></a>
      </div>
      <a href="{{ the_permalink() }}" title="{{ the_title() }}" class="flex read-more">
        <span><?= __('View resource', 'covid-circle-wp') ?></span>
        <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>
      </a>
    </div>
  </div>
</div>
