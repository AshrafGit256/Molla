@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ url('assets/css/plugins/nouislider/nouislider.css') }}">
@endsection

@section('content')
@php
    $statusLabels = [
        0 => ['label' => 'Pending', 'class' => 'status-pill--pending'],
        1 => ['label' => 'In Progress', 'class' => 'status-pill--progress'],
        2 => ['label' => 'Delivered', 'class' => 'status-pill--delivered'],
        3 => ['label' => 'Completed', 'class' => 'status-pill--completed'],
        4 => ['label' => 'Cancelled', 'class' => 'status-pill--cancelled'],
    ];

    $visibleOrders = collect($getRecord->items());
    $activeOrders = $visibleOrders->whereIn('status', [0, 1, 2])->count();
    $pageSpend = $visibleOrders->sum('total_amount');
@endphp

<main class="main">
    <div class="page-header text-center" style="background-image: url('{{ url('assets/images/page-header-bg.jpg') }}')">
        <div class="container-fluid">
            <h1 class="page-title">My Orders<span>Account</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </div>
    </nav>

    <div class="page-content customer-shell">
        <div class="dashboard">
            <div class="container-fluid">
                <div class="row">
                    @include('user._sidebar')

                    <div class="col-md-8 col-lg-9">
                        <div class="customer-card">
                            <div class="customer-card__header">
                                <div>
                                    <h2>Order History</h2>
                                    <p>Track purchases, delivery progress, and receipts from one place.</p>
                                </div>
                                <a href="{{ url('search') }}" class="btn btn-outline-primary-2">
                                    <span>Shop More</span>
                                    <i class="icon-long-arrow-right"></i>
                                </a>
                            </div>

                            <div class="customer-metrics">
                                <div class="customer-metric">
                                    <span>Total orders</span>
                                    <strong>{{ $getRecord->total() }}</strong>
                                </div>
                                <div class="customer-metric">
                                    <span>Active now</span>
                                    <strong>{{ $activeOrders }}</strong>
                                </div>
                                <div class="customer-metric">
                                    <span>This page total</span>
                                    <strong>{{ App\Support\Money::format($pageSpend) }}</strong>
                                </div>
                            </div>

                            @if($visibleOrders->count())
                                <div class="table-responsive">
                                    <table class="table table-polished">
                                        <thead>
                                            <tr>
                                                <th>Order</th>
                                                <th>Total</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($getRecord as $value)
                                                @php
                                                    $status = $statusLabels[$value->status] ?? ['label' => 'Unknown', 'class' => 'status-pill--pending'];
                                                @endphp
                                                <tr>
                                                    <td data-label="Order">
                                                        <span class="order-number">{{ $value->order_number }}</span>
                                                        <span class="order-meta">Receipt #{{ str_pad($value->id, 5, '0', STR_PAD_LEFT) }}</span>
                                                    </td>
                                                    <td data-label="Total">
                                                        <strong>{{ App\Support\Money::format($value->total_amount) }}</strong>
                                                    </td>
                                                    <td data-label="Payment" class="text-capitalize">
                                                        {{ str_replace('_', ' ', $value->payment_method) }}
                                                    </td>
                                                    <td data-label="Status">
                                                        <span class="status-pill {{ $status['class'] }}">{{ $status['label'] }}</span>
                                                    </td>
                                                    <td data-label="Date">
                                                        <span>{{ date('M d, Y', strtotime($value->created_at)) }}</span>
                                                        <span class="order-meta">{{ date('h:i A', strtotime($value->created_at)) }}</span>
                                                    </td>
                                                    <td data-label="Action" class="text-right">
                                                        <a href="{{ url('user/orders/detail/'.$value->id) }}" class="btn btn-outline-primary-2">
                                                            <i class="fas fa-eye"></i>
                                                            <span>Details</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end p-3">
                                    {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                                </div>
                            @else
                                <div class="cart-empty-panel m-3">
                                    <h2>No orders yet</h2>
                                    <p>Your purchases will appear here once you place an order.</p>
                                    <a href="{{ url('search') }}" class="btn btn-outline-primary-2">
                                        <span>Explore products</span>
                                        <i class="icon-long-arrow-right"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
