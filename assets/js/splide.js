import Splide from '@splidejs/splide';
import '../css/splide.css';

const splide = new Splide('.splide', {
    type: 'fade',
    rewind: true,
    lazyLoad: 'nearby',
    autoplay: true,
    perPage: 1,
    speed: 5000,
    interval: 15000,
    resetProgress: false,
    pagination: true,
    arrows: false,
    cover: true,
    fixedHeight: 500,
    mediaQuery: 'min',
    breakpoints: {
        600: {
            fixedHeight: 600,
        },
        1024: {
            fixedHeight: 800,
        },
    }
});
splide.mount();