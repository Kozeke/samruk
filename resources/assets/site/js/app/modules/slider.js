document.addEventListener('DOMContentLoaded', () => {

    // Intro
    (() => {
        const swiper = new Swiper('.js-intro-slider', {
            speed: 700,
            slidesPerView: 1,
            effect: 'fade',
            loop: false,
            allowTouchMove: false,
            preloadImages: false,
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 1
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            autoplay: {
                delay: 5000
            }
        });

        swiper.autoplay.stop();

        window.addEventListener('load', () => swiper.autoplay.start());
    })();

    // About
    (() => {
        const swiper = new Swiper('.js-about-slider', {
            speed: 700,
            slidesPerView: 1,
            effect: 'fade',
            loop: false,
            allowTouchMove: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            autoplay: {
                delay: 3000
            }
        });

        swiper.autoplay.stop();

        window.addEventListener('load', () => swiper.autoplay.start());
    })();

    // Partners
    (() => {
        const swiper = new Swiper('.js-partners-slider', {
            speed: 700,
            slidesPerView: 1,
            spaceBetween: 40,
            loop: true,
            autoplay: {
                delay: 5000
            },
            preloadImages: false,
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 1
            },
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                },
                1440: {
                    slidesPerView: 4
                }
            }
        });

        swiper.autoplay.stop();

        window.addEventListener('load', () => swiper.autoplay.start());
    })();

    // Post images
    (() => {
        const swiper = new Swiper('.js-post-images', {
            speed: 700,
            slidesPerView: 1,
            effect: 'fade',
            loop: false,
            allowTouchMove: false,
            preloadImages: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 1
            },
            autoplay: {
                delay: 5000
            }
        });

        swiper.autoplay.stop();

        // window.addEventListener('load', () => swiper.autoplay.start());
    })();

});
