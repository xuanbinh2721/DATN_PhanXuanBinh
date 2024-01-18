<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header ">{{ __('Thêm tài khoản') }}</div>
                <div class="card-body">
                    <form action="{{ route('admin.adduser') }}" method="POST" enctype="multipart/form-data" class="w-100">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            
                            <div class="col-md-4 mb-3">
                                <label class="small mb-1" for="inputName">Name</label>
                                <input class="form-control" name="name" id="inputName" type="text" placeholder="Nhập tên tài khoản" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="small mb-1" for="inputEmail">Email</label>                                    
                                <input class="form-control" name="email" id="inputEmail" type="email" placeholder="Nhập email"  required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small mb-1" for="inputPhoneNumber">Số điện thoại</label>
                                <input class="form-control" name="phone_number" id="inputPhoneNumber" type="tel" placeholder="Nhập số điện thoại"  required>
                            </div>                       
                            <div class="col-md-3 mb-3">
                                <label class="small mb-1" for="inputPassword">Mật khẩu</label>
                                <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Nhập mật khẩu"  required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="small mb-1" for="inputConfirmPassword">Xác nhận mật khẩu</label>
                                <input class="form-control" name="password_confirmation" id="inputConfirmPassword" type="password" placeholder="Xác nhận mật khẩu"  required>
                            </div>
                            
                            <div class="row third">
                                <div class="input-field mb-3">
                                    <button class="btn btn-outline-primary my-2 my-sm-0 me-3" type="submit">Thêm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>