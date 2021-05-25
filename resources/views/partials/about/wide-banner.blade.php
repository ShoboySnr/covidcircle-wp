@if($section_two['title'] !== '')
<section id="about_wide-banner" class="w-screen">
  <div class="container">
    <div class="about-wide-container">
      <div class="title">
        <h2>{{ $section_two['title'] }}</h2>
      </div>
      <div class="description">
        {!! $section_two['content'] !!}
      </div>
    </div>
  </div>
</section>
@endif
