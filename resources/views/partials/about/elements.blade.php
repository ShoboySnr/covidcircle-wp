@if(!empty($section_two['title']))
<section id="four-elements">
  <div class="container">
    <div class="title">
      <h2>{{ $section_two['top_title'] }}</h2>
    </div>
    <div class="contents">
      <div class="flex items-container justify-start items-start w-full flex-col xl:flex-row">
        <div class="featured-image-about">
          <img src="{{ $section_two['image'] }}" title="{{  $section_two['title'] }}" />
        </div>
        <div class="details">
          <h2 class="title-text">{{ $section_two['title'] }}</h2>
          {!! $section_two['contents'] !!}
        </div>
      </div>
    </div>
  </div>
</section>
  @endif
