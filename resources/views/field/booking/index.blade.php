@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="#" class="text-decoration-none text-dark mt-3 mb-3 ms-2"><h2 class="fw-bold">Quản lý đơn đặt</h2></a>
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
</div>
@endif
<div class="container-fluid mt-4">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách khung giờ</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Người đặt</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Ngày đặt</th>
                            <th>Khung giờ</th>
                            <th>Giá</th>
                            <th>Xem thông tin</th>
                            <th>Tình trạng</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Người đặt</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Ngày đặt</th>
                            <th>Khung giờ</th>
                            <th>Giá</th>
                            <th>Xem thông tin</th>
                            <th>Tình trạng</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->email }}</td>
                                <td>{{ $booking->phone_number }}</td>
                                <td>{{ $booking->timeFrames->date }}</td>
                                <td>{{ $booking->timeFrames->start_time }} - {{ $booking->timeFrames->end_time }}</td>
                                <td>{{ $booking->timeFrames->price }}</td>
                                <td>
                                    <a type="button" class="btn" href="{{ route('booking.detail',$booking->id) }}">
                                        <i class="fa fa-eye text-secondary "></i>
                                    </a>
                                </td>

                                <td>
                                    @if($booking->status == '0')
                                    <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-success" href="{{ route('getbooking.accept',$booking->id) }}">
                                        Xác nhận
                                    </a>
                                    <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-danger" href="{{ route('getbooking.refuse',$booking->id) }}">
                                        Hủy
                                    </a>
                                    
                                    @elseif($booking->status =='1')
                                    <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-danger" href="{{ route('getbooking.refuse',$booking->id) }}">
                                        Hủy
                                    </a>
                                    @elseif($booking->status =='2')
                                    <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-success" href="{{ route('getbooking.accept',$booking->id) }}">
                                        Xác nhận
                                    </a>
                                    @endif                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>

</div>


@endsection


