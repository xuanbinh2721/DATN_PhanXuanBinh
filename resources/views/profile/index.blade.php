@extends('layouts.customer')

@section('content')

<div class="container-fluid bg-secondary mt-2">
    <div class="row">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-8 ms-auto w-50">
                    <div class="card mb-4 ">
                        <div class="card-header">
                            <section class="ms-2">Thông tin cá nhân( Vui lòng nhấn "Lưu" sau khi sửa thông tin và avatar. )</section>
                        </div>
                        <!-- Account details column -->
                        
                            @include('profile.partials.update-profile-form')
                    </div>
                </div>
                <div class="col-md-4 me-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection