<div class="products mb-3">
    <div class="row justify-content-center">

        @foreach($getProduct as $value)
        @php
            $getProductImage = $value->getImageSingle($value->id);
            $productImages = $value->getImage;
            $categorySlug = $value->category_slug ?? optional($value->getCategory)->slug;
            $subCategorySlug = $value->sub_category_slug ?? optional($value->getSubCategory)->slug;
            $subCategoryName = $value->sub_category_name ?? optional($value->getSubCategory)->name;
        @endphp


        <div class="col-12 @if(!empty($is_home)) col-md-3 col-lg-3 @else col-md-4 col-lg-4 @endif">
            <div class="product product-7 text-center product-card-soft">
                <figure class="product-media">
                    <a href="{{ url($value->slug) }}">
                        @if(!empty($getProductImage) && !empty($getProductImage->get_image()))
                        <img style="height: 280px; width: 100%; object-fit:cover;" src="{{ $getProductImage->get_image() }}" alt="{{ $value->title }}" class="product-image product-card-image">
                        @endif
                    </a>

                    <div class="product-action-vertical">
                        <div class="product-action-vertical">

                            @if(!empty(Auth::check()))
                            <a href="javascript:;" data-toggle="modal" class="add_to_wishlist add_to_wishlist{{ $value->id }}  btn-product-icon btn-wishlist btn-expandable {{ !empty($value->checkWishList($value->id)) ? 'btn-wishlist-add' : ''}} " id="{{ $value->id }}" title="Wishlist"><span>add to wishlist</span></a>
                            @else
                            <a href="#signin-modal" data-toggle="modal" class="btn-product-icon btn-wishlist btn-expandable" title="Wishlist"><span>add to wishlist</span></a>
                            @endif

                        </div><!-- End .product-action-vertical -->
                    </div><!-- End .product-action-vertical -->

                </figure><!-- End .product-media -->

                <div class="product-body">
                    <div class="product-cat">
                        <a href="{{ url($categorySlug.'/'.$subCategorySlug) }}">{{ $subCategoryName }}</a>
                    </div><!-- End .product-cat -->
                    <h3 class="product-title"><a href="{{ url($value->slug) }}">{{ $value->title }}</a></h3><!-- End .product-title -->
                    @if(!empty($value->getColor->count()))
                    <div class="product-card-swatches" aria-label="Available colors">
                        @foreach($value->getColor as $pcolor)
                            @php
                                $swatchImage = null;
                                foreach($productImages as $image) {
                                    if(in_array($pcolor->color_id, $image->colorIds()) && !empty($image->get_image())) {
                                        $swatchImage = $image->get_image();
                                        break;
                                    }
                                }
                                if(empty($swatchImage) && !empty($getProductImage)) {
                                    $swatchImage = $getProductImage->get_image();
                                }
                            @endphp
                            <button type="button" class="product-card-swatch" data-image="{{ $swatchImage }}" style="background: {{ $pcolor->getColor->code }};" title="{{ $pcolor->getColor->name }}">
                                <span class="sr-only">{{ $pcolor->getColor->name }}</span>
                            </button>
                        @endforeach
                    </div>
                    @endif
                    <div class="product-price">
                        {{ App\Support\Money::format($value->price) }}
                    </div>

                    @if(isset($value->old_price) && $value->old_price)
                    <div class="old-price">
                        was {{ App\Support\Money::format($value->old_price) }}
                    </div>
                    @endif


                    <div class="ratings-container">
                        <div class="ratings">
                            <div class="ratings-val" style="width: {{ $value->getReviewRating($value->id) }}%;"></div><!-- End .ratings-val -->
                        </div><!-- End .ratings -->
                        <span class="ratings-text">( {{ $value->getTotalReview() }} Reviews )</span>
                    </div><!-- End .rating-container -->

                    <div class="product-card-note">
                        @if(!empty($value->in_stock))
                            In stock • Fast checkout
                        @else
                            Availability on request
                        @endif
                    </div>

                </div><!-- End .product-body -->
            </div><!-- End .product -->
        </div><!-- End .col-sm-6 col-lg-4 -->
        @endforeach


    </div><!-- End .row -->
</div><!-- End .products -->
