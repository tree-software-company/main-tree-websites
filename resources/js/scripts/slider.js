$(document).ready(function(){
    $('.long-slider').slick({
        autoplay: true,         // Włącz automatyczne przewijanie
        autoplaySpeed: 2000,    // Czas przewijania (2 sekundy)
        infinite: true,         // Pętla (slider nie zatrzymuje się)
        dots: true,             // Włącz punkty nawigacyjne
        arrows: false,          // Wyłącz strzałki nawigacyjne
        slidesToShow: 3,        // Liczba elementów, które będą widoczne na raz (możesz dostosować)
        slidesToScroll: 1,      // Liczba elementów przewijanych na raz
    });
});