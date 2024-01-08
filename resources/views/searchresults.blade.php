@extends('layouts.customer')

@section('content')

    @include('layouts.search')

    <div class="container-fluid bg-white pt-2 pb-4">
        <h5 class="mt-3 fw-bold">
            {{ $results->count() }} kết quả tìm được:
            </h5>
            <hr>
            <div class="row ">
                @if ($results && $results->count() > 0)
                    @foreach($results as $result)
                        @if ($result->fields && $result->fields->count() > 0)
                            @foreach($result->fields->take(8) as $field)
                                <div class="col-md-3 mt-4 mb-4">
                                    <a href="{{ route('field.details', ['id' => $field->id]) }}" class="card w-100 text-decoration-none text-dark">
                                        @if ($result->fieldImages && $result->fieldImages->count() > 0)
                                        <img src="{{ asset('storage/' . $result->fieldImages->first()->image_name) }}"
                                            class="card-img-top img-thumbnail img-fluid" alt="Image" style="height: 270px">
                                        @else
                                        <!-- Đường dẫn của ảnh mặc định hoặc ảnh 404 -->
                                        <img src="{{ asset('storage/field_images/default.jpg') }}" class="card-img-top img-thumbnail img-fluid" alt="Default Image">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $result->name }}</h5>
                                            <p class="card-text">{{ $result->description }}</p>
                                            <button class="btn btn-primary">Đặt ngay</button>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                    @else
                        <h3 class="text-center mt-3 mb-5">KHÔNG TÌM THẤY SÂN NÀO!</h3>
                @endif
            </div>    
        <hr>      
    </div>




@endsection

