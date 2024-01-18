@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="#" class="text-decoration-none text-dark mt-3 mb-3 ms-2"><h2 class="fw-bold">Quản lý tài khoản người dùng</h2></a>
    </div>
</div>

@include('admin.partials.adduser')

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
                            <th>Username</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>User Type</th>
                            <th>Trạng thái</th>
                            <th>Sửa</th>
                            <th>Khóa</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>User Type</th>
                            <th>Trạng thái</th>
                            <th>Sửa</th>
                            <th>Khóa</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>
                                    @if($user->user_type == '0')                             
                                        Khách thuê                  
                                    @elseif($user->user_type =='1')
                                        Khách cho thuê    
                                    @elseif($user->user_type =='2')
                                        Admin 
                                    @endif                                    
                                </td>
                                <td>
                                    @if($user->status == 'active')                             
                                        <span class="text-primary fw-bold">Bình thường</span>
                                    @elseif($user->status =='inactive')
                                    <span class="text-danger fw-bold">Hạn chế</span>
                                    @endif                                    
                                </td>
                                <td>
                                    <button type="button" class="btn" data-toggle="modal" data-target="#modal-update-time-frame{{ $user->id }}">
                                        <i class="fa fa-pen-to-square text-primary" style="font-size:20px"></i>
                                    </button>
                                    <div class="modal fade" id="modal-update-time-frame{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Sửa tài khoản</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin.updateuser',$user->id) }}" method="POST">
                                                    @csrf
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputName">Name</label>
                                                        <input type="text" name="name" class="form-control mb-3" id="inputName" value="{{ $user->name }}" placeholder="Nhập username" required>
                                                    </div>
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputEmail">Email</label>
                                                        <input type="email" name="email" class="form-control mb-3" id="inputEmail" value="{{ $user->email }}" placeholder="Nhập email" required>
                                                    </div>
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputPhoneNumber">Số điện thoại</label>
                                                        <input type="tel" name="phone_number" class="form-control mb-3" id="inputPhoneNumber" value="{{ $user->phone_number }}" placeholder="Nhập số điện thoại" >
                                                    </div>
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputAddress">Địa chỉ</label>
                                                        <input type="text" name="address" class="form-control mb-3" id="inputAddress" value="{{ $user->address }}" placeholder="Nhập địa chỉ" >
                                                    </div>
                                                    <div class=" mb-3">
                                                        <label class="small mb-1" for="inputDateOfBirth">Ngày sinh</label>
                                                        <input type="date" name="date_of_birth" class="form-control mb-3" id="inputDateOfBirth" value="{{ $user->date_of_birth }}" placeholder="Nhập ngày sinh" >
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
                                @if($user->status == 'active')     
                                    <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-danger fs-5" href=" {{ route('admin.changelockuser',$user->id) }}">
                                        <i class="fa-solid fa-lock"></i>
                                    </a>
                                @elseif($user->status =='inactive')
                                <a onclick="return confirm('Bạn có chắc chắn muốn đổi trạng thái này không ?')" type="button" class="btn ms-auto text-danger fs-5" href="{{ route('admin.changelockuser',$user->id) }}">
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


