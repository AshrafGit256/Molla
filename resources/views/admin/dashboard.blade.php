@extends('admin.layouts.app')

@section('style')
<style>
  .work-card {
    min-height: 260px;
  }

  .work-list-item {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    padding: .75rem 0;
    border-bottom: 1px solid rgba(255,255,255,.08);
  }

  .work-list-item:last-child {
    border-bottom: 0;
  }

  .work-list-title {
    font-weight: 600;
    margin-bottom: .15rem;
  }

  .work-list-meta {
    color: #b9c0c7;
    font-size: 12px;
  }
</style>
@endsection

  @section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

      <div class="row">
    <div class="col-12 col-md-2">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Orders</span>
                <span class="info-box-number">{{ $TotalOrder}}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-calendar-day"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Today Orders</span>
                <span class="info-box-number">{{ $TotalTodayOrder }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Amount</span>
                <span class="info-box-number">{{ App\Support\Money::format($TotalAmount) }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Today Amount</span>
                <span class="info-box-number">{{ App\Support\Money::format($TotalTodayAmount) }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-2">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Customers</span>
                <span class="info-box-number">{{ $TotalCustomer }}</span>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-2">
    <div class="info-box mb-3">
        <span class="info-box-icon bg-dark elevation-1"><i class="fas fa-users-cog"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Today Customers</span>
            <span class="info-box-number">{{ $TotalTodayCustomer }}</span>
        </div>
    </div>
</div>





          
        </div>

        <div class="row">
          <div class="col-lg-3 col-md-6">
            <div class="card work-card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-bolt mr-2"></i>Needs Action</h3>
              </div>
              <div class="card-body">
                <div class="work-list-item">
                  <div>
                    <div class="work-list-title">Pending orders</div>
                    <div class="work-list-meta">Orders waiting for progress</div>
                  </div>
                  <span class="badge badge-warning align-self-start">{{ $pendingOrders->count() }}</span>
                </div>
                <div class="work-list-item">
                  <div>
                    <div class="work-list-title">Low stock</div>
                    <div class="work-list-meta">Products at 10 units or less</div>
                  </div>
                  <span class="badge badge-danger align-self-start">{{ $lowStockProducts->count() }}</span>
                </div>
                <div class="work-list-item">
                  <div>
                    <div class="work-list-title">Missing images</div>
                    <div class="work-list-meta">Products that need photos</div>
                  </div>
                  <span class="badge badge-info align-self-start">{{ $missingImageProducts->count() }}</span>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="card work-card">
              <div class="card-header border-0 d-flex justify-content-between align-items-center">
                <h3 class="card-title"><i class="fas fa-clipboard-list mr-2"></i>Pending Orders</h3>
                <a href="{{ url('admin/order/list') }}" class="btn btn-sm btn-outline-light">View all</a>
              </div>
              <div class="card-body">
                @forelse($pendingOrders as $order)
                  <div class="work-list-item">
                    <div>
                      <div class="work-list-title">#{{ $order->order_number }}</div>
                      <div class="work-list-meta">{{ $order->first_name }} {{ $order->last_name }} • {{ App\Support\Money::format($order->total_amount) }}</div>
                    </div>
                    <a href="{{ url('admin/order/detail/'.$order->id) }}" class="btn btn-sm btn-success align-self-start">Open</a>
                  </div>
                @empty
                  <p class="text-muted mb-0">No pending orders right now.</p>
                @endforelse
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="card work-card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-box-open mr-2"></i>Inventory Watch</h3>
              </div>
              <div class="card-body">
                @forelse($lowStockProducts as $product)
                  <div class="work-list-item">
                    <div>
                      <div class="work-list-title">{{ $product->title }}</div>
                      <div class="work-list-meta">{{ $product->in_stock }} units left</div>
                    </div>
                    <a href="{{ url('admin/product/edit/'.$product->id) }}" class="btn btn-sm btn-outline-warning align-self-start">Edit</a>
                  </div>
                @empty
                  <p class="text-muted mb-0">Inventory looks healthy.</p>
                @endforelse
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="card work-card">
              <div class="card-header border-0">
                <h3 class="card-title"><i class="fas fa-user-plus mr-2"></i>New Customers</h3>
              </div>
              <div class="card-body">
                @forelse($recentCustomers as $customer)
                  <div class="work-list-item">
                    <div>
                      <div class="work-list-title">{{ $customer->name }}</div>
                      <div class="work-list-meta">{{ $customer->email }}</div>
                    </div>
                    <span class="badge badge-secondary align-self-start">{{ date('M d', strtotime($customer->created_at)) }}</span>
                  </div>
                @empty
                  <p class="text-muted mb-0">No customers yet.</p>
                @endforelse
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
          <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Sales</h3>
                  <select class="form-control ChangeYear" style="width: 100px;">
                    @for($i=2022; $i<=date('Y'); $i++)
                     <option {{ ($year == $i) ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                    @endfor
                  </select>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex">
                  <p class="d-flex flex-column">
                    <span class="text-bold text-lg">{{ App\Support\Money::format($TotalAmount) }}</span>
                    <span>Sales Over Time</span>
                  </p>
                  
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                  <canvas id="sales-chart-order" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> Customer
                  </span>

                  <span class="mr-2">
                    <i class="fas fa-square text-gray"></i> Order
                  </span>

                  <span>
                    <i class="fas fa-square text-danger"></i> Amount
                  </span>
                </div>
              </div>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><b>Latest Orders</b></h3>
              </div>
              <div class="card-body table-responsive p-0">
              <table class="table table-striped table-valign-middle">
                  <thead>
                    <tr class="bg-dark">
                      <th>#</th>
                      <th>Order Number</th>
                      <th>Name</th>
                      
                      <th>Status</th>
                      <th>Discount Code</th>
                      <th>Discount Amount</th>
                      <th>Shipping Amount</th>
                      <th>Total amount</th>
                      <th>Payment Method</th>
                      <th>Created At</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($getLatestOrders as $value)
                  <tr>
                    <td>{{$value->id}}</td>
                    <td>{{$value->order_number}}</td>
                    <td>{{$value->first_name}}  {{$value->last_name}}</td>
                    
                    <td>

                    @if($value->status == 0)
                    <span class="badge badge-warning">Pending</span>
                    @elseif($value->status == 1)
                    <span class="badge badge-info">In Progress</span>
                    @elseif($value->status == 2)
                    <span class="badge badge-primary">Delivered</span>
                    @elseif($value->status == 3)
                    <span class="badge badge-success">Completed</span>
                    @elseif($value->status == 4)
                    <span class="badge badge-danger">Cancelled</span>
                    @endif            
                                    
                    </td>
                            
                    
                    <td>{{$value->discount_code}}</td>
                    <td>{{ App\Support\Money::format($value->discount_amount) }}</td>
                    <td>{{ App\Support\Money::format($value->shipping_amount) }}</td>
                    <td>{{ App\Support\Money::format($value->total_amount) }}</td>
                    <td style="text-transform: capitalize;">{{$value->payment_method}}</td>
                    
                    <td>{{ date('d-m-y h:i A', strtotime($value->created_at)) }}</td>
                    <td>
                      <a href="{{ url('admin/order/detail/'.$value->id) }}" class="btn btn-success"><i class="fas fa-eye"></i>Details</a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
          
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  @endsection

@section('script')
<script src="{{ url('dist/js/pages/dashboard3.js')}}"></script>

<script type="text/javascript">

  $('.ChangeYear').change(function(){
    var year = $(T=this).val();
    window.location.href = "{{ url('admin/dashboard?year=') }}"+year;
  });

    var ticksStyle = {
    fontColor: '#FFFFFF',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart-order')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: [{{ $getTotalCustomerMonth }}]
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [{{ $getTotalOrderMonth }}]
        },
        {
          backgroundColor: 'red',
          borderColor: 'red',
          data: [{{ $getTotalOrderAmountMonth }}]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
</script>
@endsection
