export default {
  init() {
    // JavaScript to be fired on the home page
    //call the owl-carousel plugin
    $(document).ready(function(){
      let owl = $('#slide-shows .owl-carousel').owlCarousel({
        loop: true,
        responsiveClass: true,
        items: 1,
        animateOut: 'fadeOut',
        nav: false,
        autoplay: true,
        dotsContainer: '#carousel-custom-dots',
        autoplayTimeout: 10000,
        autoplayHoverPause:true,
      });

      $('.owl-dot').click(function() {
        owl.trigger('to.owl.carousel', [$(this).index(), 1000]);
      })
    });
  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
  },
};
