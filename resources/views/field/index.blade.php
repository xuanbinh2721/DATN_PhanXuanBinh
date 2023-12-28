@extends('layouts.provider')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <div class="card-body">
                    <select id="province">
                        <option value="">Chọn tỉnh/thành phố</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                
                    <select id="district">
                        <option value="">Chọn quận/huyện</option>
                    </select>
                
                    <select id="ward">
                        <option value="">Chọn phường/xã</option>
                    </select>
                
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                                // Cập nhật phường/xã khi chọn quận/huyện
                                updateWardDropdown();
                            });

                            function updateWardDropdown() {
                                var districtId = $('#district').val();

                                if (districtId) {
                                    $.ajax({
                                        url: '{{ url('/ward/') }}/' + districtId,
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
            </div>
        </div>
    </div>
</div>
@endsection
