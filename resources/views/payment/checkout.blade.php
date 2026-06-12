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
  margin-top: .75rem;
  display: none;
}

.delivery-map {
  height: 520px;
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
        </div>
    </div>
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div>
    </nav>
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
                                <span>Pin your delivery location on the map so our rider knows exactly where to go.</span>
                            </div>

                            <div class="delivery-panel">
                                <h3 class="checkout-title mb-2">Delivery location</h3>
                                <label>Delivery note for the rider *</label>
                                <input type="text" name="delivery_address" id="DeliveryAddress" class="form-control" placeholder="Example: Kireka, near Shell, call when at the gate" required>
                                <div id="DeliveryMap" class="delivery-map"></div>
                                <input type="hidden" name="delivery_latitude" id="DeliveryLatitude" required>
                                <input type="hidden" name="delivery_longitude" id="DeliveryLongitude" required>
                                <input type="hidden" name="delivery_fee" id="DeliveryFee" value="0">
                                <input type="hidden" name="delivery_distance_km" id="DeliveryDistanceKm" value="">
                                <input type="hidden" name="delivery_duration_minutes" id="DeliveryDurationMinutes" value="">
                                <div class="d-flex flex-wrap" style="gap: .75rem;">
                                    <button type="button" id="UseCurrentLocation" class="btn btn-outline-dark-2">Use my current location</button>
                                    <button type="button" id="CalculateDelivery" class="btn btn-outline-primary-2">Estimate delivery</button>
                                </div>
                                <div id="DeliveryEstimate" class="delivery-estimate mt-2"></div>
                            </div>

                            <label>Email address *</label>
                            <input type="email" value="{{ !empty(Auth::user()->email) ? Auth::user()->email: '' }}" name="email" class="form-control" required>

                            <label>Order notes (optional)</label>
                            <textarea class="form-control" name="note" cols="30" rows="4" placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                        </div>
                        <aside class="col-lg-3">
                            <div class="summary">
                                <h3 class="summary-title">Your Order</h3>
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
                                                            <a href="{{ url($getCartProduct->slug) }}">{{ $getCartProduct->title }}</a>
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
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="cart-discount">
                                                    <div class="input-group">
                                                        <input type="text" name="discount_code" id="getDiscountCode" class="form-control" placeholder="Discount Code">
                                                        <div class="input-group-append">
                                                            <button type="button" id="ApplyDiscount" style="height: 38px;" class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Discount:</td>
                                            <td><span id="getDiscountAmount">UGX 0</span></td>
                                        </tr>
                                        <tr class="summary-shipping">
                                            <td>Boda delivery:</td>
                                            <td><span id="DeliveryFeeDisplay">Calculate</span></td>
                                        </tr>
                                        <tr class="summary-total">
                                            <td>Total:</td>
                                            <td><span id="getPayableTotal">{{ App\Support\Money::format(Cart::getSubTotal()) }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                </div>
                                <p class="text-center mb-1"><small>Secure checkout. You can review before payment is completed.</small></p>
                                <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                    <span class="btn-text">Place Order</span>
                                    <span class="btn-hover-text">Proceed to Checkout</span>
                                </button>
                                <br /><br />
                                <img src="{{ url('assets/images/payments-summary.png') }}">
                            </div>
                        </aside>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
var storeLatitude = {{ $storeLatitude }};
var storeLongitude = {{ $storeLongitude }};
var deliveryMap;
var storeMarker;
var customerMarker;
var routeLine;

function bootDeliveryMap() {
  if(typeof L === 'undefined') {
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

$('body').delegate('#CalculateDelivery', 'click', calculateDelivery);

$('#UseCurrentLocation').click(function() {
  if(!navigator.geolocation) {
    alert('Your browser does not support current location.');
    return;
  }

  navigator.geolocation.getCurrentPosition(function(position) {
    if(!$('#DeliveryAddress').val()) {
      $('#DeliveryAddress').val('Customer current location');
    }
    setDeliveryPin(position.coords.latitude, position.coords.longitude, true);
  }, function() {
    alert('Location permission was not granted. You can enter latitude and longitude manually.');
  });
});

function formatUgx(amount) {
  return 'UGX ' + Math.round(parseFloat(amount || 0)).toLocaleString();
}

function calculateDelivery() {
  var latitude = $('#DeliveryLatitude').val();
  var longitude = $('#DeliveryLongitude').val();

  if(!latitude || !longitude) {
    alert('Please select a delivery point on the map or use your current location.');
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
        data.distance_km + ' km • about ' + data.duration_minutes + ' minutes using cycling route<br>' +
        data.message
      );
    },
    error: function() {
      $('#DeliveryEstimate').html('Could not calculate delivery. Please try again.');
    }
  });
}

$('body').delegate('#SubmitForm', 'submit', function(e) {
  e.preventDefault();
  $.ajax({
    type: "POST",
    url: "{{ url('checkout/place_order') }}",
    data: new FormData(this),
    processData: false,
    contentType: false,
    dataType: "json",
    success: function(data) {
      if(data.status == false) {
        alert(data.message);
      } else {
        window.location.href = data.redirect;
      }
    },
    error: function() {}
  });
});

$('body').delegate('#ApplyDiscount', 'click', function() {
  var discount_code = $('#getDiscountCode').val();
  $.ajax({
    type: "POST",
    url: "{{ url('checkout/apply_discount_code') }}?",
    data: {
      discount_code: discount_code,
      "_token": "{{ csrf_token() }}",
    },
    dataType: "json",
    success: function(data) {
      $('#getDiscountAmount').html(data.discount_amount_display || data.discount_amount);
      var shipping = $('#getshippingChargeTotal').val();
      var final_total = parseFloat(shipping) + parseFloat(data.payable_total);
      $('#getPayableTotal').html(formatUgx(final_total));
      $('#PayableTotal').val(data.payable_total);
      if(data.status == false) {
        alert(data.message);
      }
    }
  });
});
</script>
@endsection
