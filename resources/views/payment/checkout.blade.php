@extends('layouts.app')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
	.checkout-steps {
		display: flex;
		gap: .75rem;
		margin-bottom: 2rem;
	}

	.checkout-step {
		flex: 1;
		border: 1px solid #eeeeee;
		border-radius: 8px;
		padding: .85rem 1rem;
		background: #fff;
		color: #777;
	}

	.checkout-step.active {
		border-color: #222;
		color: #222;
	}

	.checkout-comfort {
		border: 1px solid #eeeeee;
		border-radius: 8px;
		padding: 1rem;
		margin-bottom: 1.5rem;
		background: #fff;
	}

	.checkout-order-item {
		display: flex;
		gap: .75rem;
		align-items: center;
	}

	.checkout-order-item img {
		width: 46px;
		height: 46px;
		object-fit: cover;
		border-radius: 8px;
	}

	.delivery-panel {
		border: 1px solid #eeeeee;
		border-radius: 8px;
		padding: 1.25rem;
		margin: 1.5rem 0;
		background: #fff;
	}

	.delivery-estimate {
		border-radius: 8px;
		padding: 1rem;
		background: #f8f9fa;
		display: none;
	}

	.delivery-map {
		height: 320px;
		border-radius: 8px;
		border: 1px solid #eeeeee;
		margin: 1rem 0;
		overflow: hidden;
	}

	.ug-location-help {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: .75rem;
		margin: 1rem 0;
	}

	.ug-location-help div {
		border: 1px solid #eeeeee;
		border-radius: 8px;
		padding: .85rem;
		background: #fff;
		font-size: 13px;
	}

	@media (max-width: 767px) {
		.checkout-steps,
		.ug-location-help {
			display: block;
		}

		.checkout-step,
		.ug-location-help div {
			margin-bottom: .75rem;
		}
	}
</style>
@endsection

@section('content')

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container-fluid">
        			<h1 class="page-title">Checkout<span>Shop</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container-fluid">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
            	<div class="checkout">
	                <div class="container-fluid">
            			<form action="" id="SubmitForm" method="post">
							{{ csrf_field() }}
							<div class="checkout-steps">
								<div class="checkout-step"><strong>Cart</strong><br><small>Reviewed</small></div>
								<div class="checkout-step active"><strong>Details</strong><br><small>Delivery information</small></div>
								<div class="checkout-step"><strong>Payment</strong><br><small>Confirm order</small></div>
							</div>
		                	<div class="row">
		                		<div class="col-lg-9">
									<div class="checkout-comfort">
										<strong>Almost there.</strong>
										<span>We will use these details to deliver your order and send updates.</span>
									</div>
		                			<h2 class="checkout-title">Delivery details</h2><!-- End .checkout-title -->
		                				<div class="row">
		                					<div class="col-sm-6">
		                						<label>First Name *</label>
		                						<input type="text" value="{{ !empty(Auth::user()->name) ? Auth::user()->name: '' }}" name="first_name" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>Last Name *</label>
		                						<input type="text" value="{{ !empty(Auth::user()->last_name) ? Auth::user()->last_name: '' }}" name="last_name" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

	            						<label>Business / Shop Name (Optional)</label>
	            						<input type="text" value="{{ !empty(Auth::user()->company_name) ? Auth::user()->company_name: '' }}" name="company_name" class="form-control">

	            						<input type="hidden" value="Uganda" name="country">
										<input type="hidden" value="Central" name="state">
										<input type="hidden" value="00000" name="postcode">

	            						<label>Area / Village / Trading Centre *</label>
	            						<input type="text" value="{{ !empty(Auth::user()->address_one) ? Auth::user()->address_one: '' }}" name="address_one" class="form-control" placeholder="Example: Kireka, Bweyogerere, Kansanga, Wandegeya" required>
	            						<label>Nearest landmark, stage, building, or shop</label>
	            						<input type="text" value="{{ !empty(Auth::user()->address_two) ? Auth::user()->address_two: '' }}" name="address_two" class="form-control" placeholder="Example: near Shell, behind the taxi stage, opposite the church">

	            						<div class="row">
		                					<div class="col-sm-6">
		                						<label>Town / District *</label>
		                						<input type="text" value="{{ !empty(Auth::user()->city) ? Auth::user()->city: '' }}" name="city" class="form-control" placeholder="Example: Kampala, Wakiso, Mukono, Entebbe" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>Phone / WhatsApp *</label>
		                						<input type="tel" value="{{ !empty(Auth::user()->phone) ? Auth::user()->phone: '' }}" name="phone" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

	                					<label>Email address *</label>
	        							<input type="email" value="{{ !empty(Auth::user()->email) ? Auth::user()->email: '' }}" name="email" class="form-control" required>

										<div class="delivery-panel">
											<h3 class="checkout-title mb-2">Fast boda delivery</h3>
											<p class="mb-2">Drop the pin where the rider should come. You can also use your current location if you are already at the delivery place.</p>
											<div class="ug-location-help">
												<div><strong>1. Tell us the area</strong><br>Use names people know: stage, school, mall, church, market.</div>
												<div><strong>2. Pin the place</strong><br>Tap the map or use current location.</div>
												<div><strong>3. Get boda estimate</strong><br>We calculate fee and time before you pay.</div>
											</div>
											<label>Delivery notes for the rider *</label>
											<input type="text" name="delivery_address" id="DeliveryAddress" class="form-control" placeholder="Example: Kireka, near Shell, call when at the gate" required>
											<div id="DeliveryMap" class="delivery-map"></div>
											<input type="hidden" name="delivery_latitude" id="DeliveryLatitude" required>
											<input type="hidden" name="delivery_longitude" id="DeliveryLongitude" required>
											<input type="hidden" name="delivery_fee" id="DeliveryFee" value="0">
											<input type="hidden" name="delivery_distance_km" id="DeliveryDistanceKm" value="">
											<input type="hidden" name="delivery_duration_minutes" id="DeliveryDurationMinutes" value="">
											<div class="d-flex flex-wrap" style="gap: .75rem;">
												<button type="button" id="UseCurrentLocation" class="btn btn-outline-dark-2">Use my current location</button>
												<button type="button" id="CalculateDelivery" class="btn btn-outline-primary-2">Calculate delivery</button>
											</div>
											<div id="DeliveryEstimate" class="delivery-estimate mt-2"></div>
										</div>

										@if(empty(Auth::check()))

	        							<div class="custom-control custom-checkbox">
											<input type="checkbox" name="is_create" class="custom-control-input createAccount" id="checkout-create-acc">
											<label class="custom-control-label" for="checkout-create-acc">Create an account?</label>
										</div><!-- End .custom-checkbox -->

										<div id="showPassword" style="display: none;">
											<label>Password *</label>
											<input type="text" id="inputPassword" name="password" class="form-control">
										</div>

										@endif

	                					<label>Order notes (optional)</label>
	        							<textarea class="form-control" name="note" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
		                		</div><!-- End .col-lg-9 -->
		                		<aside class="col-lg-3">
		                			<div class="summary">
		                				<h3 class="summary-title">Your Order</h3><!-- End .summary-title -->

		                				<table class="table table-summary">
		                					<thead>
		                						<tr>
		                							<th>Product</th>
		                							<th>Total</th>
		                						</tr>
		                					</thead>

		                					<tbody>
											@foreach(Cart::getContent() as $key => $cart)
												@php
													$getCartProduct = App\Models\ProductModel::getSingle($cart->id);
													$cartImage = App\Models\ProductModel::getImageForColor($getCartProduct->id, $cart->attributes->color_id ?? null);
												@endphp
		                						<tr>
		                							<td>
														<div class="checkout-order-item">
															@if(!empty($cartImage) && !empty($cartImage->get_image()))
																<img src="{{ $cartImage->get_image() }}" alt="{{ $getCartProduct->title }}">
															@endif
															<div>
																<a href="{{ url($getCartProduct->slug) }}">{{ $getCartProduct ->title }}</a>
																<div><small>Qty: {{ $cart->quantity }}</small></div>
															</div>
														</div>
													</td>
		                							<td>{{ App\Support\Money::format($cart->price) }}</td>
		                						</tr>
											@endforeach
		                						<tr class="summary-subtotal">
		                							<td>Subtotal:</td>
		                							<td>{{ App\Support\Money::format(Cart::getSubTotal()) }}</td>
		                						</tr><!-- End .summary-subtotal -->
		                						

												<tr>
													<td colspan="2">
													<div class="cart-discount">
															<div class="input-group">
																<input type="text" name="discount_code" id="getDiscountCode" class="form-control" placeholder="Discount Code">
																<div class="input-group-append">
																	<button type="button" id="ApplyDiscount" style="height: 38px;" class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
																</div><!-- .End .input-group-append -->
															</div><!-- End .input-group -->
													</div><!-- End .cart-discount -->
													</td>
												</tr>

		                						<tr>
		                							<td>Discount:</td>
		                							<td><span id="getDiscountAmount">UGX 0</span></td>
		                						</tr><!-- End .summary-subtotal -->

												<tr class="summary-shipping">
													<td>Boda delivery:</td>
													<td><span id="DeliveryFeeDisplay">Calculate</span></td>
												</tr>
												<!-- Standard shipping choices are kept as a fallback but hidden while fast delivery is primary. -->
												<tr style="display:none;">
													<td colspan="2">
														<input type="hidden" name="shipping" value="">
													</td>
												</tr>
												{{--
												@foreach($getShippingCharge as $shipping)
													<tr class="summary-shipping-row">
														<td>
															<div class="custom-control custom-radio">
																<input type="radio" 
																	value="{{ $shipping->id }}" 
																	id="free-shipping{{ $shipping->id }}" 
																	required 
																	name="shipping" 
																	data-price="{{ !empty($shipping->price) ? $shipping->price : 0 }}" 
																	class="custom-control-input get_shipping_charge">
																<label class="custom-control-label" for="free-shipping{{ $shipping->id }}">
																	{{ $shipping->name }}
																</label>
															</div><!-- End .custom-control -->
														</td>
														<td>
															@if(!empty($shipping->price))
																${{ number_format($shipping->price, 2) }}
															@else
																Free
															@endif
														</td>
													</tr><!-- End .summary-shipping-row -->
												@endforeach
												--}}

												
		                						<tr class="summary-total">
		                							<td>Total:</td>
		                							<td><span id="getPayableTotal">{{ App\Support\Money::format(Cart::getSubTotal()) }}</span></td>
		                						</tr><!-- End .summary-total -->
		                					</tbody>
		                				</table><!-- End .table table-summary -->

										<input type="hidden" id="getshippingChargeTotal" value="0">
										<input type="hidden" id="PayableTotal" value="{{ Cart::getSubTotal() }}">
		                				
										<div class="accordion-summary" id="accordion-payment">
										    
										<div class="custom-control custom-radio">
											<input type="radio" value="cash" id="CashOnDelivery" required name="payment_method" class="custom-control-input">
											<label class="custom-control-label" for="CashOnDelivery">Cash On Delivery</label>
										</div>

										<div class="custom-control custom-radio" style="margin-top: 0px;">
											<input type="radio" value="mtn_mobile_money" id="MtnMobileMoney" required name="payment_method" class="custom-control-input">
											<label class="custom-control-label" for="MtnMobileMoney">MTN Mobile Money</label>
										</div>

										<div class="custom-control custom-radio" style="margin-top: 0px;">
											<input type="radio" value="airtel_money" id="AirtelMoney" required name="payment_method" class="custom-control-input">
											<label class="custom-control-label" for="AirtelMoney">Airtel Money</label>
										</div>

										<div class="custom-control custom-radio" style="margin-top: 0px;">
											<input type="radio" value="gt_bank" id="GtBank" required name="payment_method" class="custom-control-input">
											<label class="custom-control-label" for="GtBank">GT Bank Transfer</label>
										</div>
										    

										    
										    
										</div><!-- End .accordion -->

										<p class="text-center mb-1"><small>Secure checkout. You can review before payment is completed.</small></p>
		                				<button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
		                					<span class="btn-text">Place Order</span>
		                					<span class="btn-hover-text">Proceed to Checkout</span>
		                				</button>
										<br /><br />
										<img src="{{ url('assets/images/payments-summary.png') }}">
		                			</div><!-- End .summary -->
		                		</aside><!-- End .col-lg-3 -->
		                	</div><!-- End .row -->
            			</form>
	                </div><!-- End .container -->
                </div><!-- End .checkout -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        	


@endsection        
    

@section('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script type="text/javascript">
	var storeLatitude = {{ $storeLatitude }};
	var storeLongitude = {{ $storeLongitude }};
	var deliveryMap;
	var storeMarker;
	var customerMarker;
	var routeLine;

	function bootDeliveryMap() {
		if(typeof L === 'undefined') {
			$('#DeliveryEstimate').show().html('Map could not load. You can still use your current location button.');
			return;
		}

		deliveryMap = L.map('DeliveryMap').setView([storeLatitude, storeLongitude], 12);
		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '&copy; OpenStreetMap'
		}).addTo(deliveryMap);

		storeMarker = L.marker([storeLatitude, storeLongitude]).addTo(deliveryMap).bindPopup('Dispatch point');

		deliveryMap.on('click', function(e) {
			setDeliveryPin(e.latlng.lat, e.latlng.lng, true);
		});
	}

	function setDeliveryPin(latitude, longitude, shouldCalculate) {
		$('#DeliveryLatitude').val(latitude.toFixed(7));
		$('#DeliveryLongitude').val(longitude.toFixed(7));

		if(customerMarker) {
			customerMarker.setLatLng([latitude, longitude]);
		} else {
			customerMarker = L.marker([latitude, longitude], { draggable: true }).addTo(deliveryMap).bindPopup('Delivery point');
			customerMarker.on('dragend', function(event) {
				var position = event.target.getLatLng();
				setDeliveryPin(position.lat, position.lng, true);
			});
		}

		if(routeLine) {
			routeLine.remove();
		}

		routeLine = L.polyline([[storeLatitude, storeLongitude], [latitude, longitude]], { color: '#007bff', weight: 4 }).addTo(deliveryMap);
		deliveryMap.fitBounds(routeLine.getBounds(), { padding: [30, 30] });

		if(shouldCalculate) {
			calculateDelivery();
		}
	}

	bootDeliveryMap();

	
	$('body').delegate('.createAccount', 'click', function(){
		if(this.checked)
		{
			$('#showPassword').show();
			$('#inputPassword').prop('required',true);
		}
		else
		{
			$('#showPassword').hide();
			$('#inputPassword').prop('required',false);
		}
	});

	$('body').delegate('.get_shipping_charge', 'click', function(){
		var price = $(this).attr('data-price');
		var total = $('#PayableTotal').val();
		$('#getshippingChargeTotal').val(price)
		var final_total = parseFloat(price) + parseFloat(total);
		$('#getPayableTotal').html(formatUgx(final_total))
		
		
	});

	$('body').delegate('#SubmitForm', 'submit', function(e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "{{ url('checkout/place_order') }}",
			data: new FormData(this),
			processData:false,
			contentType:false,
			dataType: "json",
			success: function(data) {
				if(data.status == false)
				{
					alert(data.message);	
				}
				else
				{
					window.location.href = data.redirect;
				}
			},
			error: function(data) {

			}
		})
	});

	$('body').delegate('#ApplyDiscount', 'click', function(){
			var discount_code = $('#getDiscountCode').val();

			$.ajax({
				type: "POST",
				url: "{{ url('checkout/apply_discount_code') }}?",
				data: {
					discount_code : discount_code,
					"_token": "{{ csrf_token() }}",
				},
			dataType: "json",
			success: function(data) {
				$('#getDiscountAmount').html(data.discount_amount_display || data.discount_amount)
				var shipping = $('#getshippingChargeTotal').val();
				var final_total = parseFloat(shipping) + parseFloat(data.payable_total);
				$('#getPayableTotal').html(formatUgx(final_total))
				$('#PayableTotal').val(data.payable_total);
					if(data.status == false)
					{
						alert(data.message);
					}
				},
				error: function(data) {
					// Handle error
					console.error('An error occurred', data);
				}
			});
		})

	function formatUgx(amount) {
		return 'UGX ' + Math.round(parseFloat(amount || 0)).toLocaleString();
	}

	function calculateDelivery() {
		var latitude = $('#DeliveryLatitude').val();
		var longitude = $('#DeliveryLongitude').val();

		if(!latitude || !longitude) {
			alert('Please provide destination latitude and longitude, or use your current location.');
			return;
		}

		$('#DeliveryEstimate').show().html('Calculating boda delivery...');

		$.ajax({
			type: "POST",
			url: "{{ url('checkout/calculate_delivery') }}",
			data: {
				latitude: latitude,
				longitude: longitude,
				"_token": "{{ csrf_token() }}",
			},
			dataType: "json",
			success: function(data) {
				$('#DeliveryFee').val(data.fee);
				$('#DeliveryDistanceKm').val(data.distance_km);
				$('#DeliveryDurationMinutes').val(data.duration_minutes);
				$('#getshippingChargeTotal').val(data.fee);
				$('#DeliveryFeeDisplay').html(data.fee_display);

				var payable = parseFloat($('#PayableTotal').val() || 0) + parseFloat(data.fee);
				$('#getPayableTotal').html(formatUgx(payable));
				$('#DeliveryEstimate').html(
					'<strong>' + data.fee_display + '</strong><br>' +
					data.distance_km + ' km • about ' + data.duration_minutes + ' minutes<br>' +
					data.message
				);
			},
			error: function() {
				$('#DeliveryEstimate').html('Could not calculate delivery. Please check the coordinates and try again.');
			}
		});
	}

	$('#CalculateDelivery').click(calculateDelivery);

	$('#UseCurrentLocation').click(function() {
		if(!navigator.geolocation) {
			alert('Your browser does not support current location.');
			return;
		}

		$('#DeliveryEstimate').show().html('Getting your current location...');
		navigator.geolocation.getCurrentPosition(function(position) {
			if(!$('#DeliveryAddress').val()) {
				$('#DeliveryAddress').val('Customer current location');
			}
			setDeliveryPin(position.coords.latitude, position.coords.longitude, true);
		}, function() {
			$('#DeliveryEstimate').html('Location permission was not granted. You can enter latitude and longitude manually.');
		});
	});
</script>

@endsection
