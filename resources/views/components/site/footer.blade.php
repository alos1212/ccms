<footer class="site-footer" id="contact">
    <div class="site-shell site-footer-main">
        <section class="site-footer-contact" aria-labelledby="footer-contact-title">
            <h2 id="footer-contact-title">Send us a Message</h2>
            @if (session('contact_success'))
                <div class="site-footer-alert site-footer-alert-success">{{ session('contact_success') }}</div>
            @endif
            @if ($errors->has('captcha') || $errors->has('g-recaptcha-response'))
                <div class="site-footer-alert site-footer-alert-error">{{ $errors->first('captcha') ?: $errors->first('g-recaptcha-response') }}</div>
            @endif
            <form class="site-contact-form" action="{{ route('site.contact.store') }}" method="POST">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Name" aria-label="Name" required>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="E-mail" aria-label="E-mail" required>
                <textarea name="message" placeholder="Message" aria-label="Message" required>{{ old('message') }}</textarea>
                <div class="site-footer-form-row">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    <button class="site-action site-action--footer" type="submit">
                        SEND <span class="site-action__icon" aria-hidden="true"><i class="fa-solid fa-arrow-right"></i></span>
                    </button>
                </div>
            </form>
        </section>

        <section class="site-footer-corporate" aria-labelledby="footer-corporate-title">
            <h2 id="footer-corporate-title">Corporate Info</h2>
            <p>CAGE code: 4S8T2<br>
                NAICS codes: 561720, 561790, 561740, 561210,<br class="site-footer-wide-break"> 562910, 483210, 238990<br>
                DUNS: 800335742<br>
                SAM unique Entity ID: WRK2AEB5GP86</p>
        </section>

        <section class="site-footer-brand" aria-label="CCMS">
            <img src="{{ asset('images/page/logoblanco.png') }}" alt="CCMS Custom Cleaning Solutions">
            <div class="site-social-links" aria-label="Social media">
                <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
                <a href="#" aria-label="X"><i class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
                <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                <a href="#" aria-label="YouTube"><i class="fa-brands fa-youtube" aria-hidden="true"></i></a>
            </div>
        </section>
    </div>

    <div class="site-shell site-footer-locations">
        <div><span class="site-contact-symbol">⌖</span><strong>21 N Hepburn Ave #24 Jupiter, FL 33458</strong></div>
        <div><span class="site-contact-symbol">♧</span><strong>(561) 746-2700</strong></div>
        <div><span class="site-contact-symbol">⌖</span><strong>McAllen, TX 3700 W Ursula Ave, McAllen TX, 78503</strong></div>
    </div>

    <div class="site-shell site-footer-bottom">
        <span>© {{ date('Y') }}. All Rights Reserved.</span>
        <span><a href="#terms">Terms &amp; Conditions</a><a href="#privacy">Privacy Policy</a></span>
    </div>
</footer>
