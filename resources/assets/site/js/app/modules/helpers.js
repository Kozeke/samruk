/**
 * Generate svg icon
 *
 * @param name
 * @param mod
 * @returns {string}
 */
export function icon(name, mod = '') {
    const classes = name + ' ' + mod;

    return (`
        <svg class="icon ${classes.trim()}">
            <use xlink:href="#${name}"></use>
        </svg>
    `);
}

/**
 * Получение ширины скролбара
 *
 * @returns {number}
 */
export function getScrollbarWidth() {
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

/**
 * Get loader template
 *
 * @returns {string}
 */
export function getTemplateLoader() {
    return `
        <div class="loader">
            <div class="loader__spinner"><span class="loader__circle"></span></div>
        </div>
    `;
}

/**
 * Удаление ошибки в элементе формы
 *
 * @param el
 */
export function removeFormGroupError(el) {
    if (el && el.type !== 'hidden') {
        const field = el.closest('.form-group');

        if (!field) return;

        const errorElems = field.querySelectorAll('.form-group__error');

        field.classList.remove('has-error');
        errorElems.forEach(item => item.remove());
    }
}

/**
 * Добавление ошибки в элемент формы
 *
 * @param el
 * @param text
 */
export function renderFormGroupError(el, text) {
    if (el && el.type !== 'hidden') {
        const field = el.closest('.form-group');

        if (!field) return;

        const errorEl = document.createElement('div');

        errorEl.className = 'form-group__error';
        errorEl.textContent = text;

        field.classList.add('has-error');
        field.append(errorEl);
    }
}
