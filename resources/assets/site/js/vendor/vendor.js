import AOS from 'aos';
import Swiper, { Navigation, EffectFade, Autoplay, Lazy, Pagination } from 'swiper';
import axios from 'axios';
import LazyLoad from 'vanilla-lazyload';
import { MaskInput } from 'maska';
import GLightbox from 'glightbox';
// import Modal from './modal';

Swiper.use([Navigation, EffectFade, Autoplay, Lazy, Pagination]);

window.AOS = AOS;
window.axios = axios;
window.MaskInput = MaskInput;
// window.Modal = Modal;
window.Swiper = Swiper;
window.LazyLoad = LazyLoad;
window.GLightbox = GLightbox;
