@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="{{ url('assets/css/plugins/nouislider/nouislider.css') }}">
<style>
    .pin-product-page {
        background: #fafafa;
        padding-bottom: 3rem;
    }

    .pin-product-grid {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 1.2rem;
        align-items: start;
    }

    .pin-product-focus {
        grid-column: span 4;
        display: grid;
        grid-template-columns: minmax(280px, 1.05fr) minmax(320px, .95fr);
        gap: 1.4rem;
        min-height: 620px;
        padding: 1.4rem;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 12px 36px rgba(31, 31, 31, .06);
    }

    .pin-back-link {
        position: absolute;
        top: 1.2rem;
        left: 1.2rem;
        z-index: 2;
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #111;
        background: rgba(255, 255, 255, .88);
        box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
    }

    .pin-focus-media {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        background: #f4f4f4;
        min-height: 560px;
    }

    .pin-focus-media img {
        width: 100%;
        height: 100%;
        min-height: 560px;
        display: block;
        object-fit: cover;
    }

    .pin-focus-placeholder,
    .pin-card-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 260px;
        color: #777;
        background: #f1f1f1;
    }

    .pin-thumb-row {
        display: flex;
        gap: .65rem;
        margin-top: .8rem;
        overflow-x: auto;
        padding-bottom: .2rem;
    }

    .pin-thumb {
        flex: 0 0 74px;
        height: 80px;
        border: 2px solid transparent;
        border-radius: 8px;
        overflow: hidden;
        background: #f4f4f4;
    }

    .pin-thumb.active {
        border-color: #a8d2ff;
    }

    .pin-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .pin-focus-details {
        padding: .5rem .3rem;
    }

    .pin-focus-details .product-title {
        margin-bottom: .6rem;
        font-size: 2.6rem;
        line-height: 1.15;
        font-weight: 500;
        color: #171717;
    }

    .pin-focus-details .product-price {
        margin: .8rem 0 1rem;
        color: #8fc5ff;
        font-size: 2.3rem;
        font-weight: 500;
    }

    .pin-product-summary {
        color: #646464;
        font-size: 1.5rem;
        line-height: 1.65;
    }

    .pin-proof-row {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: .7rem;
        margin: 1.6rem 0 1.2rem;
    }

    .pin-proof-item {
        min-height: 96px;
        border: 1px solid #ececec;
        border-radius: 8px;
        padding: .9rem;
        color: #666;
        font-size: 1.25rem;
        line-height: 1.45;
    }

    .pin-proof-item strong {
        display: block;
        margin-bottom: .25rem;
        color: #161616;
        font-size: 1.35rem;
    }

    .variant-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .pin-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
        margin-top: 1rem;
    }

    .pin-actions .btn-cart {
        min-width: 220px;
        justify-content: center;
        border-color: #b6dbff;
        color: #8fc5ff;
        background: #fff;
    }

    .pin-actions .btn-cart:hover {
        color: #fff;
        background: #8fc5ff;
    }

    .pin-explore {
        margin-top: 1.2rem;
        padding-top: 1rem;
        border-top: 1px solid #eeeeee;
    }

    .pin-product-card {
        break-inside: avoid;
        overflow: hidden;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .08);
    }

    .pin-product-card a {
        text-decoration: none;
    }

    .pin-card-image {
        position: relative;
        display: block;
        background: #f3f3f3;
    }

    .pin-card-image img {
        width: 100%;
        min-height: 220px;
        max-height: 420px;
        display: block;
        object-fit: cover;
    }

    .pin-card-price {
        position: absolute;
        right: .55rem;
        bottom: .55rem;
        padding: .28rem .55rem;
        border-radius: 8px;
        background: rgba(255, 255, 255, .92);
        color: #333;
        font-size: 1.05rem;
        font-weight: 600;
    }

    .pin-card-body {
        padding: .75rem .85rem .9rem;
    }

    .pin-card-title {
        margin: 0;
        color: #555;
        font-size: 1.2rem;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pin-card-meta {
        margin-top: .35rem;
        color: #999;
        font-size: 1.05rem;
    }

    .pin-detail-tabs {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e8e8e8;
    }

    .pin-tab-content {
        padding: 1.4rem 0;
        color: #555;
        line-height: 1.7;
    }

    @media (max-width: 1199px) {
        .pin-product-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .pin-product-focus {
            grid-column: span 4;
        }
    }

    @media (max-width: 991px) {
        .pin-product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .pin-product-focus {
            grid-column: span 2;
            grid-template-columns: 1fr;
            min-height: 0;
        }

        .pin-focus-media,
        .pin-focus-media img {
            min-height: 420px;
        }
    }

    @media (max-width: 767px) {
        .pin-product-grid {
            grid-template-columns: 1fr;
        }

        .pin-product-focus {
            grid-column: span 1;
            padding: 1rem;
        }

        .pin-focus-details .product-title {
            font-size: 2.1rem;
        }

        .pin-proof-row {
            grid-template-columns: 1fr;
        }

        .pin-actions {
            position: sticky;
            bottom: 0;
            z-index: 5;
            padding: 1rem 0;
            background: #fff;
            border-top: 1px solid #eeeeee;
        }

        .pin-actions .btn-cart {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
@php
    $mainImage = $getProduct->getImageSingle($getProduct->id);
    $companionProducts = isset($getCategoryProducts) && $getCategoryProducts->count() ? $getCategoryProducts : $getRelatedProduct;
@endphp

<main class="main pin-product-page">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container-fluid d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url($getProduct->getCategory->slug) }}">{{ $getProduct->getCategory->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ url($getProduct->getCategory->slug.'/'.$getProduct->getSubCategory->slug) }}">{{ $getProduct->getSubCategory->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $getProduct->title }}</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container-fluid">
            <div class="pin-product-grid">
                <section class="pin-product-focus">
                    <div>
                        <div class="pin-focus-media">
                            <a href="javascript:history.back()" class="pin-back-link" aria-label="Go back">
                                <i class="icon-long-arrow-left"></i>
                            </a>

                            @if(!empty($mainImage) && !empty($mainImage->get_image()))
                            <img id="product-zoom" src="{{ $mainImage->get_image() }}" data-zoom-image="{{ $mainImage->get_image() }}" alt="{{ $getProduct->title }}">
                            @else
                            <div class="pin-focus-placeholder">No Image</div>
                            @endif
                        </div>

                        @if(!empty($getProduct->getImage->count()))
                        <div id="product-zoom-gallery" class="pin-thumb-row">
                            @foreach($getProduct->getImage as $image)
                            <a class="pin-thumb product-gallery-item {{ $loop->first ? 'active' : '' }}" href="#" data-colors="{{ implode(',', $image->colorIds()) }}" data-image="{{ $image->get_image() }}" data-zoom-image="{{ $image->get_image() }}">
                                <img src="{{ $image->get_image() }}" alt="{{ $getProduct->title }} view {{ $loop->iteration }}">
                            </a>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <div class="pin-focus-details product-details">
                        @include('admin.layouts._message')

                        <h1 class="product-title">{{ $getProduct->title }}</h1>

                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: {{ $getProduct->getReviewRating($getProduct->id) }}%;"></div>
                            </div>
                            <a class="ratings-text" href="#product-review-link" id="review-link">( {{ $getProduct->getTotalReview() }} Reviews )</a>
                        </div>

                        <div class="product-price">
                            <span id="getTotalPrice">{{ App\Support\Money::format($getProduct->price) }}</span>
                        </div>

                        <div class="pin-product-summary">
                            <p>{{ $getProduct->short_description }}</p>
                        </div>

                        <div class="pin-proof-row">
                            <div class="pin-proof-item">
                                <strong>{{ !empty($getProduct->in_stock) ? $getProduct->in_stock.' in stock' : 'Check stock' }}</strong>
                                Ready for your selected options
                            </div>
                            <div class="pin-proof-item">
                                <strong>Easy returns</strong>
                                Clear support after purchase
                            </div>
                            <div class="pin-proof-item">
                                <strong>Secure checkout</strong>
                                Your order details stay protected
                            </div>
                        </div>

                        <form action="{{ url('product/add-to-cart') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="product_id" value="{{ $getProduct->id }}">

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
                                </div>
                            </div>
                            @endif

                            @if(!empty($getProduct->getSize->count()))
                            <div class="details-filter-row details-row-size">
                                <label for="size" class="variant-label"><span>Size</span><small>Choose your fit</small></label>
                                <div class="select-custom">
                                    <select name="size_id" id="size" required class="form-control getSizePrice">
                                        <option data-price="0" value="">Select a Size</option>
                                        @foreach($getProduct->getSize as $size)
                                        <option data-price="{{ !empty($size->price) ? $size->price : 0 }}" value="{{ $size->id }}">
                                            {{ $size->name }}
                                            @if(!empty($size->price))
                                            ({{ App\Support\Money::format($size->price) }})
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif

                            <div class="details-filter-row details-row-size">
                                <label for="qty">Quantity</label>
                                <div class="product-details-quantity">
                                    <input type="number" id="qty" class="form-control" value="1" min="1" max="100" name="qty" required step="1" data-decimals="0">
                                </div>
                            </div>

                            <div class="pin-actions product-details-action">
                                <button type="submit" class="btn-product btn-cart">Add to cart</button>

                                <div class="details-action-wrapper">
                                    @if(!empty(Auth::check()))
                                    <a href="javascript:;" class="add_to_wishlist add_to_wishlist{{ $getProduct->id }} {{ !empty($getProduct->checkWishList($getProduct->id)) ? 'btn-wishlist-add' : ''}} btn-product btn-wishlist" title="Wishlist" id="{{ $getProduct->id }}"><span>Add to Wishlist</span></a>
                                    @else
                                    <a href="#signin-modal" data-toggle="modal" class="btn-product btn-wishlist" title="Wishlist"><span>Add to Wishlist</span></a>
                                    @endif
                                </div>
                            </div>
                        </form>

                        <div class="pin-explore product-details-footer">
                            <div class="product-cat">
                                <span>Explore:</span>
                                <a href="{{ url($getProduct->getCategory->slug) }}">{{ $getProduct->getCategory->name }}</a>,
                                <a href="{{ url($getProduct->getCategory->slug.'/'.$getProduct->getSubCategory->slug) }}">{{ $getProduct->getSubCategory->name }}</a>
                            </div>
                        </div>
                    </div>
                </section>

                @foreach($companionProducts as $value)
                @php
                    $cardImage = $value->getImageSingle($value->id);
                @endphp
                <article class="pin-product-card">
                    <a href="{{ url($value->slug) }}" class="pin-card-image">
                        @if(!empty($cardImage) && !empty($cardImage->get_image()))
                        <img src="{{ $cardImage->get_image() }}" alt="{{ $value->title }}">
                        @else
                        <div class="pin-card-placeholder">No Image</div>
                        @endif
                        <span class="pin-card-price">{{ App\Support\Money::format($value->price) }}</span>
                    </a>
                    <div class="pin-card-body">
                        <a href="{{ url($value->slug) }}">
                            <h2 class="pin-card-title">{{ $value->title }}</h2>
                        </a>
                        @if(!empty($value->sub_category_name))
                        <div class="pin-card-meta">{{ $value->sub_category_name }}</div>
                        @endif
                    </div>
                </article>
                @endforeach
            </div>

            <div class="pin-detail-tabs product-details-tab product-details-extended">
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

                <div class="tab-content pin-tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                        {!! $getProduct->description !!}
                    </div>
                    <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                        {!! $getProduct->additional_information !!}
                    </div>
                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                        {!! $getProduct->shipping_returns !!}
                    </div>
                    <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                        <div class="reviews">
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
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            {!! $getReviewProduct->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
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
        $('#getTotalPrice').html('UGX ' + Math.round(total).toLocaleString());
    });

    $('.product-gallery-item').click(function(e) {
        e.preventDefault();
        var image = $(this).data('image');

        if(!image) {
            return;
        }

        $('#product-zoom')
            .attr('src', image)
            .attr('data-zoom-image', image);

        $('.product-gallery-item').removeClass('active');
        $(this).addClass('active');
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
            matchedImage.trigger('click');
        }
    });
</script>
@endsection
