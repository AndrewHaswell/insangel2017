@extends('cms')

@section('main')
  <div id="cms_page">


    <h1>{{$page->title}}</h1>

    {!! $page->content !!}

  </div>

@endsection