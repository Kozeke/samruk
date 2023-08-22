const onAccordionClick = event => {
    const element = event.target.closest('[data-accordion]');

    if (!element) return;

    event.preventDefault();

    const wrap = element.closest('.accordion');
    const item = element.closest('.accordion__item');
    const content = item.querySelector('.accordion__content');
    const height = content.offsetHeight + getMarginTopAndBottom(content);

    if (item.classList.contains('is-active')) {
        item.classList.remove('is-active');
        content.parentElement.style.cssText = '';
    } else {
        wrap.querySelectorAll('.accordion__item').forEach(item => {
            const content = item.querySelector('.accordion__content');

            item.classList.remove('is-active');
            content.parentElement.style.cssText = '';
        });

        item.classList.add('is-active');
        content.parentElement.style.maxHeight = `${height}px`;
    }
};
const getMarginTopAndBottom = element => {
    const styles = getComputedStyle(element);

    return parseFloat(styles['marginTop']) + parseFloat(styles['marginBottom']);
};

document.addEventListener('click', onAccordionClick);
