document.addEventListener('DOMContentLoaded', () => {

    const onClick = event => {
        const el = event.target.closest('.tabs__nav-item[href]');

        if (!el) return;

        event.preventDefault();

        const wrapper = el.closest('.tabs');
        const targetPane = wrapper.querySelector(el.hash);

        if (!targetPane) return;

        wrapper.querySelectorAll('.tabs__pane').forEach(item => item.style.display = 'none');
        targetPane.style.display = 'block';

        wrapper.querySelectorAll('.tabs__nav-item').forEach(item => item.classList.remove('is-active'));
        el.classList.add('is-active');
    };

    document.addEventListener('click', onClick);

});
