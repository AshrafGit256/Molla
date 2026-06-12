@php
$headerUser = Auth::user();
$headerUserImage = !empty($headerUser) ? $headerUser->getImage() : '';
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <div class="sidebar">
    <a href="{{ url('rider/dashboard') }}" class="brand-link" style="display: flex; align-items: center; padding: 10px 20px; color: white;">
      <span class="brand-text font-weight-light" style="font-size: 1.2rem; font-weight: 600;">Rider Portal</span>
    </a>

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if(!empty($headerUserImage))
        <img src="{{ $headerUserImage }}" class="img-circle elevation-2" alt="User Image" style="height: 60px; width: 60px; border-radius: 50%">
        @else
        <img src="{{ asset('upload/user/default_profile.jpg') }}" class="img-circle elevation-2" alt="Default User Image" style="height: 60px; width: 60px; border-radius: 50%">
        @endif
      </div>
      <div class="info">
        <a class="d-block user-name">{{ $headerUser->name ?? 'Rider' }}</a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ url('rider/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ url('rider/orders') }}" class="nav-link @if(Request::segment(2) == 'orders') active @endif">
            <i class="nav-icon fas fa-shopping-bag"></i>
            <p>Orders</p>
          </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
        <li class="nav-item">
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
            <i class="nav-icon fas fa-arrow-left"></i>
            <p>Logout</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>