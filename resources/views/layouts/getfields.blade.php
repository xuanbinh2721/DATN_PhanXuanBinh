<div class="container-fluid">
    @foreach($sportTypes as $sportType)
        <h5 class="mt-3">Sân {{ $sportType->name }}</h5>
        <div class="row">
            @if ($sportType->fields && $sportType->fields->count() > 0)
                @foreach($sportType->fields->where('status', 'LIKE', '0')->take(8) as $field)
                    @php
                        // Lấy giá của tất cả các timeFrames của sân
                        $prices = $field->timeFrames->pluck('price')->toArray();
                    
                        // Lọc ra các giá trị không null
                        $validPrices = array_filter($prices, function ($price) {
                            return $price !== null;
                        });
                    
                        // Tính giá thấp nhất và giá cao nhất nếu mảng không rỗng
                        $minPrice = !empty($validPrices) ? min($validPrices) : null;
                        $maxPrice = !empty($validPrices) ? max($validPrices) : null;
                    @endphp
                    <div class="col-md-3 mt-4 mb-4">
                        <a href="{{ route('field.details', ['id' => $field->id]) }}" class="card w-100 text-decoration-none text-dark">
                            @if ($field->fieldImages && $field->fieldImages->count() > 0)
                                <img src="{{ asset('storage/' . $field->fieldImages->first()->image_name) }}"
                                    class="card-img-top img-thumbnail img-fluid" alt="Image" style="height: 270px">
                            @else
                                <!-- Đường dẫn của ảnh mặc định hoặc ảnh 404 -->
                                <img src="{{ asset('storage/field_images/default.jpg') }}" class="card-img-top img-thumbnail img-fluid" alt="Default Image" style="height: 270px">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $field->name }}</h5>
                                <p class="card-text">{{ $field->description }}</p>
                                @if ($minPrice< $maxPrice)
                                    <p class="card-text fw-bold fs-4">Giá: {{ number_format($minPrice) }} - {{ number_format($maxPrice) }} VNĐ</p>
                                @elseif ($minPrice == $maxPrice)
                                    <p class="card-text fw-bold fs-4">Giá: {{ number_format($minPrice) }} VNĐ</p>
                                @else
                                    <p class="card-text fw-bold fs-4">Chưa có giá</p>
                                @endif
                                <button class="btn btn-primary">Xem chi tiết</button>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
        </div>
        <hr>
    @endforeach
</div>
