<section id="about-featured">
  <div class="container">
    <div class="about-container flex justify-start w-full items-start flex-wrap">
      <div class="w-full xl:w-1/2">
        <div class="featured-image">
          <img src="{{ $section_one['image']['url'] }}" title="{{ $section_one['image']['title'] }}" alt="{{ $section_one['image']['title'] }}" />
        </div>
      </div>
      <div class="w-full xl:w-1/2">
        <div class="content">
          <div class="title">
            <p>{{ $section_one['top_title'] }}</p>
            <h2>{{ $section_one['title'] }}</h2>
          </div>
          <div class="content-details">
            {!! $section_one['content'] !!}
          </div>
        </div>
        @if(!empty($section_one['top_title_2']) || !empty($section_one['title_2']) || !empty($section_one['content_2']))
        <div class="content">
          @if(!empty($section_one['top_title_2']) || !empty($section_one['title_2']))
          <div class="title">
            @if(!empty($section_one['top_title_2']))
              <p>{{ $section_one['top_title_2'] }}</p>
            @endif
            @if(!empty($section_one['title_2']))
              <h2>{{ $section_one['title_2'] }}</h2>
            @endif
          </div>
          @endif
          @if(!empty($section_one['content_2']))
          <div class="content-details">
            {!! $section_one['content_2'] !!}
          </div>
          @endif
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
