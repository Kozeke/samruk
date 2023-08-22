document.addEventListener('DOMContentLoaded', () => {

    // Link anchor
    (() => {
        const anchors = document.querySelectorAll('a[data-link-anchor][href^="#"]');
        const onClick = event => {
            event.preventDefault();

            const target = document.querySelector(event.currentTarget.hash);

            if (!target) return;

            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        };

        anchors.forEach(el => el.addEventListener('click', onClick));
    })();

    // LazyLoad
    (() => {
        if (window.LazyLoad) new LazyLoad();
    })();

    // Collapse
    (() => {
        const onClick = event => {
            const element = event.target.closest('[data-collapse]');

            if (!element) return;

            event.preventDefault();

            const target = document.querySelector(element.dataset.collapse);

            if (!target) return;

            if (element.classList.contains('is-active')) {
                element.classList.remove('is-active');
                target.style.display = 'none';
            } else {
                element.classList.add('is-active');
                target.style.display = 'block';
            }
        };

        document.addEventListener('click', onClick);
    })();

});
