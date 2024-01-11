@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="#" class="text-decoration-none text-dark mt-3 mb-3 ms-2"><h2 class="fw-bold">Quản lý tài khoản người dùng</h2></a>
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
                            <th>Hành động</th>
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
                            <th>Hành động</th>
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
                                        Bình thường                 
                                    @elseif($user->status =='inactive')
                                        Hạn chế
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


