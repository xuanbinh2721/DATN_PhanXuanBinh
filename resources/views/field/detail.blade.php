@extends('layouts.customer')

@section('content')
@include('layouts.search')

<div class="container-fluid bg-white p-4 m-4">
    <h2 class="mb-4 fw-bold">{{ $fields->name }}</h2>
    <hr>
    <div class="container-fluid mt-3">
        <div class="row mt-3">
            @if ($fields->fieldImages && $fields->fieldImages->count() > 0)
                {{-- Hiển thị ảnh đầu tiên --}}
                <div class="col-md-6 mb-3">
                    <img src="{{ asset('storage/' . $fields->fieldImages->first()->image_name) }}" alt="Image" class="img-fluid w-100" style="height: 444px">
                </div>
                <div class="col-md-6 mb-3">
                {{-- Hiển thị các ảnh còn lại --}}
                    <div class="container-fluid">
                        <div class="row">
                        @foreach ($fields->fieldImages->slice(1, 4) as $subImage)
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
    
    


    <div class="col-md-12 product-description">
        <nav>
            <div class="nav nav-tabs  " id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">MÔ TẢ</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    ĐÁNH GIÁ(0)
                </button>
            </div>
        </nav>
        <div class="tab-content mt-3 " id="nav-tabContent">
            <div class="tab-pane fade show active align-item-center text-center" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <strong class="fs-4">{{ $fields->name }}</strong>
                <p class="fs-5">
                    {{ $fields->description }}
                </p>
                <p>Địa chỉ: {{ $fields->address }}, {{ optional($fields->ward)->prefix }} {{ optional($fields->ward)->name }}, {{ optional($fields->district)->prefix }} {{ optional($fields->district)->name }}, {{ optional($fields->province)->name }} </p>
                <p>Số điện thoại: {{ $fields->phone_number }}</p>
                <p>Loại sân thể thao: {{ $fields->sportType->name }}</p>
                <div class="col-md-12 mt-4 mb-3">
                    <a class="btn btn-info text-light btn-add-to-cart-detail"  style="background-color:  rgb(58, 160, 180);" href="#">
                        Đặt sân
                    </a>
                </div>
            </div>
            
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <h4>Chưa có đánh giá</h4>
            </div>
        </div>
    </div>
    <hr>
    
    {{-- <a href="{{ route('field.booking', ['id' => $field->id]) }}" class="btn btn-primary mt-3">Đặt sân</a> --}}
</div>
@include('layouts.footer')

@endsection
