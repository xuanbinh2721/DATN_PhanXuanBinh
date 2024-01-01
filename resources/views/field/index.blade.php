@extends('layouts.provider')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="{{ route('field.index') }}" class="text-decoration-none text-dark mt-3 mb-3"><h2 class="fw-bold">Quản lý sân</h2></a>
    </div>
</div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Sân bóng của tôi') }}</div>

                <div class="card-body">
                    @foreach ($fields as $field)
                        <h2 class="mb-4 fw-bold">{{ $field->name }}</h2>
                        <hr>
                        <div class="container-fluid mt-3">
                            <div class="row mt-3">
                                @if ($field->fieldImages && $field->fieldImages->count() > 0)
                                    {{-- Hiển thị ảnh đầu tiên --}}
                                    <div class="col-md-6 mb-3">
                                        <a href="{{ asset('storage/' . $field->fieldImages->first()->image_name) }}" data-toggle="lightbox">
                                            <img src="{{ asset('storage/' . $field->fieldImages->first()->image_name) }}" alt="Image" class="img-fluid w-100" style="height: 444px">
                                        </a>
                                        
                                    </div>
                                    <div class="col-md-6 mb-3">
                                    {{-- Hiển thị các ảnh còn lại --}}
                                        <div class="container-fluid">
                                            <div class="row">
                                            @foreach ($field->fieldImages->slice(1, 4) as $subImage)
                                                @if ($subImage)
                                                    <div class="col-md-6 mb-2">
                                                        <a href="{{ asset('storage/' . $subImage->image_name) }}" data-toggle="lightbox">
                                                            <img src="{{ asset('storage/' . $subImage->image_name) }}" alt="Image" class="img-fluid w-100" style="height: 217.75px">
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <hr>
                <div class="card-body">
                    <p class="fs-5">
                        Mô tả: {{ $field->description }}
                    </p>
                    <p class="fs-5">Địa chỉ: {{ $field->address }}, {{ optional($field->ward)->prefix }} {{ optional($field->ward)->name }}, {{ optional($field->district)->prefix }} {{ optional($field->district)->name }}, {{ optional($field->province)->name }} </p>
                    <p class="fs-5">Số điện thoại: {{ $field->phone_number }}</p>
                    <p class="fs-5">Loại sân thể thao: {{ $field->sportType->name }}</p>
                </div>
                <div class="card-body">
                    <a href="{{ route('field.editfield', $field->id) }}" class="btn btn-outline-primary me-4">Sửa thông tin</a>
                    @if($field-> status == 0)
                        <a href="#" class="btn btn-outline-danger" data-toggle="modal" data-target="#changeOffModal">Ngừng cho thuê</a>
                        <form id="change-off-form" action="{{ route('field.changeoff',$field->id) }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <a href="" class="btn btn-outline-success" data-toggle="modal" data-target="#changeOnModal">Mở cho thuê</a>
                        <form id="change-on-form" action="{{ route('field.changeon',$field->id) }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endif
                </div>
                <hr>
            </div>
        </div>
    </div>
    
</div>
<div class="modal fade" id="changeOffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bạn muốn ngừng cho thuê?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Chọn "Đồng ý" bên dưới để ngừng cho thuê!</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                <a class="btn btn-primary" href="{{ route('field.changeoff',$field->id) }} " onclick="event.preventDefault(); document.getElementById('change-off-form').submit();">Đồng ý</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="changeOnModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bạn muốn cho thuê trở lại?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Chọn "Đồng ý" bên dưới để mở cho thuê!</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                <a class="btn btn-primary" href="{{ route('field.changeon',$field->id) }} " onclick="event.preventDefault(); document.getElementById('change-on-form').submit();">Đồng ý</a>
            </div>
        </div>
    </div>
</div>
@endsection


