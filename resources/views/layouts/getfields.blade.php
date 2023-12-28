<div class="container-fluid">
  @foreach($sportTypes as $sportType)
      <h5 class="mt-3 ">{{ $sportType->name }}</h5>
      <div class="row">
        @if ($sportType->fields && $sportType->fields->count() > 0)
        @foreach($sportType->fields->take(8) as $field)
            <div class="col-md-3 mt-4 mb-3">
                <div class="card w-100" >
                    @if ($field->fieldImages && $field->fieldImages->count() > 0)
                        <img src="{{ asset('storage/' . $field->fieldImages->first()->image_name) }}" class="card-img-top" alt="Image">
                    @else
                        <!-- Đường dẫn của ảnh mặc định hoặc ảnh 404 -->
                        <img src="{{ asset('path/to/default-image.jpg') }}" class="card-img-top" alt="Default Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $field->name }}</h5>
                        <p class="card-text">{{ $field->description }}</p>
                        <a href="{{ route('field.details', ['id' => $field->id]) }}" class="btn btn-primary">Chi tiết</a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
      </div>
  @endforeach
</div>