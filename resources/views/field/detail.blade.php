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
                    <a href="{{ asset('storage/' . $fields->fieldImages->first()->image_name) }}" data-toggle="lightbox">
                    <img src="{{ asset('storage/' . $fields->fieldImages->first()->image_name) }}" alt="Image" class="img-fluid w-100"  style="height: 444px">
                    </a>
                </div>
                <div class="col-md-6 mb-3">
                {{-- Hiển thị các ảnh còn lại --}}
                    <div class="container-fluid">
                        <div class="row">
                        @foreach ($fields->fieldImages->slice(1, 4) as $subImage)
                            @if ($subImage)
                                <div class="col-md-6 mb-2">
                                    <a href="{{ asset('storage/' . $subImage->image_name) }}" data-toggle="lightbox">
                                        <img src="{{ asset('storage/' . $subImage->image_name) }}" alt="Image" class="img-fluid w-100"  style="height: 217.75px">
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    

    @if(session('success'))
    <div class="container-fluid mt-3">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
    @elseif(session('error'))
    <div class="container-fluid mt-3">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
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
            <div class="tab-pane fade show active " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="align-item-center text-center">
                    <h1 class="fs-2 fw-bold"><strong>{{ $fields->name }}</strong></h1>
                <p class="fs-5">
                    {{ $fields->description }}
                </p>
                <p class="fs-5">Địa chỉ: {{ $fields->address }}, {{ optional($fields->ward)->prefix }} {{ optional($fields->ward)->name }}, {{ optional($fields->district)->prefix }} {{ optional($fields->district)->name }}, {{ optional($fields->province)->name }} </p>
                <p class="fs-5">Số điện thoại: {{ $fields->phone_number }}</p>
                <p class="fs-5">Loại sân thể thao: {{ $fields->sportType->name }}</p>
                <p class="fs-5 fw-bold">
                    @php
                        // Lấy giá của tất cả các TimeFrames của sân
                        $prices = $fields->timeFrames->pluck('price')->toArray();
    
                        // Lọc ra các giá trị không null
                        $validPrices = array_filter($prices, function ($price) {
                            return $price !== null;
                        });
    
                        // Lấy giá thấp nhất và giá cao nhất nếu mảng không rỗng
                        $minPrice = !empty($validPrices) ? min($validPrices) : null;
                        $maxPrice = !empty($validPrices) ? max($validPrices) : null;
                    @endphp
    
                    @if ($minPrice !== null && $maxPrice !== null)
                        @if ($minPrice < $maxPrice)
                            <p class="card-text fw-bold fs-4">Giá: {{ number_format($minPrice) }} - {{ number_format($maxPrice) }} VNĐ</p>
                        @elseif ($minPrice == $maxPrice)
                            <p class="card-text fw-bold fs-4">Giá: {{ number_format($minPrice) }} VNĐ</p>
                        @endif
                    @else
                        <p class="card-text fw-bold fs-4">Chưa có giá</p>
                    @endif
                </p>
                </div>
                <hr>
                <p class="fs-4">Khung giờ trống hiện có</p>
                    <ul class="nav  nav-tabs" id="myTab" role="tablist">
                        @foreach ($availableDates as $date)
                            @if(\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($date)))
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if ($loop->first) active @endif" id="{{ Str::slug($date) }}-tab" data-bs-toggle="tab" data-bs-target="#{{ Str::slug($date) }}" type="button" role="tab" aria-controls="{{ Str::slug($date) }}" aria-selected="@if ($loop->first) true @else false @endif">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                
                    <div class="tab-content" id="myTabContent">
                        @foreach ($availableDates as $date)
                            @if(\Carbon\Carbon::now()->lessThanOrEqualTo(\Carbon\Carbon::parse($date)))
                                <div class="tab-pane fade @if ($loop->first) show active @endif" id="{{ Str::slug($date) }}" role="tabpanel" aria-labelledby="{{ Str::slug($date) }}-tab">
                                    <h3 class="mt-2">Lịch sân trống ngày {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</h3>
                                    <ul class="list-group">
                                        @foreach ($fields->timeFrames->where('date', $date)->where('status', 0)->sortBy('start_time') as $timeFrame)
                                            <li class="list-group-item mb-2 rounded">
                                                {{ $timeFrame->start_time }} - {{ $timeFrame->end_time }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>
            
            
                <div class="col-md-12 mt-4 mb-3 align-item-center text-center">
                    @auth
                        @include('layouts.booking')
                    @endauth
                    @guest
                    <a class="btn btn-info text-light btn-add-to-cart-detail"  style="background-color:  rgb(58, 160, 180);" href="{{ route('login') }}">
                        Đặt sân
                    </a>
                    @endguest

                </div>
            </div>
            
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <h4>Chưa có đánh giá</h4>
                <div class="col-md-12 mt-4 mb-3 align-item-center text-center">
                    <a class="btn btn-info text-light btn-add-to-cart-detail"  style="background-color:  rgb(58, 160, 180);" href="#">
                        Đánh giá
                    </a>
                </div>
            </div>
        </div>
    </div>
    <hr>
    
</div>




@endsection
