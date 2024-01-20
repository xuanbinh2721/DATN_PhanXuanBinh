<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/admin.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/profile.css')}}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('vendor\chart.js\Chart.min.js') }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body id="page-top">
    <div id="wrapper" >
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" >

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa fa-futbol"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }} </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link " href="{{ route('field.index') }}">
                    <i class="fas fa-fw fa-tachometer-alt "></i>
                    <span>Quản lý thông tin</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Quản lý cho thuê</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('field.schedule',$field->id) }}">Quản lý lịch</a>
                        <a class="collapse-item" href="{{ route('getbooking.index',$field->id) }}">Quản lý đơn thuê</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Báo cáo - thống kê</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('getrevenue.index',$field->id) }}">Thống kê doanh thu</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-3 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <!-- Authentication Links -->

                        <li class="nav-item dropdown no-arrow me-3">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset('storage/' . auth()->user()->avatar) }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown">
                            
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}" onclick="event.preventDefault(); document.getElementById('profile-form').submit();">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        {{ __('Profile') }}
                                    </a>
                                    <form id="profile-form" action="{{ route('profile.show') }}" method="GET" class="d-none">
                                        @csrf
                                    </form>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#"data-toggle="modal" data-target="#logoutModal" >
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        {{ __('Đăng xuất') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>

                        </li>


                    </ul>

                </nav>

                <main class="container-fluid">
                    @yield('content')
                </main>
                
@include('layouts.footer')
            </div>
        </div>
        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bạn muốn đăng xuất?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Chọn "Đăng xuất" bên dưới để kết thúc phiên đăng nhập!</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                        <a class="btn btn-primary" href="{{ route('logout') }} " onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bootstrap core JavaScript -->
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Core plugin JavaScript-->
        <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="{{ asset('js/admin.min.js') }}"></script>
            <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
        <script>
            $(document).ready(function () {
              $('#province').change(function () {
                  var provinceId = $(this).val();
          
                  if (provinceId) {
                      $.ajax({
                          url: '{{ url('/district/') }}/' + provinceId,
                          type: 'GET',
                          dataType: 'json',
                          success: function (data) {
                              $('#district').empty();
                              $('#ward').empty();
          
                              $('#district').append('<option value="">Chọn quận/huyện</option>');
                              $.each(data, function (key, value) {
                                $('#district').append('<option value="' + value.id + '">' + value.prefix + " " + value.name + '</option>');
                              });
                          // Cập nhật phường/xã khi chọn tỉnh/thành phố
                                updateWardDropdown();
    
                          }
                      });
                  } else {
                      $('#district').empty();
                      $('#ward').empty();
                      $('#district').append('<option value="">Chọn quận/huyện</option>');
                      $('#ward').append('<option value="">Chọn phường/xã</option>');
                  }
              });
            
              $('#district').change(function () {
                updateWardDropdown();
              });
              function updateWardDropdown(){
                  var districtId = $('#district').val();
          
                  if (districtId) {
                      $.ajax({
                          url: '{{ url('/ward/') }}/'  + districtId,
                          type: 'GET',
                          dataType: 'json',
                          success: function (data) {
                              $('#ward').empty();
                              $('#ward').append('<option value="">Chọn phường/xã</option>');
                              $.each(data, function (key, value) {
                                $('#ward').append('<option value="' + value.id + '">' + value.prefix + " " + value.name + '</option>');
                              });
                          }
                      });
                  } else {
                      $('#ward').empty();
                      $('#ward').append('<option value="">Chọn phường/xã</option>');
                  }
              }
          });
        </script>
        <script>
            document.querySelectorAll('.my-lightbox-toggle').forEach((el) => el.addEventListener('click', (e) => {
                e.preventDefault();
                const lightbox = new Lightbox(el, options);
                lightbox.show();
            }));
        </script>
        <script>
            $(document).ready(function() {
                $('#dataTable').DataTable();
            });
        </script>
</body>

</html>