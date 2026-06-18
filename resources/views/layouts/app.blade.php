<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ !empty($meta_title) ? $meta_title : '' }}</title>

    @if(!empty($meta_description))
    <meta name="description" content="{{ $meta_description }}">
    @endif

    @if(!empty($meta_keywords))
    <meta name="keywords" content="{{ $meta_keywords }}">
    @endif

    @php
        $getSystemSettingApp = App\Models\SystemSettingModel::getSingle();
        $getPaymentIcons = App\Models\PaymentIconModel::where('status', 0)->orderBy('order_by', 'asc')->get();
    @endphp

    
    <link rel="shortcut icon" href="{{ $getSystemSettingApp ? $getSystemSettingApp->getFavicon() : '' }}">

    <!-- Corrected Font Awesome links -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Local CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @yield('style')

    <style>
        :root {
            --shop-ink: #171717;
            --shop-muted: #6f6f6f;
            --shop-line: #e9e4dc;
            --shop-soft: #faf8f4;
            --shop-panel: #ffffff;
            --shop-accent: #9a6f43;
            --shop-accent-dark: #6f4b29;
            --shop-success: #16845b;
            --shop-warning: #b7791f;
            --shop-danger: #c2413b;
            --shop-shadow: 0 18px 45px rgba(23, 23, 23, .08);
        }

        body {
            color: var(--shop-ink);
            background: #fff;
        }

        .container-fluid {
            max-width: 1440px;
        }

        .page-header {
            min-height: 190px;
            position: relative;
            overflow: hidden;
        }

        .page-header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, .68), rgba(0, 0, 0, .28));
            pointer-events: none;
        }

        .page-header .container,
        .page-header .container-fluid,
        .page-header .page-title {
            position: relative;
            z-index: 1;
        }

        .page-title {
            color: #fff;
            font-weight: 700;
            letter-spacing: 0;
        }

        .breadcrumb-nav {
            border-bottom: 1px solid var(--shop-line);
            background: var(--shop-soft);
        }

        .btn,
        .form-control,
        .summary,
        .table,
        .dropdown-menu {
            border-radius: 8px;
        }

        .btn {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .45rem;
            font-weight: 600;
            letter-spacing: 0;
        }

        .btn-outline-primary-2,
        .btn-primary,
        .btn-success {
            border-color: var(--shop-accent);
            background: var(--shop-accent);
            color: #fff;
        }

        .btn-outline-primary-2:hover,
        .btn-primary:hover,
        .btn-success:hover {
            border-color: var(--shop-accent-dark);
            background: var(--shop-accent-dark);
            color: #fff;
        }

        .btn-wishlist-add::before {
            content: '\f233' !important;
        }

        .product-card-soft {
            height: calc(100% - 2rem);
            border: 1px solid var(--shop-line);
            border-radius: 8px;
            padding: 1rem;
            background: var(--shop-panel);
            transition: box-shadow .2s ease, transform .2s ease, border-color .2s ease;
        }

        .product-card-soft:hover {
            border-color: rgba(154, 111, 67, .32);
            box-shadow: var(--shop-shadow);
            transform: translateY(-2px);
        }

        .product-card-soft .product-media {
            border-radius: 8px;
            overflow: hidden;
            background: #f5f2ed;
        }

        .product-card-soft .product-image {
            transition: transform .28s ease;
        }

        .product-card-soft:hover .product-image {
            transform: scale(1.035);
        }

        .product-card-soft .product-title {
            min-height: 44px;
        }

        .product-card-soft .product-price {
            color: var(--shop-accent-dark);
            font-weight: 700;
        }

        .product-card-swatches {
            display: flex;
            justify-content: center;
            gap: 7px;
            min-height: 24px;
            margin: .75rem 0 .35rem;
        }

        .product-card-swatch {
            width: 18px;
            height: 18px;
            border: 1px solid rgba(0, 0, 0, .18);
            border-radius: 50%;
            cursor: pointer;
            padding: 0;
        }

        .product-card-swatch.is-active {
            outline: 2px solid #222;
            outline-offset: 2px;
        }

        .product-card-note {
            color: var(--shop-muted);
            font-size: 12px;
            margin-top: .5rem;
        }

        .experience-panel {
            border: 1px solid var(--shop-line);
            border-radius: 8px;
            padding: 1.5rem;
            background: #fff;
        }

        .cart-empty-panel {
            border: 1px solid var(--shop-line);
            border-radius: 8px;
            padding: 3rem 1.5rem;
            text-align: center;
            background: #fff;
        }

        .checkout-steps {
            display: flex;
            gap: .75rem;
            margin-bottom: 2rem;
        }

        .checkout-step {
            flex: 1;
            border: 1px solid var(--shop-line);
            border-radius: 8px;
            padding: .95rem 1rem;
            background: #fff;
            color: var(--shop-muted);
        }

        .checkout-step.active {
            border-color: var(--shop-accent);
            background: var(--shop-soft);
            color: var(--shop-ink);
        }

        .customer-shell {
            padding: 3rem 0 4rem;
            background: linear-gradient(180deg, var(--shop-soft), #fff 36%);
        }

        .customer-sidebar {
            position: sticky;
            top: 90px;
            border: 1px solid var(--shop-line);
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 14px 35px rgba(23, 23, 23, .06);
            padding: 1.25rem;
        }

        .customer-sidebar__title {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--shop-line);
        }

        .customer-sidebar__title h4 {
            margin: 0;
            font-size: 1.7rem;
            font-weight: 700;
        }

        .customer-sidebar__title p {
            margin: .25rem 0 0;
            color: var(--shop-muted);
            font-size: 1.3rem;
        }

        .customer-sidebar .nav-dashboard {
            gap: .35rem;
        }

        .customer-sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            border-radius: 8px;
            padding: .9rem 1rem;
            color: var(--shop-ink);
            border: 1px solid transparent;
        }

        .customer-sidebar .nav-link:hover {
            color: var(--shop-accent-dark);
            background: var(--shop-soft);
        }

        .customer-sidebar .nav-link.active {
            color: #fff;
            background: var(--shop-ink);
        }

        .customer-sidebar .nav-link i {
            width: 18px;
            text-align: center;
        }

        .customer-card {
            border: 1px solid var(--shop-line);
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 14px 35px rgba(23, 23, 23, .05);
        }

        .customer-card__header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.5rem;
            border-bottom: 1px solid var(--shop-line);
        }

        .customer-card__header h2 {
            margin: 0;
            font-size: 2.4rem;
            font-weight: 700;
        }

        .customer-card__header p {
            margin: .35rem 0 0;
            color: var(--shop-muted);
        }

        .customer-metrics {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
            padding: 1.5rem;
        }

        .customer-metric {
            border: 1px solid var(--shop-line);
            border-radius: 8px;
            padding: 1.15rem;
            background: var(--shop-soft);
        }

        .customer-metric span {
            display: block;
            color: var(--shop-muted);
            font-size: 1.25rem;
        }

        .customer-metric strong {
            display: block;
            margin-top: .25rem;
            font-size: 2rem;
        }

        .table-polished {
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-polished thead th {
            border: 0;
            border-bottom: 1px solid var(--shop-line);
            background: #fff;
            color: var(--shop-muted);
            font-size: 1.25rem;
            text-transform: uppercase;
            letter-spacing: .04em;
            white-space: nowrap;
        }

        .table-polished tbody td {
            border-top: 0;
            border-bottom: 1px solid var(--shop-line);
            vertical-align: middle;
        }

        .table-polished tbody tr:hover {
            background: var(--shop-soft);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            min-height: 28px;
            padding: .35rem .75rem;
            border-radius: 999px;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .status-pill--pending { color: #7c4a03; background: #fff2cc; }
        .status-pill--progress { color: #075985; background: #dff3ff; }
        .status-pill--delivered { color: #365314; background: #e8f6d9; }
        .status-pill--completed { color: #166534; background: #dcfce7; }
        .status-pill--cancelled { color: #991b1b; background: #fee2e2; }

        .order-number {
            display: block;
            color: var(--shop-ink);
            font-weight: 700;
        }

        .order-meta {
            display: block;
            margin-top: .2rem;
            color: var(--shop-muted);
            font-size: 1.25rem;
        }

        @media (max-width: 767px) {
            .customer-sidebar {
                position: static;
                margin-bottom: 1.5rem;
            }

            .customer-card__header,
            .customer-metrics {
                display: block;
            }

            .customer-metric {
                margin-top: 1rem;
            }

            .table-polished thead {
                display: none;
            }

            .table-polished,
            .table-polished tbody,
            .table-polished tr,
            .table-polished td {
                display: block;
                width: 100%;
            }

            .table-polished tr {
                padding: 1rem 1.5rem;
                border-bottom: 1px solid var(--shop-line);
            }

            .table-polished tbody td {
                display: flex;
                justify-content: space-between;
                gap: 1rem;
                padding: .55rem 0;
                border: 0;
                text-align: right;
            }

            .table-polished tbody td::before {
                content: attr(data-label);
                color: var(--shop-muted);
                font-weight: 600;
                text-align: left;
            }
        }
    
        /* Pinterest masonry layout */
        .pinterest-style { margin: -4px; }
        .pinterest-masonry { column-count: 2; column-gap: 8px; column-fill: balance; }
        @media (min-width: 576px) { .pinterest-masonry { column-count: 2; } }
        @media (min-width: 768px) { .pinterest-masonry { column-count: 3; } }
        @media (min-width: 992px) { .pinterest-masonry { column-count: 4; } }
        @media (min-width: 1200px) { .pinterest-masonry { column-count: 5; } }
        .pinterest-item { display: block; margin-bottom: 8px; break-inside: avoid; }

        .filter-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--shop-soft);
            transition: background 0.2s ease;
        }
        .filter-icon:hover { background: var(--shop-accent); }
        .filter-icon:hover i { color: #fff; }
        .filter-icon i {
            font-size: 18px;
            color: var(--shop-ink);
        }

        /* Pinterest simplified product cards */
        .product-card-pinterest {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            background: #fff;
        }

        .product-card-image-wrapper {
            position: relative;
            width: 100%;
        }

        .product-card-pinterest img {
            width: 100%;
            height: auto;
            display: block;
        }

        .product-card-placeholder {
            width: 100%;
            height: 200px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-card-price-tag {
            position: absolute;
            bottom: 4px;
            right: 4px;
            background: rgba(255,255,255,0.9);
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            color: #333;
            backdrop-filter: blur(2px);
        }

        .product-card-title-link {
            text-decoration: none;
            display: block;
            padding: 6px 8px;
        }

        .product-card-title {
            font-size: 10px;
            font-weight: 400;
            color: #666;
            line-height: 1.3;
            text-transform: lowercase;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

</head>

<body>
    <div class="page-wrapper">
        
       @include('layouts._header')

       @yield('content')

       @include('layouts._footer')


    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    @include('layouts._mobile_menu')
    

    <!-- Sign in / Register Modal -->
    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                    <form action="" id="SubmitFormLogin" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="singin-email">Email Address *</label>
                                            <input type="text" class="form-control" id="singin-email" name="email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="singin-password">Password *</label>
                                            <input type="password" class="form-control" id="singin-password" name="password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" id="is_remember" class="custom-control-input" id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                            </div><!-- End .custom-checkbox -->

                                            <a href="{{ url('forgot-password') }}" class="forgot-link">Forgot Your Password?</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    
                                </div><!-- .End .tab-pane -->
                                <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                    <form action="" id="SubmitFormRegister" method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label for="register-name">First Name <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="register-name" name="name" required>
                                            </div><!-- End .col-md-6 -->

                                            <div class="col-md-6">
                                                <label for="register-lastName">Last Name <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control" id="register-lastName" name="last_name" required>
                                            </div><!-- End .col-md-6 -->
                                        </div><!-- End .form-group row -->

                                        <div class="form-group">
                                            <label for="register-email">Email address <span style="color: red;">*</span></label>
                                            <input type="email" class="form-control" id="register-email" name="email" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label for="register-password">Password <span style="color: red;">*</span></label>
                                            <input type="password" class="form-control" id="register-password" name="password" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy">I agree to the <a href="privacy-policy">privacy policy</a> *</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .form-footer -->
                                    </form>
                                    
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .modal-body -->
            </div><!-- End .modal-content -->
        </div><!-- End .modal-dialog -->
    </div><!-- End .modal -->

    <!-- <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="{{ url('assets/images/popup/newsletter/logo.png') }}" class="logo" alt="logo" width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Subscribe to the Molla eCommerce newsletter to receive timely updates from your favorite products.</p>
                            <form action="#">
                                <div class="input-group input-group-round">
                                    <input type="email" class="form-control form-control-white" placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><span>go</span></button>
                                    </div>
                                </div>
                            </form>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                <label class="custom-control-label" for="register-policy-2">Do not show this popup again</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5 ">
                        <img src="{{ url('assets/images/popup/newsletter/img-1.jpg') }}" class="newsletter-img" alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    
    <!-- Plugins JS File -->
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('assets/js/superfish.min.js') }}"></script>
    <script src="{{ url('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ url('assets/js/main.js') }}"></script>

    <script type="text/javascript">
        
        $('body').delegate('#SubmitFormLogin', 'submit', function(e){
            e.preventDefault();
            $.ajax({
				type: "POST",
				url: "{{ url('auth_login') }}",
				data: $(this).serialize(), // Serialize the form data
				dataType: "json",
				success: function(data) {
                    if(data.status == true)
                    {
                        location.reload();
                    }
                    else
                    {
                        alert(data.message);
                    }
				},
                
				error: function(data) {
					// Handle error
					console.error('An error occurred', data);
				}
        });
    });

        $('body').delegate('#SubmitFormRegister', 'submit', function(e){
            e.preventDefault();
            $.ajax({
				type: "POST",
				url: "{{ url('auth_register') }}",
				data: $(this).serialize(), // Serialize the form data
				dataType: "json",
				success: function(data) {
					alert(data.message);
                    if(data.status == true)
                    {
                        location.reload();
                    }
				},
				error: function(data) {
					// Handle error
					console.error('An error occurred', data);
				}
            });
        });

        $('body').delegate('.add_to_wishlist', 'click', function(e){
            var product_id = $(this).attr('id');
            $.ajax({
				type: "POST",
				url: "{{ url('add_to_wishlist') }}",
                data:{
                    "_token": "{{ csrf_token() }}",
                    product_id:product_id,
                },
				dataType: "json",
				success: function(data) {
					if(data.is_wishlist == 0)
                    {
                        $('.add_to_wishlist'+product_id).removeClass('btn-wishlist-add')
                    }
                    else
                    {
                        $('.add_to_wishlist'+product_id).addClass('btn-wishlist-add')
                    }
                    
				},
        });

    });

        $('body').delegate('.product-card-swatch', 'click', function(e){
            e.preventDefault();
            var image = $(this).attr('data-image');
            var card = $(this).closest('.product');

            if(image) {
                card.find('.product-card-image').attr('src', image);
            }

            card.find('.product-card-swatch').removeClass('is-active');
            $(this).addClass('is-active');
        });
    

    </script>

    @yield('script')
</body>

</html>



