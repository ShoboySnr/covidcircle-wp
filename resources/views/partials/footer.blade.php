<?php
$footer = App::get_footer();

$footer_logos = $footer['logos'];
?>
<footer id="footer"  class="bg-black relative">
  @if(!empty($footer['mailchimp_shortcode']))
    @include('partials.footer.contact-form', ['mailchimp_shortcode' => $footer['mailchimp_shortcode']])
   @endif
  <div class="container">
    <div class="flex justify-start flex-wrap flex-col xl:flex-row footer-group">
      <div class="contact_info">
        <div class="logo_gallery flex flex-wrap items-center">
          @if(!empty($footer_logos))
            @foreach($footer_logos as $footer_logo)
              @if(!empty($footer_logo['footer_logo_link']))
                <a href="{{ $footer_logo['footer_logo_link']['url'] }}" class="footer-logo" target="{{ $footer_logo['footer_logo_link']['target'] }}" title="{{ $footer_logo['footer_logo_link']['title'] }}">
                  <img src="{{ $footer_logo['footer_logo']['url'] }}" title="{{ $footer_logo['footer_logo']['title'] }}" alt="{{ $footer_logo['footer_logo']['title'] }}" />
                </a>
              @else
                <img src="{{ $footer_logo['footer_logo']['url'] }}" class="footer-logo" title="{{ $footer_logo['footer_logo']['title'] }}" alt="{{ $footer_logo['footer_logo']['title'] }}" />
              @endif
            @endforeach
          @endif
        </div>
        <div class="details">
          @if(!empty($footer['title']))
          <h3>{{ $footer['title'] }}</h3>
          @endif
          @if(!empty($footer['address']))
          <div class="address">
            {!! $footer['address'] !!}
          </div>
          @endif
          @if(!empty($footer['email']))
          <div class="email">
            <a href="mailto: {{ $footer['email'] }}" target="_blank">
              {{ $footer['email'] }}
            </a>
          </div>
          @endif
          @if(!empty($footer['phone_number']))
            <div class="phone_number">
              <a href="tel: {{ $footer['phone_number'] }}" target="_blank">
                {{ $footer['phone_number'] }}
              </a>
            </div>
          @endif
        </div>
      </div>
      <div class="contact_menu">
        <nav class="footer_menu">
          @if (has_nav_menu('footer_navigation_1'))
            {!! wp_nav_menu(['theme_location' => 'footer_navigation_1', 'menu_class' => 'nav']) !!}
          @endif
        </nav>
      </div>
      <div class="contact_menu">
        <nav class="footer_menu">
          @if (has_nav_menu('footer_navigation_2'))
            {!! wp_nav_menu(['theme_location' => 'footer_navigation_2', 'menu_class' => 'nav']) !!}
          @endif
        </nav>
      </div>
    </div>
    <div class="copyrights">
      <div class="content w-full text-center">
        <p>{{ $footer['copyrights'] }} <?= __('Designed and built by', 'covid-circle-wp') ?> <a href="https://studio14online.co.uk" target="_blank" class="footer-link text-bold">
            <?= __('Studio14', 'covid-circle') ?>
          </a></p>
      </div>
    </div>
  </div>
</footer>
