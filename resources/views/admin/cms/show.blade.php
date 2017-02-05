@extends('admin.admin')

@section('content')

  <div class="row">

    @if (!empty($pages))
      @foreach ($pages as $page)
        <div><a href="/admin/cms/{{$page->id}}/edit">{{$page->title}}</a></div>
      @endforeach
    @endif

  </div>

@endsection