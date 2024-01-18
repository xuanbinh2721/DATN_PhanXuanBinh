@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="#" class="text-decoration-none text-dark mt-3 mb-3 ms-2"><h2 class="fw-bold">Quản lý tài khoản người dùng</h2></a>
    </div>
</div>

@include('admin.partials.addsporttype')

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
@if($errors->any())
    <div class="container-fluid mt-3">
        <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
        </div>
    </div>
@endif
<div class="container-fluid mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách tài khoản</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Tên</th>
                            <th>Description</th>
                            <th>Trạng thái</th>
                            <th>Sửa</th>
                            <th>Khóa</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th>Sửa</th>
                            <th>Khóa</th>

                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($sporttypes as $sporttype)
                            <tr>
                                <td>{{ $sporttype->id }}</td>
                                <td>{{ $sporttype->name }}</td>
                                <td>{{ $sporttype->description }}</td>
                                <td>
                                    @if($sporttype->status == '0')                             
                                        <span class="text-primary fw-bold">Bình thường</span>
                                    @elseif($sporttype->status =='1')
                                    <span class="text-danger fw-bold">Bị Khóa</span>
                                    @endif                                    
                                </td>
                                <td>
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-update-sport-type{{ $sporttype->id }}">
                                        <i class="fa fa-pen-to-square text-primary" style="font-size:20px"></i>
                                    </button>
                                    <div class="modal fade" id="modal-update-sport-type{{ $sporttype->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Sửa loại sân</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('sporttype.updatetype',$sporttype->id) }}" method="POST">
                                                    @csrf
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputName">Name</label>
                                                        <input type="text" name="name" class="form-control mb-3" id="inputName" value="{{ $sporttype->name }}" placeholder="Nhập tên" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="small mb-1" for="inputDescription">Mô tả</label>                                    
                                                        <textarea class="form-control" name="description" id="inputDescription" type="text" placeholder="Nhập mô tả" >{{ $sporttype->description }}</textarea>
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
                                @if($sporttype->status == '0')     
                                    <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-danger fs-5" href="{{ route('sporttype.changelocktype',$sporttype->id) }} ">
                                        <i class="fa-solid fa-lock"></i>
                                    </a>
                                @elseif($sporttype->status =='1')
                                <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-danger fs-5" href="{{ route('sporttype.changelocktype',$sporttype->id) }}">
                                    <i class="fa-solid fa-lock-open"></i>
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


