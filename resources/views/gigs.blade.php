@extends('insangel')

@section('content')
    <div class="row">
        <div class="col-md-7">@yield('main')</div>
        <div class="col-md-5 available_gigs">@yield('cover')</div>
    </div>
@endsection