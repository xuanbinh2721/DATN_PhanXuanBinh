@extends('layouts.customer')

@section('content')
<div class="container">
    <h2>Chi tiết sân: {{ $fields->name }}</h2>
    
    <p>{{ $fields->description }}</p>

    <div class="row">
        @if ($fields->fieldImages && $fields->fieldImages->count() > 0)
            @foreach ($fields->fieldImages->take(5) as $image)
                <div class="col-md-2 mb-3">
                    <img src="{{ asset('storage/' . $fields->fieldImages->first()->image_name) }}" alt="Image" class="img-thumbnail">
                </div>
            @endforeach
        @endif
    </div>

    <a href="{{ url('/home') }}" class="btn btn-primary mt-3">Quay lại</a>
</div>
@endsection
