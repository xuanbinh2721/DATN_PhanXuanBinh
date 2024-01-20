@extends('layouts.provider')


@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            @include('field.revenue.partials.daily')
        </div>
        <div class="col-md-6">
            @include('field.revenue.partials.monthly')
        </div>
    </div>
</div>




@endsection
