<?php
  if(!empty($slideshows))
    {
?>
<section id="slide-shows" class="w-screen relative bg-primary">
  <div class="owl-carousel">
    @foreach($slideshows as $slideshow)
      <div class="slide-container" style="background-image: url('<?= $slideshow['image']['url']; ?>')">
        <div class="slider-bg">
          <div class="container slider-container flex justify-start items-start flex-col relative">
            <div class="title-bg relative">
              <div class="logo-images">
                @foreach($slideshow['logos'] as $logo)
                <img src="{{ $logo['full_image_url'] }}" alt="{{ $logo['title'] }}" title="{{ $logo['title'] }}" />
                @endforeach
              </div>
              <p class="subtitle text-white"><?= $slideshow['subtitle'] ?></p>
              <h1 class="text-primary"><?= $slideshow['title'] ?></h1>
            </div>
            <div class="button-group">
              @if(isset($slideshow['link']['title']))
                <a class="primary-button" href="<?= $slideshow['link']['url'] ?>" title="<?= $slideshow['link']['url'] ?>" target="<?= $slideshow['link']['target'] ?>">
                  <span>
                    {!! $slideshow['link']['title'] !!}
                  </span>
                  <svg width="19" height="15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.05 1.515a.901.901 0 011.276 0l5.41 5.409a.903.903 0 010 1.276l-5.41 5.409a.903.903 0 11-1.276-1.277l4.772-4.77-4.772-4.77a.903.903 0 010-1.277z" fill="#EDF2F7" stroke="#EDF2F7"/><path fill-rule="evenodd" clip-rule="evenodd" d="M1 7.562a.901.901 0 01.901-.902h14.295a.902.902 0 010 1.803H1.9A.901.901 0 011 7.562z" fill="#EDF2F7" stroke="#EDF2F7"/></svg>
                </a>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endforeach
    </div>
    <div class="relative container">
      <ul id="carousel-custom-dots" class="owl-dots">
        <li class='owl-dot'></li>
        <li class='owl-dot'></li>
        <li class='owl-dot'></li>
      </ul>
    </div>
</section>
<?php
  }
?>
