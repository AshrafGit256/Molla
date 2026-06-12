@extends('rider.layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Rider Orders</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Orders List</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <table class="table table-striped table-valign-middle">
            <thead>
              <tr class="bg-dark">
                <th>#</th>
                <th>Order Number</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Created</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($getRecord as $value)
              <tr>
                <td>{{ $value->id }}</td>
                <td>{{ $value->order_number }}</td>
                <td>{{ $value->first_name }} {{ $value->last_name }}</td>
                <td>{{ App\Support\Money::format($value->total_amount) }}</td>
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
                <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                <td>
                  <a href="{{ url('rider/orders/detail/'.$value->id) }}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> View</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="card-footer">
          {{ $getRecord->links() }}
        </div>
      </div>
    </div>
  </section>
</div>
@endsection