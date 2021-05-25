<section id="home-featured">
  <div class="home-featured-container relative">
    <div class="container">
      <div class="table w-full flex-col xl:flex-row">
        <div id="spacing" class="featured-image w-full xl:w-1/2">
          <div class="background-image">
            <video src="{{ $introducing_short_video }}" autoplay="" loop="" playsinline="" muted="" style="height: 570px; margin-left: 0px;"></video>
            <div class="video-cover">
              <svg class="watch-video" video-url="{{ $introducing_video }}" width="68" height="68" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="68" height="68" rx="34" fill="#00b5b4"/><path d="M47.49 34.248l.005-.008L27.977 23l-.005.009a.86.86 0 00-.435-.13.887.887 0 00-.885.882c0 .036.016.066.02.1h-.02V46.34h.02a.875.875 0 00.865.783.857.857 0 00.435-.131l.013.022 19.518-11.238-.013-.022a.87.87 0 00.45-.753.87.87 0 00-.45-.752z" fill="#fff"/></svg>
            </div>
          </div>
        </div>
        <div class="w-full xl:w-1/2 featured-content">
         <span class="coloured">
        {{ $featured_home['coloured_text'] }}
      </span>
          <div class="content">
            {!! $featured_home['content'] !!}
          </div>
          @if(isset($featured_home['link']['title']))
            <a href="{{ $featured_home['link']['url'] }}" target="{{ $featured_home['link']['target'] }}" class="featured-link">
              <div class="link">
                {{ $featured_home['link']['title'] }}
              </div>
              <svg width="19" height="14" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05.765a.902.902 0 011.276 0l5.41 5.409a.903.903 0 010 1.276l-5.41 5.409a.903.903 0 01-1.276-1.277l4.772-4.77-4.772-4.77a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 6.812a.901.901 0 01.901-.902h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 6.812z" fill="#071D6F" stroke="#071D6F"/></svg>
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
