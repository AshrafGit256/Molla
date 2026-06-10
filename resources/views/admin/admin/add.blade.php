@extends('admin.layouts.app')

@section('style')
<style>
  .admin-create-shell {
    max-width: 980px;
  }

  .admin-create-intro {
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 8px;
    padding: 1.25rem;
    background: rgba(255,255,255,.04);
    margin-bottom: 1rem;
  }

  .admin-avatar-preview {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,.2);
    background: #343a40;
  }

  .admin-form-grid {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 1.5rem;
    align-items: start;
  }

  @media (max-width: 767px) {
    .admin-form-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
@endsection

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add New Admin</h1>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12 admin-create-shell">
            @include('admin.layouts._message')
            <div class="admin-create-intro">
              <h4 class="mb-1">Create a trusted admin profile</h4>
              <p class="mb-0 text-muted">Admins should be easy to recognise in order activity, product updates, and customer support work.</p>
            </div>
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Admin Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="card-body">
                  <div class="admin-form-grid">
                    <div class="text-center">
                      <img id="AdminImagePreview" class="admin-avatar-preview mb-3" src="{{ asset('upload/user/default_profile.jpg') }}" alt="Admin preview">
                      <input type="file" id="AdminImageInput" name="image_name" required class="form-control" accept="image/*">
                      <small class="text-muted d-block mt-2">Use a clear face photo.</small>
                    </div>

                    <div>
                      <div class="form-group">
                        <label>Name <span style="color: red;">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter full name" required>
                      </div>
                      <div class="form-group">
                        <label>Email Address <span style="color: red;">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter email" required>
                        <div style="color: red;">{{ $errors->first('email') }}</div>
                      </div>
                      <div class="form-group">
                        <label>Password <span style="color: red;">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Create a secure password" required>
                      </div>
                      <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option {{ (old('status', 0) == 0) ? 'selected'  : '' }} value="0">Active</option>
                            <option {{ (old('status') == 1) ? 'selected' : '' }} value="1">Inactive</option>
                        </select>
                        <small class="text-muted">Inactive admins cannot work in the dashboard once status checks are enforced.</small>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Create Admin</button>
                  <a href="{{ url('admin/admin/list') }}" class="btn btn-outline-light ml-2">Cancel</a>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-6">
          </div>
        </div>
      </div>
    </section>
  
   

    <!-- /.content -->
  </div>
@endsection

@section('script')
<script>
  $('#AdminImageInput').on('change', function() {
    var file = this.files[0];

    if (!file) {
      return;
    }

    var reader = new FileReader();
    reader.onload = function(e) {
      $('#AdminImagePreview').attr('src', e.target.result);
    };
    reader.readAsDataURL(file);
  });
</script>
@endsection
