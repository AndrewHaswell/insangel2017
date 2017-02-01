@extends('error')
@section('content')
    <div class="title">Unauthorised Access</div>
    <div><p>You must be <a href="{{URL::asset('auth/login')}}">logged in</a> to access this section</p></div>
@endsection