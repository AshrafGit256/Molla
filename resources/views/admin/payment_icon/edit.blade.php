@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>{{ $header_title }}</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      @include('admin.layouts._message')

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Edit Payment Icon</h3>
        </div>
        <form action="{{ url('admin/payment-icon/update/'.$getRecord->id) }}" method="post" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="card-body">

            <div class="form-group">
              <label>Current Image</label><br>
              @if(!empty($getRecord->image_name))
              <img src="{{ $getRecord->getImage() }}" style="height: 60px;">
              @endif
            </div>

            <div class="form-group">
              <label>Change Image</label>
              <input type="file" class="form-control" name="image">
            </div>

            <div class="form-group">
              <label>Order</label>
              <input type="number" class="form-control" name="order_by" value="{{ !empty($getRecord->order_by) ? $getRecord->order_by : 1 }}">
            </div>

          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>

    </div>
  </section>
</div>
@endsection
