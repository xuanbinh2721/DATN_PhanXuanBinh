@extends('layouts.customer')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center bg-gradient">
        <div class="col-md-8 mt-3 mb-3">
            <div class="card">
                <div class="card-header">{{ __('Đăng Ký Cho Thuê Sân Thể Thao') }}</div>
                <div class="card-body">
                    <form action="{{ route('registerfield.add') }}" method="Post" enctype="multipart/form-data" class="w-100">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-3">
                                <label class="small mb-1" for="inputImages">Ảnh Sân (Tối đa 5 ảnh)</label>
                                <input class="form-control" name="images[]" id="inputImages" type="file" accept="image/*" onchange="previewFiles()" multiple required>
                            </div>
                            <!-- Hiển thị các ảnh đã chọn -->
                            
                            <div class="mb-3">
                                <div class="container-fluid">
                                    <div class="col-md-12">
                                        <div class="row" id="image-preview">
                                            <!-- Các cột nhỏ cho từng ảnh -->
                                        </div>
                                    </div>                                    
                            </div>
                            
                            <div class="mb-3">
                                <label class="small mb-1" for="inputName">Name</label>
                                <input class="form-control" name="name" id="inputName" type="text" placeholder="Nhập tên sân của bạn" required >
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" for="inputPhoneNumber">Số Điện Thoại</label>                                    
                                <input class="form-control" name="phone_number" id="inputPhoneNumber" type="tel" placeholder="Nhập số điện thoại sân của bạn" required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputDescription">Mô tả</label>
                                <input class="form-control" name="description" id="inputDescription" type="text" placeholder="Nhập mô tả sân của bạn" required>
                            </div>
                            <div class="input-field mb-3">
                                <div class="input-select">
                                <select data-trigger=""  name="sporttype" class="form-select" required>
                                    <option value="">Chọn loại sân thể thao</option>
                                    @foreach($sportTypes as $sportType)
                                    <option value="{{ $sportType->id  }}"> Sân {{ $sportType->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="input-field mb-3">
                                <div class="input-select">
                                <select data-trigger="" name="province" class="form-select" id="province" required>
                                    <option value="">Chọn tỉnh/thành phố</option>
                                    @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div class="input-field mb-3">
                                <div class="input-select">
                                <select data-trigger=""  name="district" class="form-select" id="district" required>
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                                </div>
                            </div>
                            <div class="input-field mb-3">
                                <div class="input-select">
                                <select data-trigger=""  name="ward" class="form-select" id="ward" required>
                                    <option value="">Chọn phường/xã</option>
                                </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputAddress">Địa Chỉ</label>
                                <input class="form-control" name="address" id="inputAddress" type="text" placeholder="Nhập địa chỉ sân của bạn" required>
                            </div>
                        <div class="row third">
                            <div class="input-field mb-3">
                                <button class="btn btn-outline-primary my-2 my-sm-0 w-100" type="submit">Đăng ký sân</button>
                            </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function previewFiles() {
        var preview = document.getElementById('image-preview');
        var filesInput = document.querySelector('input[type=file]');
        var files = filesInput.files;

        preview.innerHTML = ''; // Xóa bất kỳ trước đó đã hiển thị ảnh nào

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onloadend = function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '200px'; // Sử dụng 'px' thay vì 'x'
                img.style.height = '165px'; // Điều chỉnh kích thước ảnh hiển thị trước
                // Tạo một thẻ div để hiển thị mỗi ảnh trên một dòng mới
                var imgContainer = document.createElement('div');
                imgContainer.className = 'col-md-2 me-2';
                imgContainer.appendChild(img);

                // Thêm biểu tượng X để xóa ảnh khi bấm vào
                var deleteIcon = document.createElement('div');
                deleteIcon.innerHTML = '&#10006;'; // Dấu X trong HTML entities
                deleteIcon.className = 'delete-icon ';
                deleteIcon.onclick = function () {
                    imgContainer.remove(); // Xóa thẻ div chứa ảnh khi bấm vào
                    // Cập nhật lại filesInput.value để xóa ảnh khỏi danh sách đã chọn
                    filesInput.value = '';
                };

                imgContainer.appendChild(deleteIcon);

                preview.appendChild(imgContainer);
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    }
</script>



@endsection
