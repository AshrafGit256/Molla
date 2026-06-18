@extends('layouts.app')



@section('content')

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container-fluid">
                    @if(!empty($getSubCategory))
                        <h1 class="page-title">{{ $getSubCategory->name }}</h1>
                    @elseif(!empty($getCategory))
                        <h1 class="page-title">{{ $getCategory->name }}</h1>
					@else
						<h1 class="page-title">Search: {{ Request::get('q') }}</h1>
                    @endif
        			
        		</div>
        	</div>
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
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

            <div class="page-content">
                <div class="container-fluid">
                	<div class="row">
                		<div class="col-12">
                			<div class="toolbox">
                				<div class="toolbox-left">
                					<div class="toolbox-info">
                						Showing <span>{{ $getProduct->total() }} of {{ $getProduct->perPage() }}</span> Products
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



