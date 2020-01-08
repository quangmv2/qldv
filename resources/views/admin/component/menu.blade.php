<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('adminIndex') }}">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{ route('adminIndex') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Tổng Quan</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Interface
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item" >
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog"></i>
      <span>Lớp học</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('adminListClass') }}">Danh sách lớp</a>
        <a class="collapse-item" href="{{ route('adminAddClass') }}">Thêm lớp</a>
      </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse">
      <i class="fas fa-fw fa-cog"></i>
      <span>Sinh viên</span>
    </a>
    <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('adminListStudent') }}">Danh sách sinh viên</a>
        <a class="collapse-item" href="{{ route('adminAddStudent') }}">Thêm sinh viên</a>
        <a class="collapse-item" href="{{ route('add-excel') }}">Thêm sinh viên bằng file</a>
      </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse">
      <i class="fas fa-fw fa-cog"></i>
      <span>Giảng viên</span>
    </a>
    <div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="">Danh sách giảng viên</a>
        <a class="collapse-item" href="">Thêm giảng viên</a>
      </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse">
      <i class="fas fa-fw fa-cog"></i>
      <span>Hoạt động</span>
    </a>
    <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('listActionAD') }}">Danh sách hoạt động</a>
        <a class="collapse-item" href="{{ route('addActionAD') }}">Thêm hoạt động</a>
        <a class="collapse-item" href="{{ route('listCategoryAD') }}">Danh sách thể loại</a>
        <a class="collapse-item" href="{{ route('addCategoryAD') }}">Thêm thể loại</a>
      </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse">
      <i class="fas fa-fw fa-cog"></i>
      <span>Điểm rèn luyện</span>
    </a>
    <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('addPointAD') }}">Thêm đợt xét rèn luyện</a>
        <a class="collapse-item" href="{{ route('listDRLAD') }}">Danh sách lớp</a>
        <a class="collapse-item" href="{{ route('thongKeAD') }}">Thống kê</a>
      </div>
    </div>
  </li>
  <!-- Nav Item - Utilities Collapse Menu -->


  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>