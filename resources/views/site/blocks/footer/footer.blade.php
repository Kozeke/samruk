<footer class="footer">
    <div class="footer__inner container">
        <div class="footer__info footer__info--copyright" data-aos="fade-up" data-aos-delay="100">
            <div class="footer__info-body">
                <p>{!! str_replace('[year]', date('Y'), strip_tags(getPage('col-footer-copyright'))) !!}</p>
            </div>
        </div>

        {!! getLinks('col-footer-contacts', 'footer-contacts') !!}
    </div>
</footer>
