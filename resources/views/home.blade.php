@extends('layouts.customer')

@section('content')
@if(session('success'))
<div class="container-fluid mt-3">
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
</div>
@elseif(session('error'))
<div class="container-fluid mt-3">
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
</div>
@endif
@include('layouts.search')

<div class="container-fluid bg-white pt-3">
  <h3 >Bạn muốn tìm sân?</h3>
  <hr>
  <div class="row">
    @include('layouts.getfields')
  </div>
</div>
@endsection