<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
    <div class="sidebar-brand-icon ">
      <i class="fas fa-university"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SICT</div>
  </a>
  <style>

  </style>
  <div class="row">
    <div class="col-sm-3" style="padding: 0;
    padding-left: 5%;
    margin: auto;">
        <img class="img-profile rounded-circle" style="width: 100%;" src="http://daotao.sict.udn.vn/public/gv/images/img.jpg" alt="">
    </div>
    <div class="col-sm-8" style="padding: 0">
        <p class="m-auto">Xin chào,</p>
        <h5 style="color: white">@if (session('account'))
          {{ session('account')->name }}
      @endif</h5>
    </div>
  </div>
 



  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="">
      <i class="fas fa-fw fa-home"></i>
      <span>Trang chủ</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">


  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item" >
    <a class="nav-link collapsed" href="{{ route('newAction') }}">
      <i class="fas fa-fw fa-cog"></i>
      <span>Hoạt động mới</span>
    </a>
  </li>
  <li class="nav-item" >
    <a class="nav-link collapsed" href="{{ route('myAction') }}">
      <i class="fas fa-fw fa-cog"></i>
      <span>Hoạt động của tôi</span>
    </a>
  </li>
  <li class="nav-item" >
    <a class="nav-link collapsed" href="{{ route('myPoint') }}">
      <i class="fas fa-fw fa-cog"></i>
      <span>Điểm rèn luyện của tôi</span>
    </a>
  </li>
  <li class="nav-item" >
    <a class="nav-link collapsed" href="{{ route('attendanceList') }}">
      <i class="fas fa-fw fa-cog"></i>
      <span>Điểm danh</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse">
      <i class="fas fa-fw fa-cog"></i>
      <span>Quản lý hoạt động</span>
    </a>
    <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('actionList') }}">Danh sách hoạt động</a>
        <a class="collapse-item" href="{{ route('addAction') }}">Thêm hoạt động</a>
      </div>
    </div>
  </li>
  


  <!-- Nav Item - Utilities Collapse Menu -->
  {{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Utilities</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Custom Utilities:</h6>
        <a class="collapse-item" href="utilities-color.html">Colors</a>
        <a class="collapse-item" href="utilities-border.html">Borders</a>
        <a class="collapse-item" href="utilities-animation.html">Animations</a>
        <a class="collapse-item" href="utilities-other.html">Other</a>
      </div>
    </div>
  </li> --}}

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Addons
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-folder"></i>
      <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Login Screens:</h6>
        <a class="collapse-item" href="login.html">Login</a>
        <a class="collapse-item" href="register.html">Register</a>
        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
        <div class="collapse-divider"></div>
        <h6 class="collapse-header">Other Pages:</h6>
        <a class="collapse-item" href="404.html">404 Page</a>
        <a class="collapse-item" href="blank.html">Blank Page</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Charts -->
  <li class="nav-item">
    <a class="nav-link" href="">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Điểm rèn luyện</span></a>
  </li>

  <!-- Nav Item - Tables -->
  <li class="nav-item">
    <a class="nav-link" href="tables.html">
      <i class="fas fa-fw fa-table"></i>
      <span>Tables</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>