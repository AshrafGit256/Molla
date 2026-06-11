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
          <h3 class="card-title">Payment Icons</h3>
          <a href="{{ url('admin/payment-icon/add') }}" class="btn btn-primary btn-sm float-right">Add Icon</a>
        </div>
        <div class="card-body">
          <form action="{{ url('admin/payment-icon/sort') }}" method="POST" id="sortForm">
            @csrf
            <ul class="list-group sortable" id="sortable">
              @forelse($getRecord as $value)
              <li class="list-group-item" data-id="{{ $value->id }}">
                <i class="fas fa-arrows-alt mr-2"></i>
                <img src="{{ $value->getImage() }}" style="height: 40px; margin: 0 10px;" alt="icon">
                <span class="align-middle">Order: {{ $value->order_by }}</span>
                <a href="{{ url('admin/payment-icon/edit/'.$value->id) }}" class="btn btn-info btn-sm float-right">Edit</a>
                <a href="{{ url('admin/payment-icon/delete/'.$value->id) }}" class="btn btn-danger btn-sm float-right" style="margin-right: 5px;" onclick="return confirm('Are you sure?')">Delete</a>
              </li>
              @empty
              <li class="list-group-item text-center">No icons found.</li>
              @endforelse
            </ul>
          </form>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
<script>
(() => {
  const sortable = new Sortable(document.getElementById('sortable'), {
    handle: 'i',
    animation: 150,
    onEnd: () => {
      const order = {};
      document.querySelectorAll('#sortable li').forEach((el, index) => {
        order[el.dataset.id] = index + 1;
      });

      const form = document.getElementById('sortForm');
      const existing = form.querySelector('input[name=sort]');
      if (existing) existing.remove();

      Object.entries(order).forEach(([id, position]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `sort[${id}]`;
        input.value = position;
        form.appendChild(input);
      });

      const formData = new FormData(form);
      fetch(form.action, {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value,
        },
        body: formData,
      });
    }
  });
})();
</script>
@endsection
