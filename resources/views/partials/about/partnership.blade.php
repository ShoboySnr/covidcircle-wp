@if(!empty($partnership))
<section id="about-partnership" class="w-screen">
  <div class="container">
      <div class="title">
        <h2><?= __('A partnership between', 'covid-circle-wp') ?></h2>
      </div>
      <div class="content">
        <div class="flex flex-wrap justify-start items-start items-container">
          @if(!empty($partnership['first_logo']) || !empty($partnership['first_content']))
          <div class="item flex flex-col">
            @if(!empty($partnership['first_image']) || !empty($partnership['first_image_link']['url']))
            <div class="img-content">
              @if(!empty($partnership['first_image_link']['url']))
                <a href="{{ $partnership['first_image_link']['url'] }}" title="{{ $partnership['first_image_link']['title'] }}" target="{{ $partnership['first_image_link']['target'] }}">
                  <img src="{{ $partnership['first_image']['url'] }}" alt="{{ $partnership['first_image']['title'] }}" title="{{ $partnership['first_image']['title'] }}" />
                </a>
              @else
                <img src="{{ $partnership['first_image']['url'] }}" alt="{{ $partnership['first_image']['title'] }}" title="{{ $partnership['first_image']['title'] }}" />
              @endif
            </div>
            @endif
            @if(!empty($partnership['first_content']))
            <div class="details">
             {!! $partnership['first_content'] !!}
            </div>
            @endif
          </div>
          @endif
          @if(!empty($partnership['second_image']) || !empty($partnership['second_content']))
          <div class="item flex flex-col">
            @if(!empty($partnership['second_image']) || !empty($partnership['second_image_logo']['url']))
              <div class="img-content">
                @if(!empty($partnership['second_image_link']['url']))
                  <a href="{{ $partnership['second_image_link']['url'] }}" title="{{ $partnership['second_image_link']['title'] }}" target="{{ $partnership['second_image_link']['target'] }}">
                    <img src="{{ $partnership['second_image']['url'] }}" alt="{{ $partnership['second_image']['title'] }}" title="{{ $partnership['second_image']['title'] }}" />
                  </a>
                @else
                  <img src="{{ $partnership['second_image']['url'] }}" alt="{{ $partnership['second_image']['title'] }}" title="{{ $partnership['second_image']['title'] }}" />
                @endif
              </div>
            @endif
            @if(!empty($partnership['second_content']))
              <div class="details">
                {!! $partnership['second_content'] !!}
              </div>
            @endif
          </div>
          @endif
        </div>
      </div>
  </div>
</section>
  @endif
