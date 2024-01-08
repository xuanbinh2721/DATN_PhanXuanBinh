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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ekko-lightbox@5.3.0/dist/ekko-lightbox.min.css">

  
    <!-- Custom styles for this template-->
    <link href="{{ asset('css/admin.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/profile.css')}}" rel="stylesheet">
    <link href="{{ asset('css/search.css')}}" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body id="page-top">
    <div class="row">
        <nav class="navbar navbar-expand-md navbar-light hadow-sm" style="background: linear-gradient(0deg, #9FC7F7 0%, #9FC7F7 100%), #94B9FF;">
            <div class="container">
                <a class="nav-brand d-flex align-items-center justify-content-center text-decoration-none text-dark me-3 fs-3" href="{{ url('/') }}">
                    <div class="sidebar-brand-icon rotate-n-15 ">
                        <i class="fa fa-futbol"></i>
                    </div>
                    <div class="sidebar-brand-text">{{ config('app.name', 'Laravel') }} </div>
                </a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if(Auth::check())
                        @if(auth()->user()->user_type == 1)
                            <a class="navbar-nav nav-link me-auto" href="{{ route('field.index') }}">
                                Quản lý sân
                            </a>
                        @elseif(auth()->user()->user_type == 0)
                            <a class="navbar-nav nav-link me-auto" href="{{ route('registerfield') }}">
                                Đăng ký cho thuê sân
                            </a>
                        @elseif(auth()->user()->user_type == 2)
                            <a class="navbar-nav nav-link me-auto" href="{{ route('field.index') }}">
                                Trang Admin
                            </a>
                        @endif
                    @endif

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        @if(Auth::check())
                            <a class="navbar-nav nav-link mt-1" href="{{ route('registerfield') }}">
                                Quản lý đơn đặt
                            </a>
                        @endif
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-dark-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" style="height: 32px;  width: 32px;" src="{{ asset('storage/' . auth()->user()->avatar) }}">
                            </a>


                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div id="wrapper ">
        <main class="container-fluid">
            @yield('content')
        </main>
        
        @include('layouts.footer')
    </div>
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
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap JS (make sure it's placed after Bootstrap CSS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>

    <script src="{{ asset('js/search.js') }}"></script>
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
</body>

</html>