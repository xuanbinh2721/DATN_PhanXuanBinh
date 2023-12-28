
    <form action="{{ route('password.update') }}" method="POST" enctype="multipart/form-data" class="w-100">
        @csrf
        @method('PUT')

        <!-- Profile picture column -->

            <div class="card mb-4">
                <div class="card-header">Đổi Mật Khẩu</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mật Khẩu Hiện Tại</label>
                        <input id="current_password" name="current_password" type="password" class="form-control" placeholder="Nhập mật khẩu hiện tại" autocomplete="current-password" />
                        <div class="text-danger">
                            {{ $errors->updatePassword->first('current_password') }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật Khẩu Mới</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Nhập mật khẩu mới" autocomplete="new-password" />
                        <div class="text-danger">
                            {{ $errors->updatePassword->first('password') }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="Nhập lại mật khẩu mới" autocomplete="new-password" />
                        <div class="text-danger">
                            {{ $errors->updatePassword->first('password_confirmation') }}            
                        </div>
                    </div>
                    <div class="d-flex gap-4 align-items-center">
                        <button type="submit" class="btn btn-primary">{{ __('Đổi') }}</button>
                    
                        @if (session('status') === 'password-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-success mt-3"
                            >{{ __('Đổi mật khẩu thành công') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
</form>


