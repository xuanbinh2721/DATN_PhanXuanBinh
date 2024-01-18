@extends('layouts.provider')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center bg-gradient">
        <div class="col-md-8 mt-3 mb-3">
            <div class="card">
                <div class="card-header">{{ __('Sửa Thông Tin Sân Thể Thao') }}</div>
                <div class="card-body">
                    <form action="{{ route('field.update', $field->id) }}" method="POST" enctype="multipart/form-data" class="w-100">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-3">
                                <label class="small mb-1" for="inputImages">Tải thêm ảnh sân (Tối đa 5 ảnh)</label>
                                <input class="form-control" name="images[]" id="inputImages" type="file" accept="image/*" onchange="previewFiles()" multiple>
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
                                <label class="small mb-1" for="selectedImages">Chọn ảnh muốn hiển thị từ danh sách hiện có(Tối đa 5 ảnh)</label>
                                <select id="selectedImages" class="form-select" name="selected_images[]" multiple>
                                    @foreach ($field->fieldImages as $image)
                                        <option value="{{ $image->id }}">{{ $image->image_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="small mb-1" for="selectedImagePreview">Ảnh đã chọn</label>
                                <div id="selectedImagesPreview" class="d-flex flex-wrap w-100">
                                    <!-- Ảnh đã chọn sẽ được hiển thị ở đây -->
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputName">Name</label>
                                <input class="form-control" name="name" id="inputName" type="text" value="{{ $field->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" for="inputPhoneNumber">Số Điện Thoại</label>                                    
                                <input class="form-control" name="phone_number" id="inputPhoneNumber" type="tel" placeholder="Nhập số điện thoại sân của bạn" value="{{ $field->phone_number }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="inputNote">Mô tả</label>
                                <textarea class="form-control" name="description" id="inputDescription" placeholder="Nhập mô tả sân của bạn" required>{{ $field->description }}</textarea>
                            </div>                            
                            <div class="input-field mb-3">
                                <div class="input-select">
                                    <label class="small mb-1" for="inputDescription">Loại sân</label>
                                    <select data-trigger="" name="sporttype" class="form-select" required>
                                        <option value="">Chọn loại sân thể thao</option>
                                        @foreach($sportTypes as $sportType)
                                            <option value="{{ $sportType->id }}" {{ $field->sport_type_id == $sportType->id ? 'selected' : '' }}> Sân {{ $sportType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-field mb-3">
                                <div class="input-select">
                                    <label class="small mb-1" for="inputDescription">Chọn Tỉnh/Thành phố</label>
                                    <select data-trigger="" name="province" class="form-select" id="province" required>
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province->id }}" {{ $field->province_id == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-field mb-3">
                                <div class="input-select">
                                    <label class="small mb-1" for="inputDescription">Chọn Quận/Huyện</label>
                                    <select data-trigger="" name="district" class="form-select" id="district" required>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ $field->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-field mb-3">
                                <div class="input-select">
                                    <label class="small mb-1" for="inputDescription">Chọn Phường/Xã</label>
                                        <select data-trigger="" name="ward" class="form-select" id="ward" required>
                                        @foreach($wards as $ward)
                                            <option value="{{ $ward->id }}" {{ $field->ward_id == $ward->id ? 'selected' : '' }}>{{ $ward->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                            
                            <div class="mb-3">
                                <label class="small mb-1" for="inputAddress">Địa Chỉ Chi Tiết</label>
                                <input class="form-control" name="address" id="inputAddress" type="text" placeholder="Nhập địa chỉ sân của bạn" value="{{ $field->address }}" required>
                            </div>

                            <div class="row third">
                                <div class="input-field mb-3">
                                    <button class="btn btn-outline-primary my-2 my-sm-0 me-3" type="submit">Cập nhật thông tin</button>
                                    <a href="{{ route('field.index') }}" class="btn btn-outline-danger my-2 my-sm-0" type="submit">Hủy</a>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>
<script>
    // Hàm xem trước ảnh giữ nguyên
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
                img.alt = 'Selected Image';
                img.className = 'img-fluid w-100';
                img.style.height = '200px';
            

                var imgContainer = document.createElement('a');
                imgContainer.href = img.src;
                imgContainer.className = 'col-md-2 me-auto mb-3 ';
                imgContainer.setAttribute('data-toggle', 'lightbox');
                imgContainer.appendChild(img);
                // Thêm biểu tượng X để xóa ảnh khi bấm vào
                var deleteIcon = document.createElement('div');
                deleteIcon.innerHTML = '&#10006;';
                deleteIcon.className = 'delete-icon ';
                deleteIcon.onclick = function () {
                    imgContainer.remove();
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
<script>
    document.getElementById('selectedImages').addEventListener('change', function() {
        var selectedImages = this.selectedOptions;
        var previewContainer = document.getElementById('selectedImagesPreview');

        // Xóa tất cả các ảnh đã hiển thị trước đó
        previewContainer.innerHTML = '';

        // Duyệt qua tất cả các ảnh đã chọn và thêm chúng vào lightbox
        for (var i = 0; i < selectedImages.length; i++) {
            var selectedImageSrc = '{{ asset('storage/') }}/' + selectedImages[i].text;

            // Tạo thẻ <a> chứa ảnh, sử dụng Bootstrap Lightbox
            var imageLink = document.createElement('a');
            imageLink.href = selectedImageSrc;
            imageLink.className = 'col-md-2 me-auto mb-3 my-lightbox-toggle';
            imageLink.setAttribute('data-toggle', 'lightbox');

            // Tạo thẻ <img> và thêm nó vào thẻ <a>
            var img = document.createElement('img');
            img.src = selectedImageSrc;
            img.alt = 'Selected Image';
            img.className = 'img-fluid w-100';
            img.style.height = '200px';
            imageLink.appendChild(img);

            // Thêm thẻ <a> vào container
            previewContainer.appendChild(imageLink);
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.my-lightbox-toggle').forEach((el) => el.addEventListener('click', (e) => {
            e.preventDefault();
            const lightbox = new Lightbox(el, options);
            lightbox.show();
    }));
});
</script>

@endsection


