<!DOCTYPE html>
<html lang="vi">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon-32x32.png') }}">

  <title>@yield('title')- Hệ thống điểm danh đánh giá điểm rèn luyện trực tuyến</title>
  

  <!-- Custom fonts for this template-->
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ asset('assets/css/sb-admin-2.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <style>
    a{
      text-decoration: none!important;
    }
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  <script src="{{ asset('assets/js/axios.min.js') }}"></script>
  @yield('script')
  
</head>

<body id="page-top">
    <div id="preloader">
      <div id="loader"></div>
    </div>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    @include('client.component.menu')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        @include('client.component.header')
        <!-- End of Topbar -->

        <!-- Notification -->

        @include('client.component.notification')

        <!-- End of Notification -->

        <!-- Begin Page Content -->
        <div id="data">@yield('content')</div>
        {{-- @include('admin.content') --}}
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      @include('client.component.footer')
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Bạn có muốn đăng xuất?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Chọn "Đăng xuất" để thoát khỏi phiên làm việc này</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
          <a class="btn btn-primary" href="{{ route('logout') }}">Đăng xuất</a>
        </div>
      </div>
    </div>
  </div>

  {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelNotification">Cookies</button> --}}

<!--Modal: modalCookie-->
  <div class="modal fade top" id="modelNotification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true" data-backdrop="true">
    <div class="modal-dialog modal-frame modal-top modal-notify modal-info" role="document">
      <!--Content-->
      <div class="modal-content">
        <!--Body-->
        <div class="modal-body">
          <div class="row d-flex justify-content-center align-items-center">

            <p class="pt-3 pr-2" id="notificationModal" style="color: red">Một ngoại lệ đã xảy ra. Yêu cầu bị chấm dứt. Vui lòng thử lại sau!</p>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
        </div>
      </div>
      <!--/.Content-->
    </div>
  </div>

  <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header border-bottom-0">
          <h5 class="modal-title" id="exampleModalLabel">Thông tin cá nhân</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('edit_profile') }}" id="form_profile" method="POST">
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="email1">Họ và tên</label>
              <input type="text" id="name_profile" class="form-control" aria-describedby="emailHelp" disabled>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" id="email_profile" class="form-control" disabled>
            </div>
            <div class="form-group">
              <label for="">Lớp - Chức vụ</label>
              <input type="text" id="class_profile" class="form-control"  disabled>
            </div>
            <div class="form-group">
              <label for="">Ngày sinh</label>
              <input type="date" id="birthday_profile" class="form-control" disabled>
            </div>
            <div class="form-group">
              <label for="">Số điện thoại</label>
              <input type="text" class="form-control" id="phone_number_profile" name="phone_number" autofocus title="Là số có 10 chữ số bắt đầu bằng số 0" pattern="(0)[0-9]{9}">
            </div>
            <div class="form-group">
              <label for="">Địa chỉ</label>
              <input type="text" class="form-control" id="address_profile" name="address">
            </div>
          </div>
          <div class="modal-footer border-top-0 d-flex justify-content-center">
            <button type="submit" class="btn btn-success">Cập nhật</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript">

    axios({
      method : "GET",
      url: '{{ route('get_profile') }}',
      data : {}
    })
    .then((response)=>{
      console.log(response)
      $('#name_profile').val(response.data.name)
      $('#email_profile').val(response.data.email)
      $('#class_profile').val(response.data.class)
      $('#birthday_profile').val(response.data.birthday)
      $('#phone_number_profile').val(response.data.phone_number)
      $('#address_profile').val(response.data.address)
    })
    .catch(()=>{

    })

  </script>
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('assets/vendor/chart.js/Chart.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('assets/js/demo/chart-area-demo.js') }}"></script>
  <script src="{{ asset('assets/js/demo/chart-pie-demo.js') }}"></script>

</body>

</html>
