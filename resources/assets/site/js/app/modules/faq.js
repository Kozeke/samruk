const onFaqToggleClick = event => {
    const element = event.target.closest('.faq-item__toggle');

    if (!element) return;

    event.preventDefault();

    const wrap = element.closest('.faq-list');
    const item = element.closest('.faq-item');
    const content = item.querySelector('.faq-item__content');
    const height = content.offsetHeight + getMarginTopAndBottom(content);
    const { textOpen, textClose } = element.dataset;

    if (item.classList.contains('is-active')) {
        item.classList.remove('is-active');
        content.parentElement.style.cssText = '';
        element.innerText = textOpen;
    } else {
        wrap.querySelectorAll('.faq-item').forEach(item => {
            const content = item.querySelector('.faq-item__content');
            const toggle = item.querySelector('.faq-item__toggle');

            item.classList.remove('is-active');
            content.parentElement.style.cssText = '';
            toggle.innerText = textOpen;
        });

        item.classList.add('is-active');
        content.parentElement.style.maxHeight = `${height}px`;
        element.innerText = textClose;
    }
};
const getMarginTopAndBottom = element => {
    const styles = getComputedStyle(element);

    return parseFloat(styles['marginTop']) + parseFloat(styles['marginBottom']);
};

document.addEventListener('click', onFaqToggleClick);
