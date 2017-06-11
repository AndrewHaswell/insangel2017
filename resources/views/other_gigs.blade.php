@extends('insangel')

@section('content')
  <div class="row">
    <div class="col-md-8">@yield('main')</div>
    <div class="col-md-4 available_gigs">@yield('cover')</div>
  </div>
@endsection