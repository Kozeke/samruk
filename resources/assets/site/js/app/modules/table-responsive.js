document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.formatted table:not(.js-table-no-wrap)').forEach(element => {
        const wrap = document.createElement('div');

        wrap.className = 'table-responsive';
        element.before(wrap);

        wrap.append(element);
    });

})
