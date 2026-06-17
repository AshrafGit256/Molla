<aside class="col-md-4 col-lg-3">
    @php
        $getUnreadNotificationCount = App\Models\NotificationModel::getUnreadNotificationCount(Auth::user()->id);
        $currentPath = Request::path();
    @endphp

    <div class="customer-sidebar">
        <div class="customer-sidebar__title">
            <h4>{{ Auth::user()->name }} {{ Auth::user()->last_name }}</h4>
            <p>Manage your account and orders</p>
        </div>

        <ul class="nav nav-dashboard flex-column mb-md-0" role="tablist">
            <li class="nav-item">
                <a href="{{ url('/dashboard') }}" class="nav-link {{ $currentPath === 'dashboard' ? 'active' : '' }}">
                    <i class="fa fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/orders') }}" class="nav-link {{ str_starts_with($currentPath, 'orders') || str_starts_with($currentPath, 'user/orders') ? 'active' : '' }}">
                    <i class="fa fa-shopping-bag"></i>
                    <span>Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/edit-profile') }}" class="nav-link {{ $currentPath === 'edit-profile' ? 'active' : '' }}">
                    <i class="fa fa-user-edit"></i>
                    <span>Edit Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/notifications') }}" class="nav-link {{ $currentPath === 'notifications' ? 'active' : '' }}">
                    <i class="fas fa-bell"></i>
                    <span>Notifications ({{ $getUnreadNotificationCount }})</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/change-password') }}" class="nav-link {{ $currentPath === 'change-password' ? 'active' : '' }}">
                    <i class="fa fa-key"></i>
                    <span>Change Password</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('logout') }}">
                    <i class="fa fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
