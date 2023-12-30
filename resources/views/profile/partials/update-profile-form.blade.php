<form action="{{ route('profile.updateInfo') }}" method="POST" enctype="multipart/form-data" class="w-100">
    @csrf
    @method('PUT')

    <div class="card-body">
        <div class="text-center mt-2 mb-3">
            <img class="imgprofile rounded-circle mb-4" id="previewImage" src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="">
            <div class="mt-3">
                <input type="file" name="avatar" accept="image/*"  onchange="previewFile()">  
            </div>
        </div>
        <div class="mb-3">
            <label class="small mb-1" for="inputUsername">Username</label>
            <input class="form-control" name="name" id="inputUsername" type="text" placeholder="Nhập username của bạn" required value="{{ auth()->user()->name }}">
        </div>
        <div class="mb-3">
            <label class="small mb-1" for="inputEmailAddress">Email</label>
            <input class="form-control" name="email" id="inputEmailAddress" type="email" placeholder="Nhập email của bạn" value="{{ auth()->user()->email }}">
        </div>
        <div class="mb-3">
            <label class="small mb-1" for="inputEmailAddress">Số Điện Thoại</label>                                    
            <input class="form-control" name="phone_number" id="inputPhoneNumber" type="tel" placeholder="Nhập số điện thoại của bạn" value="{{ auth()->user()->phone_number }}">
        </div>
        <div class="mb-3">
            <label class="small mb-1" for="inputEmailAddress">Địa Chỉ</label>
            <input class="form-control" name="address" id="inputAddress" type="text" placeholder="Nhập địa chỉ của bạn" value="{{ auth()->user()->address }}">
        </div>
        <div class="d-flex gap-4 align-items-center ">
            <button type="submit" class="btn btn-primary">{{ __('Lưu thông tin') }}</button>                        
                @if (session('status') === 'profile-updated')
                <p class="text text-success mt-3"
                >{{ __('Sửa thông tin thành công.') }}</p>
            @endif
        </div>
    </div>
</form>
    
<script>
    function previewFile() {
        var preview = document.getElementById('previewImage');
        var fileInput = document.querySelector('input[type=file]');
        var file = fileInput.files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "{{ asset('storage/' . auth()->user()->avatar) }}";
        }
    }
</script>

