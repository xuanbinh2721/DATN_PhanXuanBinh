@extends('layouts.customer')

@section('content')
@include('layouts.search')

<div class="container-fluid bg-white pt-3">
  <h3 >Bạn muốn tìm sân?</h3>
  <hr>
  <div class="row">
    @include('layouts.getfields')
  </div>
</div>
@endsection