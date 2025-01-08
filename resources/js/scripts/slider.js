$(document).ready(function(){
  $('.short-slider').slick({
    autoplay: true,
    autoplaySpeed: 2000,
    accessibility: true,
    focusOnSelect: true,
    infinite: true,
    dots: true,
    arrows: false,
    slidesToShow: 1,
    slidesToScroll: 1,
  });
});

$(document).ready(function(){
  $('.long-slider').slick({
    autoplay: true,
    autoplaySpeed: 1000,
    infinite: true,
    dots: false,
    arrows: false,
    slidesToShow: 2,
    slidesToScroll: 1,
  });
});