@extends('layouts.app')

@section('style')
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

	            						<label>Company Name (Optional)</label>
	            						<input type="text" value="{{ !empty(Auth::user()->company_name) ? Auth::user()->company_name: '' }}" name="company_name" class="form-control">

	            						<label>Country *</label>
	            						<input type="text" value="{{ !empty(Auth::user()->country) ? Auth::user()->country: '' }}" name="country" class="form-control" required>

	            						<label>Street address *</label>
	            						<input type="text" value="{{ !empty(Auth::user()->address_one) ? Auth::user()->address_one: '' }}" name="address_one" class="form-control" placeholder="House number and Street name" required>
	            						<input type="text" value="{{ !empty(Auth::user()->address_two) ? Auth::user()->address_two: '' }}" name="address_two" class="form-control" placeholder="Appartments, suite, unit etc ..." required>

	            						<div class="row">
		                					<div class="col-sm-6">
		                						<label>Town / City *</label>
		                						<input type="text" value="{{ !empty(Auth::user()->city) ? Auth::user()->city: '' }}" name="city" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>State *</label>
		                						<input type="text" value="{{ !empty(Auth::user()->state) ? Auth::user()->state: '' }}" name="state" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

		                				<div class="row">
		                					<div class="col-sm-6">
		                						<label>Postcode / ZIP *</label>
		                						<input type="text" value="{{ !empty(Auth::user()->postcode) ? Auth::user()->postcode: '' }}" name="postcode" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->

		                					<div class="col-sm-6">
		                						<label>Phone *</label>
		                						<input type="tel" value="{{ !empty(Auth::user()->phone) ? Auth::user()->phone: '' }}" name="phone" class="form-control" required>
		                					</div><!-- End .col-sm-6 -->
		                				</div><!-- End .row -->

	                					<label>Email address *</label>
	        							<input type="email" value="{{ !empty(Auth::user()->email) ? Auth::user()->email: '' }}" name="email" class="form-control" required>

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
		                							<td>${{ number_format($cart->price), 2 }}</td>
		                						</tr>
											@endforeach
		                						<tr class="summary-subtotal">
		                							<td>Subtotal:</td>
		                							<td>${{ number_format(Cart::getSubTotal(), 2) }}</td>
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
		                							<td>$<span id="getDiscountAmount">0.00</span></td>
		                						</tr><!-- End .summary-subtotal -->

												<tr class="summary-shipping">
													<td>Shipping:</td>
													<td>&nbsp;</td>
												</tr>
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

												
		                						<tr class="summary-total">
		                							<td>Total:</td>
		                							<td>$<span id="getPayableTotal">{{ number_format(Cart::getSubTotal(), 2) }}</span></td>
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
											<input type="radio" value="paypal" id="Paypal" required name="payment_method" class="custom-control-input">
											<label class="custom-control-label" for="Paypal">Paypal</label>
										</div>

										<div class="custom-control custom-radio" style="margin-top: 0px;">
											<input type="radio" value="stripe" id="CreditCard" required name="payment_method" class="custom-control-input">
											<label class="custom-control-label" for="CreditCard">Credit Card</label>
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
<script type="text/javascript">
	
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
		$('#getPayableTotal').html(final_total.toFixed(2))
		
		
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
					$('#getDiscountAmount').html(data.discount_amount)
					var shipping = $('#getshippingChargeTotal').val();
					var final_total = parseFloat(shipping) + parseFloat(data.payable_total);
					$('#getPayableTotal').html(final_total.toFixed(2))
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
</script>

@endsection
