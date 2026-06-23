@extends('layouts.app')



@section('content')

<main class="main">
            @php
                $pageTitle = !empty($getSubCategory)
                    ? $getSubCategory->name
                    : (!empty($getCategory) ? $getCategory->name : 'Search: ' . Request::get('q'));
                $heroCategory = !empty($getCategory) ? $getCategory : null;
                $heroImage = !empty($heroCategory) ? $heroCategory->getImage() : '';
                $heroButton = !empty($heroCategory) && !empty($heroCategory->button_name) ? $heroCategory->button_name : 'Shop Collection';
                $titleMain = $pageTitle;
                $titleAccent = '';

                if (preg_match('/^(.*?)\s*(\(.*\))$/', $pageTitle, $matches)) {
                    $titleMain = trim($matches[1]);
                    $titleAccent = trim($matches[2]);
                }
            @endphp

        	<section class="category-hero-section">
        		<div class="container-fluid">
                    <div class="category-hero">
                    <div class="category-hero__content">
                        <span class="category-hero__eyebrow"><i class="fas fa-heart"></i> Fresh picks for little ones</span>
                        <h1 class="category-hero__title">
                            {{ $titleMain }}
                            @if(!empty($titleAccent))
                                <span>{{ $titleAccent }}</span>
                            @endif
                        </h1>
                        <p class="category-hero__text">Soft everyday essentials for comfort and gifting.</p>
                        @if(!empty($heroCategory))
                            <div class="category-hero__actions">
                                <a href="#getProductAjax" class="btn category-hero__button">
                                    <span>{{ $heroButton }}</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                                <span class="category-hero__trust"><i class="far fa-check-square"></i> Trusted by parents</span>
                            </div>
                        @endif
                    </div>
                    @if(!empty($heroImage))
                        <div class="category-hero__image">
                            <img src="{{ $heroImage }}" alt="{{ $pageTitle }}">
                        </div>
                    @endif
                    </div>
        		</div>
        	</section>
            <div class="page-content category-page-content">
                <div class="container-fluid">
                	<div class="row">
                		<div class="col-12">
							<div id="getProductAjax" >
								@include('product._list')
							</div>

							<div style="text-align:center;">
								@if(!empty($page))
									<a href="#" style="display: inline;" data-page="{{ $page }}" class="btn btn-primary LoadMore">Load More</a>
								@else
									<a href="#" style="display: none;" data-page="{{ $page }}" class="btn btn-primary LoadMore">Load More</a>
								@endif
							</div>



                		</div><!-- End .col-12 -->
            </div><!-- End .row -->
            </div><!-- End .container-fluid -->
        </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection
