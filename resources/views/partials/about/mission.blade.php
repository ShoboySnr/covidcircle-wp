<section id="about_mission" class="w-screen">
  <div class="container">
    <div class="about_mission-container">
      <div class="title">
        <h2>{{ $section_three['title'] }}</h2>
      </div>
      <div class="contents">
        <div class="flex w-full justify-start items-center">
          <div class="text-width">
            @if(!empty($section_three['subtitle']))
              <p class="colored">{{ $section_three['subtitle']  }}</p>
            @endif
            <div class="details">
              {!! $section_three['content']!!}
            </div>
              @if(!empty($section_three['link']['title']))
              <a class="link" href="{{ $section_three['link']['url'] }}" title="{{ $section_three['link']['title'] }}" target="{{ $section_three['link']['target'] }}">
                <span>{{ $section_three['link']['title'] }}</span>
                <svg width="19" height="14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05.765a.902.902 0 011.276 0l5.41 5.409a.903.903 0 010 1.276l-5.41 5.409a.903.903 0 01-1.276-1.277l4.772-4.77-4.772-4.77a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 6.812a.901.901 0 01.901-.902h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 6.812z" fill="#071D6F" stroke="#071D6F"/></svg>
              </a>
              @endif
          </div>
          <div class="featured-image-width">
            <img src="{{ $section_three['image'] }}" alt="our-mission-featured" title="{{ $section_three['title'] }}" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
