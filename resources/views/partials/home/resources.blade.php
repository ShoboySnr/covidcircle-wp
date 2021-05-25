<section id="resources" class="bg-white">
  <div class="container resources-container">
    <div class="title">
      <h2>{{ __('Resources', 'covid-circle-wp') }}</h2>
    </div>

    <div class="resources-content">
      <div class="flex justify-start w-full flex-col">
        <div class="owl-carousel">
          @foreach($resources_hub['resources'] as $resource)
            <div class="content-bg relative h-full flex @if($resource['types']['slug'] != 'link') document @endif" onclick="location.href='{{ $resource['link'] }}'">
              @if($resource['types']['slug'] === 'link')
                <div class="text-bg bg-primary">
                  <div class="text-container-bg">
                    <div class="tag flex justify-between items-start w-full">
                      @if($resource['categories']['name'] != '')
                        <a href="{{ $resource['link'] }}" title="{{ $resource['categories']['name'] }}">{{ $resource['categories']['name'] }}</a>
                      @endif
                      <span title="Document Type">
                <svg width="32" height="30" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.386 10.862c3.65 3.505 3.6 9.123.022 12.574l-.022.022-4.107 3.937c-3.621 3.473-9.514 3.473-13.135 0-3.621-3.472-3.621-9.123 0-12.595l2.268-2.174c.601-.577 1.636-.194 1.668.621.04 1.039.233 2.082.592 3.09a.915.915 0 01-.232.973l-.8.766c-1.712 1.642-1.765 4.316-.07 5.975 1.713 1.674 4.527 1.684 6.253.03l4.106-3.937a4.096 4.096 0 000-5.967 4.537 4.537 0 00-.632-.502.955.955 0 01-.303-.321.912.912 0 01-.121-.418 2.283 2.283 0 01.714-1.746l1.287-1.234a1.013 1.013 0 011.258-.101c.448.3.867.637 1.254 1.007zm8.611-8.258c-3.62-3.472-9.513-3.473-13.135 0l-4.106 3.937a.647.647 0 00-.022.022c-3.579 3.45-3.629 9.07.022 12.574.386.37.806.707 1.254 1.007.391.262.92.222 1.258-.101l1.286-1.234c.51-.489.74-1.127.715-1.746a.91.91 0 00-.12-.418.954.954 0 00-.304-.32 4.552 4.552 0 01-.632-.503 4.096 4.096 0 010-5.967l4.106-3.936c1.726-1.655 4.54-1.645 6.253.03 1.695 1.658 1.642 4.332-.071 5.974l-.8.767a.916.916 0 00-.23.973c.357 1.007.552 2.05.591 3.089.031.815 1.067 1.198 1.668.621l2.267-2.174c3.622-3.472 3.622-9.123 0-12.595z" fill="#fff"/></svg>
              </span>
                    </div>
                    <h2>
                      {{ Utility::limitStr($resource['title'], 100)}}
                    </h2>
                    <a href="{{ $resource['link'] }}" title="Read more..." class="flex link">
                      <span><?= __('View resource', 'covid-circle-wp') ?></span>
                      <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>
                    </a>
                  </div>
                </div>
              @else
                <div class="h-full">
                <div class="content-bg-img flex justify-start" style="background-image: url('{{ $resource['featured_image'] }}');">
                  <div class="tag flex justify-between items-start w-full">
                    @if(!empty($resource['categories']))
                      <a href="{{ $resource['categories']['link'] }}" title="{{ $resource['categories']['name'] }}">{{ $resource['categories']['name'] }}</a>
                    @endif
                    <span title="Document Type" style="display: none;">
                <svg width="32" height="30" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.386 10.862c3.65 3.505 3.6 9.123.022 12.574l-.022.022-4.107 3.937c-3.621 3.473-9.514 3.473-13.135 0-3.621-3.472-3.621-9.123 0-12.595l2.268-2.174c.601-.577 1.636-.194 1.668.621.04 1.039.233 2.082.592 3.09a.915.915 0 01-.232.973l-.8.766c-1.712 1.642-1.765 4.316-.07 5.975 1.713 1.674 4.527 1.684 6.253.03l4.106-3.937a4.096 4.096 0 000-5.967 4.537 4.537 0 00-.632-.502.955.955 0 01-.303-.321.912.912 0 01-.121-.418 2.283 2.283 0 01.714-1.746l1.287-1.234a1.013 1.013 0 011.258-.101c.448.3.867.637 1.254 1.007zm8.611-8.258c-3.62-3.472-9.513-3.473-13.135 0l-4.106 3.937a.647.647 0 00-.022.022c-3.579 3.45-3.629 9.07.022 12.574.386.37.806.707 1.254 1.007.391.262.92.222 1.258-.101l1.286-1.234c.51-.489.74-1.127.715-1.746a.91.91 0 00-.12-.418.954.954 0 00-.304-.32 4.552 4.552 0 01-.632-.503 4.096 4.096 0 010-5.967l4.106-3.936c1.726-1.655 4.54-1.645 6.253.03 1.695 1.658 1.642 4.332-.071 5.974l-.8.767a.916.916 0 00-.23.973c.357 1.007.552 2.05.591 3.089.031.815 1.067 1.198 1.668.621l2.267-2.174c3.622-3.472 3.622-9.123 0-12.595z" fill="#fff"/></svg>
              </span>
                  </div>
                </div>
                <div class="content-bg-title">
                  <div class="text-title">
                    <a href="{{ $resource['link'] }}" title="His is a live database of funded research projects"> {{ \App\Controllers\Utility::limitStr($resource['title'], '58') }}</a>
                  </div>
                  <a href="{{ $resource['link'] }}" title="Read more..." class="flex link">
                    <span><?= __('View resource', 'covid-circle-wp') ?></span>
                    <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>
                  </a>
                </div>
              </div>
              @endif
            </div>
          @endforeach
        </div>

        <div class="see-all flex justify-end items-center">
          <a href="<?= $resources_hub['more_link'] ?>" title="See all"><?= __('See all', 'covid-circle-wp') ?></a>
        </div>
      </div>
    </div>
  </div>
</section>
