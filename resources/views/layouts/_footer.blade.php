<style>
    .footer {
        color: #30333a;
        background: #fffaf6;
        font-size: 1.5rem;
        line-height: 1.7;
        overflow: hidden;
    }

    .footer a {
        color: inherit;
        text-decoration: none;
    }

    .footer a:hover,
    .footer a:focus {
        color: #ff4f88;
        text-decoration: none;
    }

    .footer-service-strip {
        position: relative;
        background: #fff;
        border-top: 1px solid #fff0f2;
        border-bottom: 1px solid #eee7e1;
        box-shadow: 0 10px 28px rgba(80, 54, 45, .05);
    }

    .footer-service-strip::before {
        content: "";
        display: block;
        height: 38px;
        background-image: url("data:image/svg+xml,%3Csvg width='82' height='14' viewBox='0 0 82 14' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 7C10 17 10-3 20 7s10 10 20 0 10-10 20 0 10 10 22 0' fill='none' stroke='%23ffd4dc' stroke-width='1.2' stroke-linecap='round'/%3E%3C/svg%3E");
        background-repeat: repeat-x;
        background-position: left center;
        opacity: .95;
    }

    .footer-services {
        display: grid;
        grid-template-columns: repeat(5, minmax(150px, 1fr));
        gap: 2.4rem;
        padding: 4.4rem 0 4.6rem;
    }

    .footer-service {
        display: flex;
        align-items: center;
        gap: 1.8rem;
        min-width: 0;
    }

    .footer-service-icon,
    .footer-social-link {
        width: 5.8rem;
        height: 5.8rem;
        flex: 0 0 5.8rem;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .footer-service-icon {
        font-size: 2.5rem;
    }

    .footer-service h5,
    .footer-column-title {
        color: #272a31;
        letter-spacing: 0;
        margin: 0;
        font-weight: 700;
    }

    .footer-service h5 {
        font-size: 1.6rem;
        line-height: 1.25;
    }

    .footer-service p {
        color: #60646d;
        margin: .2rem 0 0;
        font-size: 1.4rem;
        line-height: 1.45;
        letter-spacing: 0;
    }

    .footer-main {
        position: relative;
        padding: 5.8rem 0 3.8rem;
        background:
            radial-gradient(circle at 10% 0%, rgba(255, 223, 230, .42), transparent 26rem),
            radial-gradient(circle at 88% 22%, rgba(255, 237, 207, .42), transparent 28rem),
            #fffaf6;
    }

    .footer-main-grid {
        display: grid;
        grid-template-columns: minmax(220px, 1.35fr) repeat(3, minmax(140px, .85fr)) minmax(250px, 1.3fr);
        gap: 4.4rem;
        align-items: start;
    }

    .footer-brand-logo {
        display: inline-flex;
        align-items: center;
        margin-bottom: 2rem;
    }

    .footer-brand-logo img {
        width: 210px;
        max-height: 95px;
        object-fit: contain;
    }

    .footer-description {
        max-width: 265px;
        color: #50555e;
        font-size: 1.5rem;
        line-height: 1.85;
        letter-spacing: 0;
        margin: 0 0 3.2rem;
    }

    .footer-socials {
        display: flex;
        flex-wrap: wrap;
        gap: 1.2rem;
    }

    .footer-social-link {
        width: 4.4rem;
        height: 4.4rem;
        flex-basis: 4.4rem;
        font-size: 1.8rem;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .footer-social-link:hover,
    .footer-social-link:focus {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(46, 50, 60, .08);
    }

    .footer-column-title {
        font-size: 1.7rem;
        line-height: 1.25;
        margin-bottom: 2.3rem;
    }

    .footer-link-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-link-list li + li {
        margin-top: 1.45rem;
    }

    .footer-link {
        color: #50555e;
        font-size: 1.45rem;
        line-height: 1.35;
        letter-spacing: 0;
    }

    .footer-newsletter-copy {
        color: #50555e;
        font-size: 1.45rem;
        line-height: 1.8;
        max-width: 285px;
        margin: 0 0 2.2rem;
        letter-spacing: 0;
    }

    .footer-newsletter-form {
        max-width: 305px;
    }

    .footer-newsletter-form .form-control {
        width: 100%;
        height: 5.2rem;
        border: 1px solid #ddd9d5;
        background: #fff;
        color: #30333a;
        border-radius: 8px;
        box-shadow: none;
        padding: 0 1.7rem;
        font-size: 1.4rem;
        letter-spacing: 0;
    }

    .footer-newsletter-form .form-control::placeholder {
        color: #9b9da3;
    }

    .footer-newsletter-form .btn {
        width: 100%;
        height: 5.2rem;
        margin-top: 1.4rem;
        border: 0;
        border-radius: 8px;
        background: linear-gradient(180deg, #ff6799 0%, #ff3f80 100%);
        color: #fff;
        font-size: 1.5rem;
        font-weight: 700;
        text-transform: none;
        letter-spacing: 0;
        box-shadow: 0 12px 22px rgba(255, 79, 136, .18);
    }

    .footer-newsletter-form .btn:hover,
    .footer-newsletter-form .btn:focus {
        background: linear-gradient(180deg, #ff4f88 0%, #f12e72 100%);
        color: #fff;
    }

    .footer-offer {
        display: flex;
        align-items: center;
        gap: 1.1rem;
        margin-top: 2.6rem;
        color: #3f948d;
        font-weight: 700;
        font-size: 1.4rem;
        line-height: 1.4;
    }

    .footer-offer i {
        color: #4bb69d;
        font-size: 2rem;
    }

    .footer-rainbow {
        position: absolute;
        right: 4.5rem;
        bottom: 11rem;
        width: 190px;
        height: 150px;
        pointer-events: none;
    }

    .footer-rainbow-arc {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 150px;
        height: 118px;
        border-radius: 150px 150px 0 0;
        border-top: 13px solid #f6abb7;
        border-left: 13px solid #f6abb7;
        border-right: 13px solid #f6abb7;
    }

    .footer-rainbow-arc::before,
    .footer-rainbow-arc::after {
        content: "";
        position: absolute;
        left: 14px;
        right: 14px;
        bottom: 0;
        border-radius: 120px 120px 0 0;
    }

    .footer-rainbow-arc::before {
        top: 17px;
        border-top: 12px solid #ffd48e;
        border-left: 12px solid #ffd48e;
        border-right: 12px solid #ffd48e;
    }

    .footer-rainbow-arc::after {
        top: 38px;
        border-top: 11px solid #b7d8c0;
        border-left: 11px solid #b7d8c0;
        border-right: 11px solid #b7d8c0;
        box-shadow: inset 0 19px 0 -8px #c3afd4;
    }

    .footer-cloud {
        position: absolute;
        left: 4px;
        bottom: 1px;
        width: 88px;
        height: 38px;
        border-radius: 999px;
        background: #cbd9dc;
        box-shadow: 22px -10px 0 3px #d8e1e3, 48px -3px 0 0 #cbd9dc;
    }

    .footer-cloud::before,
    .footer-cloud::after {
        content: "";
        position: absolute;
        top: 20px;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #4c555c;
    }

    .footer-cloud::before {
        left: 30px;
        box-shadow: 32px 0 0 #4c555c;
    }

    .footer-cloud::after {
        left: 44px;
        top: 27px;
        width: 18px;
        height: 8px;
        border: 2px solid #ee8c8f;
        border-top: 0;
        background: transparent;
        border-radius: 0 0 16px 16px;
    }

    .footer-star {
        position: absolute;
        color: #ffc766;
        font-size: 2.2rem;
    }

    .footer-star.star-one {
        right: 14px;
        top: 11px;
    }

    .footer-star.star-two {
        left: 36px;
        top: 22px;
        color: #f5a8b9;
        font-size: 1.9rem;
    }

    .footer-bottom {
        position: relative;
        padding-top: 3rem;
        margin-top: 5.6rem;
        border-top: 1px solid rgba(49, 53, 60, .45);
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 2rem;
        align-items: center;
    }

    .footer-legal {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1.2rem 2rem;
        color: #676b72;
        font-size: 1.25rem;
    }

    .footer-legal span {
        color: #c4c0bc;
    }

    .footer-copyright {
        color: #60646d;
        margin: 0;
        font-size: 1.5rem;
        line-height: 1.4;
        letter-spacing: 0;
        text-align: center;
    }

    .footer-payments {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.2rem;
        margin: 0;
    }

    .footer-payments img {
        width: 58px;
        height: 34px;
        object-fit: contain;
        padding: 6px 9px;
        border: 1px solid #e4e0dc;
        border-radius: 5px;
        background: #fff;
    }

    .footer-payment-fallback {
        min-width: 58px;
        height: 34px;
        padding: 0 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e4e0dc;
        border-radius: 5px;
        background: #fff;
        color: #2f5796;
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: 0;
    }

    @media (max-width: 1199px) {
        .footer-services {
            grid-template-columns: repeat(3, minmax(180px, 1fr));
        }

        .footer-main-grid {
            grid-template-columns: 1.2fr repeat(3, 1fr);
        }

        .footer-newsletter {
            grid-column: 2 / -1;
        }

        .footer-rainbow {
            opacity: .5;
        }

        .footer-bottom {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .footer-legal,
        .footer-payments {
            justify-content: center;
        }
    }

    @media (max-width: 767px) {
        .footer-services,
        .footer-main-grid {
            grid-template-columns: 1fr;
            gap: 2.8rem;
        }

        .footer-services {
            padding: 3.2rem 0;
        }

        .footer-service {
            align-items: flex-start;
        }

        .footer-main {
            padding: 4rem 0 3rem;
        }

        .footer-newsletter {
            grid-column: auto;
        }

        .footer-rainbow {
            position: relative;
            right: auto;
            bottom: auto;
            margin: 2.8rem auto 0;
            opacity: 1;
        }

        .footer-bottom {
            margin-top: 3.8rem;
            padding-top: 2.4rem;
        }
    }
</style>

<footer class="footer">
    <div class="footer-service-strip">
        <div class="container-fluid">
            <div class="footer-services">
                <div class="footer-service">
                    <span class="footer-service-icon" style="background: #fff0f4; color: #ff5b89;">
                        <i class="fas fa-truck"></i>
                    </span>
                    <div>
                        <h5>Free Shipping</h5>
                        <p>On orders over $49</p>
                    </div>
                </div>

                <div class="footer-service">
                    <span class="footer-service-icon" style="background: #edf8f4; color: #42b18d;">
                        <i class="fas fa-rotate"></i>
                    </span>
                    <div>
                        <h5>Easy Returns</h5>
                        <p>Within 14 days</p>
                    </div>
                </div>

                <div class="footer-service">
                    <span class="footer-service-icon" style="background: #f4effa; color: #8e60b4;">
                        <i class="fas fa-shield-alt"></i>
                    </span>
                    <div>
                        <h5>Safe &amp; Secure</h5>
                        <p>100% secure checkout</p>
                    </div>
                </div>

                <div class="footer-service">
                    <span class="footer-service-icon" style="background: #fff0f4; color: #ff5b89;">
                        <i class="far fa-heart"></i>
                    </span>
                    <div>
                        <h5>Loved by Parents</h5>
                        <p>Trusted by 10,000+ families</p>
                    </div>
                </div>

                <div class="footer-service">
                    <span class="footer-service-icon" style="background: #fff8ec; color: #f5ab27;">
                        <i class="fas fa-gift"></i>
                    </span>
                    <div>
                        <h5>Gift Wrapping</h5>
                        <p>Make it extra special</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-main">
        <div class="container-fluid">
            <div class="footer-main-grid">
                <div class="footer-brand">
                    <a href="{{ url('') }}" class="footer-brand-logo">
                        <img src="{{ $getSystemSettingApp->getLogo() }}" alt="{{ $getSystemSettingApp->website_name }}">
                    </a>

                    <p class="footer-description">
                        {{ !empty($getSystemSettingApp->footer_description) ? $getSystemSettingApp->footer_description : 'Adorable styles, happy smiles. Comfortable, trendy & quality clothing for your little ones.' }}
                    </p>

                    <div class="footer-socials">
                        @if(!empty($getSystemSettingApp->instagram_link))
                            <a href="{{ $getSystemSettingApp->instagram_link }}" class="footer-social-link" style="background: #fbf1f8; color: #f25b91;" title="Instagram" target="_blank" rel="noopener">
                                <i class="icon-instagram"></i>
                            </a>
                        @endif
                        @if(!empty($getSystemSettingApp->facebook_link))
                            <a href="{{ $getSystemSettingApp->facebook_link }}" class="footer-social-link" style="background: #eff2fb; color: #3158a3;" title="Facebook" target="_blank" rel="noopener">
                                <i class="icon-facebook-f"></i>
                            </a>
                        @endif
                        @if(!empty($getSystemSettingApp->pinterest_link))
                            <a href="{{ $getSystemSettingApp->pinterest_link }}" class="footer-social-link" style="background: #fff1f1; color: #d82939;" title="Pinterest" target="_blank" rel="noopener">
                                <i class="icon-pinterest"></i>
                            </a>
                        @endif
                        @if(!empty($getSystemSettingApp->twitter_link))
                            <a href="{{ $getSystemSettingApp->twitter_link }}" class="footer-social-link" style="background: #eef7ff; color: #40a7df;" title="Twitter" target="_blank" rel="noopener">
                                <i class="icon-twitter"></i>
                            </a>
                        @endif
                        @if(!empty($getSystemSettingApp->youtube_link))
                            <a href="{{ $getSystemSettingApp->youtube_link }}" class="footer-social-link" style="background: #fff1f1; color: #e63c3f;" title="Youtube" target="_blank" rel="noopener">
                                <i class="icon-youtube"></i>
                            </a>
                        @endif
                        @if(!empty($getSystemSettingApp->email))
                            <a href="mailto:{{ $getSystemSettingApp->email }}" class="footer-social-link" style="background: #eef9f5; color: #39af8d;" title="Email">
                                <i class="far fa-envelope"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="footer-column">
                    <h4 class="footer-column-title">Shop</h4>
                    <ul class="footer-link-list">
                        <li><a href="{{ url('search') }}" class="footer-link">New Arrivals</a></li>
                        <li><a href="{{ url('search?search=baby') }}" class="footer-link">Baby (0-12 Months)</a></li>
                        <li><a href="{{ url('search?search=toddler') }}" class="footer-link">Toddler (1-3 Years)</a></li>
                        <li><a href="{{ url('search?search=kids') }}" class="footer-link">Kids (3-7 Years)</a></li>
                        <li><a href="{{ url('search?search=sale') }}" class="footer-link">Sale</a></li>
                        <li><a href="{{ url('search?search=gift') }}" class="footer-link">Gift Cards</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-column-title">Customer Service</h4>
                    <ul class="footer-link-list">
                        <li><a href="{{ url('contact') }}" class="footer-link">Contact Us</a></li>
                        <li><a href="{{ url('faq') }}" class="footer-link">FAQ</a></li>
                        <li><a href="{{ url('shipping') }}" class="footer-link">Shipping &amp; Delivery</a></li>
                        <li><a href="{{ url('return') }}" class="footer-link">Returns &amp; Exchanges</a></li>
                        <li><a href="{{ url('payment-methods') }}" class="footer-link">Payment Methods</a></li>
                        <li><a href="{{ url('orders') }}" class="footer-link">Track Your Order</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4 class="footer-column-title">About Us</h4>
                    <ul class="footer-link-list">
                        <li><a href="{{ url('about') }}" class="footer-link">Our Story</a></li>
                        <li><a href="{{ url('contact') }}" class="footer-link">Careers</a></li>
                        <li><a href="{{ url('about') }}" class="footer-link">Sustainability</a></li>
                        <li><a href="{{ url('blog') }}" class="footer-link">Blog</a></li>
                        <li><a href="{{ url('contact') }}" class="footer-link">Press</a></li>
                        <li><a href="{{ url('contact') }}" class="footer-link">Become a Partner</a></li>
                    </ul>
                </div>

                <div class="footer-newsletter">
                    <h4 class="footer-column-title">Stay in the Loop</h4>
                    <p class="footer-newsletter-copy">Sign up for exclusive offers, new arrivals &amp; parenting tips.</p>

                    <form class="footer-newsletter-form" action="javascript:void(0);">
                        <input type="email" class="form-control" placeholder="Enter your email" aria-label="Email address">
                        <button type="submit" class="btn">Subscribe</button>
                    </form>

                    <div class="footer-offer">
                        <i class="fas fa-gift"></i>
                        <span>Get 10% off your first order!</span>
                    </div>
                </div>
            </div>

            <div class="footer-rainbow" aria-hidden="true">
                <span class="footer-star star-one"><i class="fas fa-star"></i></span>
                <span class="footer-star star-two"><i class="fas fa-star"></i></span>
                <div class="footer-rainbow-arc"></div>
                <div class="footer-cloud"></div>
            </div>

            <div class="footer-bottom">
                <div class="footer-legal">
                    <a href="{{ url('terms-condition') }}">Terms &amp; Conditions</a>
                    <span>|</span>
                    <a href="{{ url('privacy-policy') }}">Privacy Policy</a>
                    <span>|</span>
                    <a href="{{ url('faq') }}">Cookies Policy</a>
                </div>

                <p class="footer-copyright">&copy; {{ date('Y') }} {{ $getSystemSettingApp->website_name }}. All Rights Reserved.</p>

                <figure class="footer-payments">
                    @forelse($getPaymentIcons as $icon)
                        <img src="{{ $icon->getImage() }}" alt="Payment method" loading="lazy">
                    @empty
                        <span class="footer-payment-fallback">VISA</span>
                        <span class="footer-payment-fallback">MC</span>
                        <span class="footer-payment-fallback">AMEX</span>
                        <span class="footer-payment-fallback">PayPal</span>
                    @endforelse
                </figure>
            </div>
        </div>
    </div>
</footer>
