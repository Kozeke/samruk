import { getScrollbarWidth } from './helpers';

document.addEventListener('DOMContentLoaded', () => {

    const header = document.querySelector('.header');
    const wrap = document.querySelector('.wrap');

    // Nav
    if (window.innerWidth < 1440) {
        const navs = document.querySelectorAll('.nav .nav__item.has-subnav > .nav__link');
        const onClickNavItem = event => {
            event.preventDefault();

            const el = event.currentTarget;

            el.closest('.nav__item').classList.toggle('is-open');
        };

        navs.forEach(item => item.addEventListener('click', onClickNavItem));
    }

    // Nav toggle
    const toggle = document.querySelector('.js-header-toggle');
    const mobile = document.querySelector('.js-header-mob');
    const onToggleClick = () => {
        if (toggle.classList.contains('is-active')) {
            toggle.classList.remove('is-active');
            mobile.classList.remove('is-active');

            document.documentElement.classList.remove('no-scroll');
        } else {
            toggle.classList.add('is-active');
            mobile.classList.add('is-active');

            if (window.innerWidth < 576) {
                document.documentElement.classList.add('no-scroll');
            }
        }

        wrap.style.paddingTop = `${header.offsetHeight}px`;
        mobile.style.maxHeight = `calc(100vh - ${header.offsetHeight}px)`;
    };
    const onClickLinkAnchor = event => {
        const el = event.target.closest('a[data-link-anchor]');

        if (!el) return;

        toggle.classList.remove('is-active');
        mobile.classList.remove('is-active');
        document.documentElement.classList.remove('no-scroll');
    };

    toggle.addEventListener('click', onToggleClick);
    mobile.addEventListener('click', onClickLinkAnchor);

    // Sticky
    let oldScrollY = 0;
    const onScroll = () => {
        if (window.scrollY === 0) {
            header.classList.remove('header--sticky', 'header--hide');
        } else if (window.scrollY > header.offsetHeight) {
            if (window.scrollY < oldScrollY) {
                header.classList.add('header--sticky');
                header.classList.remove('header--hide');
            } else {
                if (header.classList.contains('header--sticky')) {
                    header.classList.add('header--hide');
                }
                header.classList.remove('header--sticky');
            }

            oldScrollY = window.scrollY;
        }
    };

    window.addEventListener('scroll', onScroll);

});

window.addEventListener('load', () => {

    const header = document.querySelector('.header');
    const navSubnavElems = document.querySelectorAll('.nav-subnav');
    const wrap = document.querySelector('.wrap');

    wrap.style.paddingTop = `${header.offsetHeight}px`;

    navSubnavElems.forEach(item => {
        if ((window.innerWidth - item.getBoundingClientRect().right - getScrollbarWidth()) < 0) {
            item.classList.add('nav-subnav--right');
        }
    });

});

