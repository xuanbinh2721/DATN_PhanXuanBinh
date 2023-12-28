@extends('layouts.customer')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center bg-gradient">
    <div class="col-md-8 mt-3 mb-3">
      <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>
        <div class="card-body">
          <form action="" method="GET" enctype="multipart/form-data" class="w-100">
            @csrf
            <div class="inner-form">
              <div class="basic-search">
                <div class="container">
                  <div class="row align-item-center">
                    <div class="col-md-10">
                      <div class="input-field">
                        <div class="icon-wrap">
                          <i class="fas fa-search"></i>
                        </div>
                        <input id="search" class="form-control mr-sm-2" type="search" aria-label="Search"
                          placeholder="Search...">

                        <div class="result-count" id="advsearch" style="cursor: pointer">
                          <i class="fa-solid fa-caret-down"></i>
                          <span>Advanced Search</span>
                        </div>

                      </div>
                    </div>
                    <div class="col-md-2 d-inline-flex align-items-center justify-content-center">

                      <button class="btn btn-outline-primary my-2 my-sm-0 w-100" type="submit">Search</button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="advance-search" id="advancedSearch" style="display: none;">
                <span class="desc">Advanced Search</span>
                <div class="row">
                  <div class="input-field mb-3">
                    <div class="input-select">
                      <select data-trigger="" name="choices-single-defaul" class="form-select" id="province">
                        <option value="">Chọn tỉnh/thành phố</option>
                        @foreach($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="input-field mb-3">
                    <div class="input-select">
                      <select data-trigger="" name="choices-single-defaul" class="form-select" id="district">
                        <option value="">Chọn quận/huyện</option>
                      </select>
                    </div>
                  </div>
                  <div class="input-field mb-3">
                    <div class="input-select">
                      <select data-trigger="" name="choices-single-defaul" class="form-select" id="ward">
                        <option value="">Chọn quận/huyện</option>
                      </select>
                    </div>
                  </div>
                  <div class="row third">
                    <div class="input-field mb-3">
                      <button class="btn btn-search btn-outline-primary mt-3 me-2">Search</button>
                      <button class="btn btn-delete mt-3 btn-outline-danger" id="delete">Delete</button>
                    </div>
                  </div>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid bg-white">
  <div class="row">
    <h3 class="mt-4 ">
      Bạn muốn đặt sân?
    </h3>
    @include('layouts.getfields')
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    $('#province').change(function () {
      var provinceId = $(this).val();

      if (provinceId) {
        $.ajax({
          url: '{{ url(' / district / ') }}/' + provinceId,
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
      // Cập nhật phường/xã khi chọn quận/huyện
      updateWardDropdown();
    });

    function updateWardDropdown() {
      var districtId = $('#district').val();

      if (districtId) {
        $.ajax({
          url: '{{ url(' / ward / ') }}/' + districtId,
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
<!-- Bootstrap JS (make sure it's placed after Bootstrap CSS) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Your custom scripts go here -->
<script>
  $(document).ready(function () {
    $('#advsearch').click(function () {
      $('#advancedSearch').toggle(); // Hiển thị hoặc ẩn trường tìm kiếm nâng cao
    });

    // Khởi tạo các dropdown sử dụng thư viện Choices.js



    // Xử lý sự kiện khi nhấn nút "Delete"
    $('#delete').click(function () {
      e.preventDefault();

      // Xóa nội dung các trường tìm kiếm nâng cao
      $('.input-select select').val('').trigger('change');
    });
  });
</script>
@endsection