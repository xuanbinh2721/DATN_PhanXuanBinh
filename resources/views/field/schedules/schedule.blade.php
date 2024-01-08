@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="#" class="text-decoration-none text-dark mt-3 mb-3 ms-2"><h2 class="fw-bold">Quản lý lịch sân</h2></a>
    </div>
</div>
@include('field.schedules.partials.addschedule')

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
                            <th>Thời gian bắt đầu</th>
                            <th>Thời gian kết thúc</th>
                            <th>Ngày</th>
                            <th>Giá</th>
                            <th>Sửa</th>
                            <th>Tình trạng</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Thời gian bắt đầu</th>
                            <th>Thời gian kết thúc</th>
                            <th>Ngày</th>
                            <th>Giá</th>
                            <th>Sửa</th>
                            <th>Tình trạng</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($timeFrames as $timeFrame)
                            <tr>
                                <td>{{ $timeFrame->start_time }}</td>
                                <td>{{ $timeFrame->end_time }}</td>
                                <td>{{ $timeFrame->date }}</td>
                                <td>{{ $timeFrame->price }}</td>
                                <td>
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-update-time-frame{{ $timeFrame->id }}">
                                        <i class="bi bi-pencil-square text-primary" style="font-size:20px"></i>
                                    </button>

                                    <div class="modal fade" id="modal-update-time-frame{{ $timeFrame->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Sửa khung giờ</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('schedule.upTime', $timeFrame->id) }}" method="POST">
                                                    @csrf
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputStart">Start</label>
                                                        <input type="time" name="start_time1" class="form-control mb-3" value="{{ $timeFrame->start_time }}" placeholder="Thời gian bắt đầu">
                                                    </div>
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputEnd">End</label>
                                                        <input type="time" name="end_time1" class="form-control mb-3" value="{{ $timeFrame->end_time }}" placeholder="Thời gian kết thúc">
                                                    </div>
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputDate">Ngày</label>
                                                        <input type="date" name="date1" class="form-control mb-3" value="{{ $timeFrame->date }}" placeholder="Ngày">

                                                    </div>
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputPrice">Giá</label>
                                                        <input type="number" name="price1" class="form-control mb-3" value="{{ $timeFrame->price }}" placeholder="Giá tiền">

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                        <button type="submit" class="btn btn-primary">Lưu</button>
                                                </div>
                                                </form>
                                            </div>
                                            
                                    </div>
                                    </div>
                                </td>
                                
                                <td>
                                    @if($timeFrame->status == '1')
                                    <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-warning" href="{{ route('schedule.changelock',$timeFrame->id) }}">
                                        <i class="bi bi-lock text-danger" style="font-size:20px"></i>
                                    </a>
                                    @elseif($timeFrame->status =='0')
                                    <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-warning" href="{{ route('schedule.changelock',$timeFrame->id) }}">
                                        <i class="bi bi-unlock text-danger" style="font-size:20px"></i>
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


