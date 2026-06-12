@extends('rider.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-clipboard-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Assigned Orders</span>
                <span class="info-box-number">{{ $assignedOrders->count() }}</span>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-motorcycle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Active Orders</span>
                <span class="info-box-number">{{ $activeOrders->count() }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clipboard-list mr-2"></i>Latest Assigned Orders</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr class="bg-dark">
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignedOrders as $order)
                        <tr>
                            <td>#{{ $order->order_number }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ App\Support\Money::format($order->total_amount) }}</td>
                            <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                            <td>
                                <a href="{{ url('rider/orders/detail/'.$order->id) }}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No assigned orders.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-motorcycle mr-2"></i>Active Orders</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr class="bg-dark">
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeOrders as $order)
                        <tr>
                            <td>#{{ $order->order_number }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ App\Support\Money::format($order->total_amount) }}</td>
                            <td>
                                @if($order->status == 0)
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($order->status == 1)
                                    <span class="badge badge-info">In Progress</span>
                                @elseif($order->status == 2)
                                    <span class="badge badge-primary">Delivered</span>
                                @elseif($order->status == 3)
                                    <span class="badge badge-success">Completed</span>
                                @elseif($order->status == 4)
                                    <span class="badge badge-danger">Cancelled</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('rider/orders/detail/'.$order->id) }}" class="btn btn-sm btn-success"><i class="fas fa-eye"></i> View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No active orders.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection