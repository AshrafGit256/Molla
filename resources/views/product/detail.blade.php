@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ url('assets/css/plugins/nouislider/nouislider.css') }}">
<style>
    .product-buy-panel {
        border: 1px solid #eeeeee;
        border-radius: 8px;
        padding: 2rem;
        background: #fff;
    }

    .product-proof-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .75rem;
        margin: 1.25rem 0;
    }

    .product-proof-item {
        border: 1px solid #eeeeee;
        border-radius: 8px;
        padding: .85rem;
        font-size: 13px;
        color: #555;
    }

    .product-proof-item strong {
        display: block;
        color: #222;
        font-size: 14px;
        margin-bottom: .15rem;
    }

    .variant-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    @media (max-width: 767px) {
        .product-buy-panel {
            padding: 1.25rem;
        }

        .product-proof-row {
            grid-template-columns: 1fr;
        }

        .product-details-action {
            position: sticky;
            bottom: 0;
            z-index: 5;
            background: #fff;
            padding: 1rem 0;
            border-top: 1px solid #eeeeee;
        }
    }
</style>
@endsection

@section('content')

<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container-fluid d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url($getProduct-> getCategory->slug) }}">{{ $getProduct-> getCategory->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url($getProduct-> getCategory->slug.'/'.$getProduct-> getSubCategory->slug) }}">{{ $getProduct-> getSubCategory->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $getProduct->title }}</li>
            </ol>


        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container-fluid">
            <div class="product-details-top mb-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery">
                            <figure class="product-main-image">
                                @php
                                $getProductImage = $getProduct->getImageSingle($getProduct->id);
                                @endphp

                                @if(!empty($getProductImage) && !empty($getProductImage->get_image()))
                                <img id="product-zoom" style="width: 600px; height: 700px; border-radius:20px;" src="{{ $getProductImage->get_image() }}" data-zoom-image="{{ $getProductImage->get_image() }}" alt="product image">

                                <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                    <i class="icon-arrows"></i>
                                </a>
                                @endif
                            </figure><!-- End .product-main-image -->

                            <div id="product-zoom-gallery" class="product-image-gallery">
                                @foreach($getProduct->getImage as $image)
                                <a class="product-gallery-item" style="width: 124px; height: 134px; margin-right: -70px;" href="#" data-colors="{{ implode(',', $image->colorIds()) }}" data-image="{{ $image-> get_image() }}" data-zoom-image="{{ $image-> get_image() }}">
                                    <img src="{{ $image-> get_image() }}" style="width: 120px; height: 130px; border-radius:20px;" alt="product side">
                                </a>
                                @endforeach
                            </div><!-- End .product-image-gallery -->
                        </div><!-- End .product-gallery -->
                    </div><!-- End .col-md-6 -->

                    <div class="col-md-6">
                        @include('admin.layouts._message')
                        <div class="product-details product-buy-panel">
                            <h1 class="product-title">{{ $getProduct->title }}</h1><!-- End .product-title -->

                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: {{ $getProduct->getReviewRating($getProduct->id) }}%;"></div><!-- End .ratings-val -->
                                </div><!-- End .ratings -->


                                <a class="ratings-text" href="#product-review-link" id="review-link">( {{ $getProduct->getTotalReview() }} Reviews )</a>
                            </div><!-- End .rating-container -->

                            <div class="product-price">
                                $<span id="getTotalPrice">{{ number_format($getProduct->price, 2) }}</span>
                            </div><!-- End .product-price -->

                            <div class="product-content">
                                <p>{{ $getProduct->short_description }}</p>
                            </div><!-- End .product-content -->

                            <div class="product-proof-row">
                                <div class="product-proof-item">
                                    <strong>{{ !empty($getProduct->in_stock) ? $getProduct->in_stock.' in stock' : 'Check stock' }}</strong>
                                    Ready for your selected options
                                </div>
                                <div class="product-proof-item">
                                    <strong>Easy returns</strong>
                                    Clear support after purchase
                                </div>
                                <div class="product-proof-item">
                                    <strong>Secure checkout</strong>
                                    Your order details stay protected
                                </div>
                            </div>

                            <form action="{{ url('product/add-to-cart') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{ $getProduct->id}}">
                                @if(!empty($getProduct->getColor->count()))
                                <div class="details-filter-row details-row-size">
                                    <label for="color" class="variant-label"><span>Color</span><small>Image updates when available</small></label>
                                    <div class="select-custom">
                                        <select name="color_id" id="color" required class="form-control">
                                            <option value="">Select a Color</option>
                                            @foreach($getProduct->getColor as $color)
                                            <option value="{{ $color->getColor->id }}">{{ $color->getColor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div><!-- End .select-custom -->

                                </div><!-- End .details-filter-row -->
                                @endif

                                @if(!empty($getProduct->getSize->count()))
                                <div class="details-filter-row details-row-size">
                                    <label for="size" class="variant-label"><span>Size</span><small>Choose your fit</small></label>
                                    <div class="select-custom">
                                        <select name="size_id" id="size" required class="form-control getSizePrice">
                                            <option data-price="0" value="">Select a Size</option>
                                            @foreach($getProduct->getSize as $size)
                                            <option data-price="{{ !empty($size->price) ? number_format($size->price, 2) : 0 }}" value="{{ $size->id }}">
                                                {{ $size->name }}
                                                @if(!empty($size->price))
                                                (${{ number_format($size->price, 2) }})
                                                @endif
                                            </option>

                                            @endforeach
                                        </select>
                                    </div><!-- End .select-custom -->

                                </div><!-- End .details-filter-row -->
                                @endif

                                <div class="details-filter-row details-row-size">
                                    <label for="qty">Quantity</label>
                                    <div class="product-details-quantity">
                                        <input type="number" id="qty" class="form-control" value="1" min="1" max="100" name="qty" required step="1" data-decimals="0" required>
                                    </div><!-- End .product-details-quantity -->
                                </div><!-- End .details-filter-row -->

                                <div class="product-details-action">

                                    <button type="submit" class="btn-product btn-cart">Add to cart</button>

                                    <div class="details-action-wrapper">
                                        @if(!empty(Auth::check()))
                                        <a href="javascript:;" class="add_to_wishlist add_to_wishlist{{ $getProduct->id }} {{ !empty($getProduct->checkWishList($getProduct->id)) ? 'btn-wishlist-add' : ''}} btn-product btn-wishlist" title="Wishlist" id="{{ $getProduct->id }}"><span>Add to Wishlist</span></a>
                                        @else
                                        <a href="#signin-modal" data-toggle="modal" class="btn-product btn-wishlist" title="Wishlist"><span>Add to Wishlist</span></a>
                                        @endif
                                    </div><!-- End .details-action-wrapper -->
                                </div><!-- End .product-details-action -->
                            </form>

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Explore:</span>
                                    <a href="{{ url($getProduct-> getCategory->slug) }}">{{ $getProduct-> getCategory->name }}</a>,
                                    <a href="{{ url($getProduct-> getCategory->slug.'/'.$getProduct-> getSubCategory->slug) }}">{{ $getProduct-> getSubCategory->name }}</a>
                                </div><!-- End .product-cat -->

                                <!-- <div class="social-icons social-icons-sm">
                                            <span class="social-label">Share:</span>
                                            <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                            <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                            <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                            <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                        </div> -->
                            </div><!-- End .product-details-footer -->
                        </div><!-- End .product-details -->
                    </div><!-- End .col-md-6 -->
                </div><!-- End .row -->
            </div><!-- End .product-details-top -->
        </div><!-- End .container -->

        <div class="product-details-tab product-details-extended">
            <div class="container-fluid">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Why you'll like it</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Fit & feel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Delivery & returns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">What customers say ({{ $getProduct->getTotalReview() }})</a>
                    </li>
                </ul>
            </div><!-- End .container -->

            <div class="tab-content">
                <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                    <div class="product-desc-content">
                        <div class="container-fluid" style="margin-top: 20px;">
                            {!! $getProduct->description !!}
                        </div><!-- End .container -->
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                    <div class="product-desc-content">
                        <div class="container-fluid" style="margin-top: 20px;">
                            {!! $getProduct->additional_information !!}
                        </div><!-- End .container -->
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                    <div class="product-desc-content">
                        <div class="container-fluid" style="margin-top: 20px;">
                            {!! $getProduct->shipping_returns !!}
                        </div><!-- End .container -->
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                    <div class="reviews">
                        <div class="container-fluid" style="margin-top: 20px;">
                            <h3>Reviews ({{ $getProduct->getTotalReview() }})</h3>

                            @foreach($getReviewProduct as $review)
                            <div class="review">
                                <div class="row no-gutters">

                                    <div class="col-auto">
                                        <h4><a href="#">{{ $review->name }}</a></h4>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val" style="width: {{ $review->getPercent() }}%;"></div>
                                            </div>
                                        </div>
                                        <span class="review-date">{{ Carbon\Carbon::parse($review->created_at)->diffForHumans()}}</span>
                                    </div>


                                    <div class="col">
                                        <h4>{{ $review->review }}</h4>
                                    </div><!-- End .col-auto -->
                                </div><!-- End .row -->
                            </div><!-- End .review -->
                            @endforeach

                            {!! $getReviewProduct->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}

                        </div><!-- End .container -->
                    </div><!-- End .reviews -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div><!-- End .product-details-tab -->

        <div class="container-fluid">
            <h2 class="title text-center mb-4" style="font-size: 38px;">You May Also Like</h2>
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>

                @foreach($getRelatedProduct as $value)

                @php
                $getProductImage = $value->getImageSingle($value->id);
                @endphp

                <div class="product product-7">
                    <figure class="product-media">
                        <!-- <span class="product-label label-new">New</span> -->
                        <a href="{{ url($value->slug) }}">
                            @if(!empty($getProductImage) && !empty($getProductImage->get_image()))
                            <img style="height: 280px; width: 100%; object-fit:cover;" src="{{ $getProductImage->get_image() }}" alt="{{ $value->title }}" class="product-image">
                            @endif
                        </a>

                        <div class="product-action-vertical">

                            @if(!empty(Auth::check()))
                            <a href="javascript:;" data-toggle="modal" class="add_to_wishlist add_to_wishlist{{ $value->id }}  btn-product-icon btn-wishlist btn-expandable {{ !empty($value->checkWishList($value->id)) ? 'btn-wishlist-add' : ''}} " id="{{ $value->id }}" title="Wishlist"><span>add to wishlist</span></a>
                            @else
                            <a href="#signin-modal" data-toggle="modal" class="btn-product-icon btn-wishlist btn-expandable" title="Wishlist"><span>add to wishlist</span></a>
                            @endif

                        </div><!-- End .product-action-vertical -->

                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <div class="product-cat">
                            <a href="{{ url($value->category_slug.'/'.$value->sub_category_slug) }}">{{ $value->sub_category_name }}</a>
                        </div><!-- End .product-cat -->
                        <h3 class="product-title"><a href="{{ url($value->slug) }}">{{ $value->title }}</a></h3><!-- End .product-title -->
                        <div class="product-price">
                            ${{ number_format($value->price, 2) }}
                        </div>

                        @if(isset($value->old_price) && $value->old_price)
                        <div class="old-price">
                            was ${{ number_format($value->old_price, 2) }}
                        </div>
                        @endif


                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: {{ $value->getReviewRating($value->id) }}%;"></div><!-- End .ratings-val -->
                            </div><!-- End .ratings -->
                            <span class="ratings-text">( ({{ $getProduct->getTotalReview() }}) Reviews )</span>
                        </div><!-- End .rating-container -->

                    </div><!-- End .product-body -->
                </div><!-- End .product -->

                @endforeach


            </div><!-- End .owl-carousel -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->


@endsection


@section('script')
<script src="{{ url('assets/js/bootstrap-input-spinner.js') }}"></script>
<script src="{{ url('assets/js/jquery.elevateZoom.min.js') }}"></script>
<script src="{{ url('assets/js/jquery.magnific-popup.min.js') }}"></script>

<script type="text/javascript">
    $('.getSizePrice').change(function() {
        var product_price = '{{ $getProduct->price }}';
        var price = $('option:selected', this).attr('data-price');
        var total = parseFloat(product_price) + parseFloat(price);
        $('#getTotalPrice').html(total.toFixed(2));
    });

    $('#color').change(function() {
        var colorId = $(this).val();

        if(!colorId) {
            return;
        }

        var matchedImage = $('.product-gallery-item').filter(function() {
            var colors = ($(this).data('colors') || '').toString().split(',');
            return colors.indexOf(colorId) !== -1;
        }).first();

        if(matchedImage.length) {
            var image = matchedImage.data('image');
            $('#product-zoom')
                .attr('src', image)
                .attr('data-zoom-image', image);

            $('.product-gallery-item').removeClass('active');
            matchedImage.addClass('active');
        }
    });
</script>

@endsection
