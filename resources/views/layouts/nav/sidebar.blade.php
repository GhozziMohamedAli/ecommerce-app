<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-white" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="{{url('assets/images/logo-ct.png')}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-dark">Material Dashboard 2</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark {{$activePage == 'dashboard' ? 'active bg-gradient-info' : '' }} " href="/admin/dashboard">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        @can('view-dashboard')
          <li class="nav-item">
            <a class="nav-link text-dark {{$activePage == 'products' ? 'active bg-gradient-info' : '' }} " href="{{url('/admin/products')}}">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">table_view</i>
              </div>
              <span class="nav-link-text ms-1">{{__('Products')}}</span>
            </a>
          </li> 
          <li class="nav-item">
            <a class="nav-link text-dark {{$activePage == 'category' ? 'active bg-gradient-info' : '' }} " href="{{url('/admin/category')}}">
              <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">receipt_long</i>
              </div>
              <span class="nav-link-text ms-1">{{__('Category')}}</span>
            </a>
          </li>
        @endcan
        @cannot('view-dashboard')
        <li class="nav-item">
          <a class="nav-link text-dark {{$activePage == 'orders' ? 'active bg-gradient-info' : '' }} " href="{{url('/user/order')}}">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt_long</i>
            </div>
            <span class="nav-link-text ms-1">{{__('Orders')}}</span>
          </a>
        </li>
        @endcan
        
        
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-8">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark " href="./pages/profile.html">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
        <li class="nav-item">
          
          <a class="nav-link text-dark " href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <div class="text-dark text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">logout</i>
            </div>
            <span class="nav-link-text ms-1">
              {{__('Logout')}}
            </span>
          </a> 
        </li>
       
      </ul>
    </div>
    
  </aside>