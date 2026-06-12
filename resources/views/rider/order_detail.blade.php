@extends('rider.layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Order Detail</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Order Information</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label><i class="fas fa-id-badge"></i> Order Number: <span>{{ $getRecord->order_number }}</span></label>
                  </div>
                  <div class="form-group">
                    <label><i class="fas fa-user"></i> Customer: <span>{{ $getRecord->first_name }} {{ $getRecord->last_name }}</span></label>
                  </div>
                  <div class="form-group">
                    <label><i class="fas fa-phone"></i> Phone: <span>{{ $getRecord->phone }}</span></label>
                  </div>
                  <div class="form-group">
                    <label><i class="fas fa-envelope"></i> Email: <span>{{ $getRecord->email }}</span></label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><i class="fas fa-map-marker-alt"></i> Address: <span>{{ $getRecord->address_one }}{{ !empty($getRecord->address_two) ? ', '.$getRecord->address_two : '' }}</span></label>
                  </div>
                  <div class="form-group">
                    <label><i class="fas fa-city"></i> City: <span>{{ $getRecord->city }}</span></label>
                  </div>
                  <div class="form-group">
                    <label><i class="fas fa-map-pin"></i> Delivery: <span>{{ $getRecord->delivery_address ?: 'Not provided' }}</span></label>
                  </div>
                  <div class="form-group">
                    <label><i class="fas fa-dollar-sign"></i> Total: <span>{{ App\Support\Money::format($getRecord->total_amount) }}</span></label>
                  </div>
                </div>
              </div>
                  <div class="form-group">
                    <label>
                      <i class="fas fa-info-circle"></i> Status:
                      @if($getRecord->status == 0)
                        <span class="badge badge-warning">Pending</span>
                      @elseif($getRecord->status == 1)
                        <span class="badge badge-info">In Progress</span>
                      @elseif($getRecord->status == 2)
                        <span class="badge badge-primary">Delivered</span>
                      @elseif($getRecord->status == 3)
                        <span class="badge badge-success">Completed</span>
                      @elseif($getRecord->status == 4)
                        <span class="badge badge-danger">Cancelled</span>
                      @endif
                    </label>
                  </div>

                  @if($getRecord->status == 0)
                  <div class="form-group">
                    <button class="btn btn-info btn-sm rider-start-delivery" data-order-id="{{ $getRecord->id }}">
                      <i class="fas fa-play"></i> Start Delivery
                    </button>
                  </div>
                  @endif

                  @if($getRecord->status == 1)
                  <div class="form-group">
                    <button class="btn btn-success btn-sm rider-update-status" data-order-id="{{ $getRecord->id }}" data-status="2">
                      <i class="fas fa-check"></i> Mark as Delivered
                    </button>
                    <button class="btn btn-danger btn-sm rider-update-status ml-2" data-order-id="{{ $getRecord->id }}" data-status="4">
                      <i class="fas fa-undo"></i> Mark as Returned
                    </button>
                  </div>
                  @endif

                  @if(!empty($getRecord->delivery_started_at) && !empty($getRecord->delivery_duration_minutes))
                  <div class="form-group">
                    <label><i class="fas fa-clock"></i> Delivery started: <span>{{ date('d-m-Y H:i', strtotime($getRecord->delivery_started_at)) }}</span></label>
                    <div class="alert alert-info mt-2">
                      <strong>Estimated delivery time:</strong> {{ $getRecord->delivery_duration_minutes }} minutes<br>
                      <strong>Estimated arrival:</strong> <span id="RiderEtaCountdown" class="eta-countdown" data-start="{{ strtotime($getRecord->delivery_started_at) }}" data-minutes="{{ $getRecord->delivery_duration_minutes }}">{{ date('H:i', strtotime('+' . $getRecord->delivery_duration_minutes . ' minutes', strtotime($getRecord->delivery_started_at))) }}</span>
                      <div class="mt-2">
                        <div style="height: 10px; border-radius: 5px;" id="RiderEtaProgress"></div>
                      </div>
                    </div>
                  </div>
                  @elseif(!empty($getRecord->delivery_started_at))
                  <div class="form-group">
                    <label><i class="fas fa-clock"></i> Delivery started: <span>{{ date('d-m-Y H:i', strtotime($getRecord->delivery_started_at)) }}</span></label>
                  </div>
                  @endif
              
                  @if(!empty($getRecord->delivery_latitude) && !empty($getRecord->delivery_longitude))
                  <div class="card mt-4">
                    <div class="card-header">
                      <h3 class="card-title"><i class="fas fa-map mr-2"></i>Delivery Route</h3>
                    </div>
                    <div class="card-body">
                      <div id="RiderDeliveryMap" style="height: 420px; border-radius: 8px; border: 1px solid #eee;"></div>
                    </div>
                  </div>
                  @endif
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('script')
@if(!empty($getRecord->delivery_latitude) && !empty($getRecord->delivery_longitude))
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function() {
  var el = document.getElementById('RiderEtaCountdown');
  var progress = document.getElementById('RiderEtaProgress');
  if (!el || !el.dataset.start || !el.dataset.minutes) {
    return;
  }

  var start = parseInt(el.dataset.start, 10) * 1000;
  var duration = parseInt(el.dataset.minutes, 10) * 60 * 1000;
  var end = start + duration;

  function render() {
    var now = Date.now();
    var diff = end - now;

    if (diff <= 0) {
      el.textContent = '00:00';
      if (progress) { progress.style.width = '100%'; progress.style.background = '#dc3545'; }
      return;
    }

    var totalMinutes = Math.floor(diff / 60000);
    var hours = Math.floor(totalMinutes / 60);
    var minutes = totalMinutes % 60;
    var seconds = Math.floor((diff % 60000) / 1000);
    var text = String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
    el.textContent = text;

    if (progress) {
      var pct = Math.max(0, Math.min(100, ((end - now) / duration) * 100));
      progress.style.width = pct + '%';
      if (pct > 50) {
        progress.style.background = '#28a745';
      } else if (pct > 20) {
        progress.style.background = '#ffc107';
      } else {
        progress.style.background = '#dc3545';
      }
    }
  }

  render();
  setInterval(render, 1000);
})();
</script>
<script>
$('body').delegate('.rider-start-delivery', 'click', function() {
  var orderId = $(this).data('order-id');
  if (!confirm('Notify customer that you have started moving?')) {
    return;
  }
  $.post('{{ url('rider/order/notify-customer') }}', {order_id: orderId, _token: '{{ csrf_token() }}'}, function(res) {
    if (res.status) {
      alert('Customer notified. Delivery timer started.');
      location.reload();
    } else {
      alert(res.message || 'Action failed');
    }
  }, 'json');
});

$('body').delegate('.rider-update-status', 'click', function() {
  var orderId = $(this).data('order-id');
  var status = $(this).data('status');
  if (!confirm('Update order status?')) {
    return;
  }
  $.post('{{ url('rider/order/status') }}', {order_id: orderId, status: status, _token: '{{ csrf_token() }}'}, function(res) {
    if (res.status) {
      alert(res.message);
      location.reload();
    } else {
      alert(res.message || 'Action failed');
    }
  }, 'json');
});
</script>
@endsection