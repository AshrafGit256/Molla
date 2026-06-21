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
            <nav aria-label="breadcrumb" class="breadcrumb-nav category-breadcrumb">
                <div class="container-fluid">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        @if(!empty($getSubCategory))
                            <li class="breadcrumb-item " aria-current="page"><a href="{{ url($getCategory->slug) }}">{{ $getCategory->name }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $getSubCategory->name }}</li>
						@elseif(!empty($getCategory))
                            <li class="breadcrumb-item active" aria-current="page">{{ $getCategory->name }}</li>
                        @endif
                        
                    </ol>
                </div>
            </nav>

            <div class="page-content category-page-content">
                <div class="container-fluid">
                	<div class="row">
                		<div class="col-12">
                			<div class="toolbox category-toolbox">
                				<div class="toolbox-left">
                					<div class="toolbox-info">
                						Showing <span>{{ $getProduct->total() }}</span> products
                					</div>
                				</div>

                				<div class="toolbox-right">
                					<div class="toolbox-sort">
                						<label for="sortby">Sort by:</label>
                						<div class="select-custom">
											<select name="sortby" id="sortby" class="form-control ChangeSortby">
												<option value="">Select</option>
												<option value="popularity">Most Popular</option>
												<option value="rating">Most Rated</option>
												<option value="date">Date</option>
											</select>
										</div>
                					</div>
                					
                				</div>
                			</div>
                           
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
