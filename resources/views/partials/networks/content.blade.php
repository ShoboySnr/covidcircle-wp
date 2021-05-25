<section id="regions-content" class="bg-white">
  <div class="container">
    <div class="regions-container flex justify-start w-full flex-wrap" id="regions-container">
      @foreach($contents as $content)
      <div class="items-container">
        <div class="item-bg">
          <div class="flex justify-start items-center">
            @if(!empty($content['image']))
              <img src="{{ $content['image'] }}" title="{{ $content['title'] }}" />
            @endif
            <div class="title-description">
              <div class="title">
                @if(!empty($content['organisation_name']))
                <p class="organisation">{{$content['organisation_name'] }}</p>
                @endif
                <a class="title-link" href="{{ isset($content['link']['url']) ? $content['link']['url'] : ''  }}" title="{{ isset($content['link']['title']) ? $content['link']['title'] : '' }}" target="{{  isset($content['link']['target']) ? $content['link']['target'] : '' }}">{{ $content['title'] }}</a>
                <p>{{ $content['content'] }}</p>
                @if(!empty($content['themic_area']))
                  <p class="themic_area"> {{ $content['themic_area'] }} </p>
                @endif
                @if(!empty($content['link']))
                <a href="{{ isset($content['link']['url']) ? $content['link']['url'] : '' }}" class="primary-link" title="{{ isset($content['link']['title']) ? $content['link']['title'] : '' }}" target="{{  isset($content['link']['target']) ? $content['link']['target'] : '' }}">
                  <span>{{  $content['link']['title'] }}</span>
                  <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.28a.902.902 0 011.276 0l5.41 5.41a.903.903 0 010 1.276l-5.41 5.408a.903.903 0 11-1.276-1.276l4.772-4.77-4.772-4.771a.903.903 0 010-1.277z" fill="#071D6F" stroke="#071D6F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.327a.901.901 0 01.901-.901h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.327z" fill="#071D6F" stroke="#071D6F"/></svg>
                </a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
