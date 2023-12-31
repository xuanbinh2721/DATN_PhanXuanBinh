@extends('layouts.guest')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Mội email đã được gửi vào email của bạn! Vui lòng kiểm tra lại!.') }}
                        </div>
                    @endif

                    {{ __('Để tiếp tục sử dụng trang web này bạn cần xác nhận email của bạn.') }}
                    {{ __('Nếu bạn không nhận được email nào') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Vui lòng click vào đây để nhận email khác') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
