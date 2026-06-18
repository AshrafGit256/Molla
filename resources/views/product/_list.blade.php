<div class="products mb-3 pinterest-style">
    <div class="pinterest-masonry">
        @foreach($getProduct as $value)
        @php
            $getProductImage = $value->getImageSingle($value->id);
        @endphp
        <div class="pinterest-item">
            <div class="product-card-pinterest">
                <div class="product-card-image-wrapper">
                    <a href="{{ url($value->slug) }}">
                        @if(!empty($getProductImage) && !empty($getProductImage->get_image()))
                        <img src="{{ $getProductImage->get_image() }}" alt="{{ $value->title }}">
                        @else
                        <div class="product-card-placeholder">
                            <span class="text-muted">No Image</span>
                        </div>
                        @endif
                    </a>
                    <div class="product-card-price-tag">UGX {{ number_format($value->price) }}</div>
                </div>
                <a href="{{ url($value->slug) }}" class="product-card-title-link">
                    <div class="product-card-title">{{ $value->title }}</div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
