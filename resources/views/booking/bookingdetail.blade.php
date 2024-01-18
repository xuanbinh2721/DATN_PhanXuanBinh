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
@endif
<div class="container-fluid">
    <div class="row justify-content-center ">
        <div class="col-md-8 mt-3 mb-3">
            <div class="card">
                <div class="card-header fs-3">{{ __('Chi tiết đặt sân:' ) }}</div>
                <div class="card-body">
                    <div class="row">
                        <p class="mb-3 fs-5">Tên người đặt: {{ $bookingDetail->name }}</p>
                        <p class="mb-3 fs-5">Email: {{ $bookingDetail->email }}</p>
                        <p class="mb-3 fs-5">Số điện thoại: {{ $bookingDetail->phone_number }}</p>
                        <p class="mb-3 fs-5">Sân: {{ $field->name }}</p>

                        <p class="mb-3 fs-5">Khung giờ đặt sân: {{ $timeFrame->start_time }} - {{ $timeFrame->end_time }} - {{ \Carbon\Carbon::parse($timeFrame->date)->format('d/m/Y') }}</p>
                        <p class="mb-3 fs-5">Giá: {{ $timeFrame->price }}</p>
                        <p class="mb-3 fs-5">Phương thức thanh toán: {{ getPaymentMethodLabel($bookingDetail->payment_method) }}</p>
                        <p class="mb-3 fs-5 fw-bold">Tình trạng: {!! getStatusLabel($bookingDetail->status) !!}</p>
                    </div>
                    <div class="row third">
                        <div class="input-field mb-3">
                            @if($bookingDetail->status =='0')
                            <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto btn-danger fs-5" href="{{ route('booking.cancel',$bookingDetail->id) }}">
                                Hủy đặt
                            </a>
                            @endif
                            <a type="button" class="btn ms-auto btn-primary fs-5" href="{{ url()->previous() }}">
                                Quay lại
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@php
function getPaymentMethodLabel($paymentMethod) {
    switch ($paymentMethod) {
        case 0:
            return 'Thanh toán tại sân';
        case 1:
            return 'Thẻ tín dụng';
        case 2:
            return 'Thẻ nội địa';
        default:
            return 'Không xác định';
    }
}

function getStatusLabel($status) {
    switch ($status) {
        case 0:
            return '<span style="color: #3498db;">Chờ xác nhận</span>';
        case 1:
            return '<span style="color: #2ecc71;">Đã xác nhận</span>';
        case 2:
            return '<span style="color: #e74c3c;">Đã hủy</span>';
        default:
            return '<span style="color: #95a5a6;">Không xác định</span>';
    }
}
@endphp
