@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="{{ route('field.index') }}" class="text-decoration-none text-dark mt-3 mb-3"><h2 class="fw-bold">Quản lý sân</h2></a>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Sân bóng của tôi') }}</div>

                <div class="card-body">
                    @foreach ($fields as $field)
                        <h2 class="mb-4 fw-bold">{{ $field->name }}</h2>
                        <hr>
                        <div class="container-fluid mt-3">
                            <div class="row mt-3">
                                @if ($field->fieldImages && $field->fieldImages->count() > 0)
                                    {{-- Hiển thị ảnh đầu tiên --}}
                                    <div class="col-md-6 mb-3">
                                        <img src="{{ asset('storage/' . $field->fieldImages->first()->image_name) }}" alt="Image" class="img-fluid w-100" style="height: 444px">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                    {{-- Hiển thị các ảnh còn lại --}}
                                        <div class="container-fluid">
                                            <div class="row">
                                            @foreach ($field->fieldImages->slice(1, 4) as $subImage)
                                                @if ($subImage)
                                                    <div class="col-md-6 mb-2">
                                                        <img src="{{ asset('storage/' . $subImage->image_name) }}" alt="Image" class="img-fluid w-100" style="height: 217.75px">
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="card-body">
                    <p class="fs-5">
                        Mô tả: {{ $field->description }}
                    </p>
                    <p class="fs-5">Địa chỉ: {{ $field->address }}, {{ optional($field->ward)->prefix }} {{ optional($field->ward)->name }}, {{ optional($field->district)->prefix }} {{ optional($field->district)->name }}, {{ optional($field->province)->name }} </p>
                    <p class="fs-5">Số điện thoại: {{ $field->phone_number }}</p>
                    <p class="fs-5">Loại sân thể thao: {{ $field->sportType->name }}</p>
                </div>
                <div class="card-body">
                    <a href="" class="btn btn-outline-primary me-4">Sửa thông tin</a>
                    <a href="" class="btn btn-outline-danger">Hủy đăng kí</a>
                </div>
                <hr>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
@endsection


