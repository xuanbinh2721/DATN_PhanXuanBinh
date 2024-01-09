@extends('layouts.customer')

@section('content')

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
</div>
@endif
    <div class="container bg-white mt-2 pt-2 pb-5 mb-3">
        <h2 class="mt-2">Danh sách đặt sân</h2>
        <hr>
        @if ($bookingList->isEmpty())
            <p>Hiện tại bạn chưa có đơn đặt sân nào.</p>
        @else
            <ul class="list list-inline">
                @foreach ($bookingList as $booking)
                <li class="border border-secondary rounded-2 d-flex justify-content-between  mb-3">
                    <a class="text-decoration-none" href="{{ route('booking.detail',$booking->id) }}">
                        <div class="d-flex flex-row align-items-center ms-2 ">
                            @if($booking->status == '0')
                            <i class="fa fa-stopwatch fs-4 text-primary me-2"></i>
                            @elseif($booking->status == '1')
                            <i class="fa fa-check-circle fs-4 text-success me-2"></i>
                            @elseif($booking->status == '2')
                            <i class="fa-solid fa-circle-xmark fs-4 text-danger me-2"></i>
                            @endif
                            <div class="ml-2">
                                <h6 class="mb-3 mt-3 text-dark">{{ $booking->field->name }}</h6>
                                <div class="d-flex flex-row mt-1 text-black-50 date-time mb-3">
                                    <div><i class="fa fa-calendar"></i><span class="ml-2">{{ $booking->timeFrames->date }} </span></div>
                                    <div class="ml-3 "><i class="fa fa-clock"></i><span class="ml-2">{{ $booking->timeFrames->start_time }} - {{ $booking->timeFrames->end_time }}</span></div>
                                    <div class="ml-3"><i class="fa-solid fa-money-bill"></i><span class="ml-2">{{ number_format($booking->timeFrames->price) }}VNĐ</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <div class="d-flex flex-column mr-2">
                            <i class="fa fa-eye text-secondary "></i>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection