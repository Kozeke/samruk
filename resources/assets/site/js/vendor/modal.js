export default class Modal {
    static initialized;
    element;
    selectors = {
        modal: '.modal',
        show: '[data-modal]',
        hide: '.modal__close',
        content: '.modal__content',
        overlay: '.modal__overlay',
    };
    events = {
        show: 'modal-show',
        hide: 'modal-hide',
    };

    constructor(element = null) {
        this.element = element;
    }

    onClickShow = event => {
        const element = event.target.closest(this.selectors.show);

        if (!element) return;

        event.preventDefault();

        const id = element.getAttribute('data-modal');
        const modal = document.getElementById(id);

        this.show(modal);
    }

    onClickHide = event => {
        const element = event.target.closest(this.selectors.hide);

        if (!element) return;

        const modal = element.closest(this.selectors.modal);

        this.hide(modal);
    }

    onClickOutsideHide = event => {
        const modal = event.target.closest(this.selectors.modal);
        const content = event.target.closest(this.selectors.content);

        if (content && content.contains(event.target)) return;

        if (modal) this.hide(modal);
    }

    initialize() {
        if (!Modal.initialized) {
            this.initEventListeners();
        }
    }

    initEventListeners() {
        document.addEventListener('click', this.onClickShow);
        document.addEventListener('click', this.onClickHide);
        document.addEventListener('click', this.onClickOutsideHide);
    }

    removeEventListeners() {
        document.removeEventListener('click', this.onClickShow);
        document.removeEventListener('click', this.onClickHide);
        document.removeEventListener('click', this.onClickOutsideHide);
    }

    show(modal = this.element) {
        if (!modal) return;

        const body = document.body;
        const modalOverlay = modal.querySelector(this.selectors.overlay);
        const modalContent = modal.querySelector(this.selectors.content);

        body.style.setProperty('overflow', 'hidden');
        body.style.setProperty('padding-right', this.getScrollbarWidth() + 'px');

        modal.classList.add('is-show');

        setTimeout(() => {
            modalOverlay.style.opacity = '1';

            modalContent.style.transform = 'none';
            modalContent.style.opacity = '1';

            this.dispatchEvent(modal, this.events.show);
        }, 1);
    }

    hide(modal = this.element) {
        if (!modal) return;

        const body = document.body;
        const modalOverlay = modal.querySelector(this.selectors.overlay);
        const modalContent = modal.querySelector(this.selectors.content);

        modalOverlay.removeAttribute('style');
        modalContent.removeAttribute('style');

        setTimeout(() => {
            modal.classList.remove('is-show');

            body.style.removeProperty('overflow');
            body.style.removeProperty('padding-right');

            this.dispatchEvent(modal, this.events.hide);
        }, 200);
    }

    dispatchEvent(element, type) {
        element?.dispatchEvent(new CustomEvent(type, { bubbles: true }));
    }

    getScrollbarWidth() {
        const wrapper = document.createElement('div');

        wrapper.style.visibility = 'hidden';
        wrapper.style.overflow = 'scroll';
        wrapper.style.msOverflowStyle = 'scrollbar';

        document.body.append(wrapper);

        const element = document.createElement('div');

        wrapper.append(element);

        const width = (wrapper.offsetWidth - element.offsetWidth);

        wrapper.remove();

        return width;
    }

    remove() {
        this.element?.remove();
    }

    destroy() {
        this.removeEventListeners();
        this.element = null;
        Modal.initialized = null;
    }
}
