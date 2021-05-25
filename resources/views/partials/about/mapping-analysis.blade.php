@if(!empty($section_three['title']))
<section id="mapping-analysis" class="w-screen bg-white">
  <div class="container">
    <div class="flex justify-center">
      <div class="items-container flex w-full justify-start items-start flex-col-reverse xl:flex-row">
        <div class="details margin-right">
          <div class="title">
            <h2>{{ $section_three['title'] }}</h2>
          </div>
          {!! $section_three['contents'] !!}
        </div>
        <div class="featured-image-about" style="margin-top: 1.5rem">
          <img src="{{ $section_three['image'] }}" title="{{ $section_three['title'] }}" />
        </div>
      </div>
    </div>
  </div>
</section>
@endif

@if(!empty($section_four['title']))
<section id="mapping-analysis" class="w-screen bg-grey">
  <div class="container">
    <div class="flex justify-center">
      <div class="items-container flex w-full justify-start items-start flex-col xl:flex-row">
        <div class="featured-image-about">
          <img src="{{ $section_four['image'] }}" title="{{ $section_four['title'] }}" />
        </div>
        <div class="details margin-left">
          <div class="title">
            <h2>{{ $section_four['title'] }}</h2>
          </div>
          {!! $section_four['contents'] !!}
           </div>
      </div>
    </div>
  </div>
</section>
@endif

@if(!empty($section_five['title']))
<section id="mapping-analysis" class="w-screen bg-white">
  <div class="container">
    <div class="flex justify-center">
      <div class="items-container flex w-full justify-start items-start flex-col-reverse xl:flex-row">
        <div class="details margin-right">
          <div class="title">
            <h2>{{ $section_five['title'] }}</h2>
          </div>
          {!! $section_five['contents'] !!}
        </div>
        <div class="featured-image-about">
          <img src="{{ $section_five['image'] }}" title="{{ $section_five['title'] }}" />
        </div>
      </div>
    </div>
  </div>
</section>
  @endif
