window.addEventListener('load', () => {

    const preloader = document.querySelector('.preloader');

    if (preloader) {
        preloader.style.opacity = 0;
        preloader.addEventListener('transitionend', () => preloader.remove());
        document.documentElement.classList.remove('no-scroll');
    }

});
