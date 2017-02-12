<!doctype html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <title>Admin</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .gig {
      margin:        0 0 15px 0;
      padding:       0 0 15px 0;
      border-bottom: 1px dashed grey;
      }

    .cover {
      padding:          8px;
      background-color: rgba(0, 0, 250, 0.20);
      color:            rgba(0, 0, 250, 0.46);
      font-weight:      bold;
      font-size:        8pt;
      margin-bottom:    5px;
      }
    .poster {
      background-color: #d5d5d5;
      color:            white;
      padding:          3px 3px 3px 15px;
      margin:           10px 0 0 0;
      }

  </style>
</head>
<body>

<div class="container">

  <a href="/admin/"><img src="{{ URL::asset('images/insangel.png') }}"/></a>

  <div style="margin: 20px 0">
    <div class="center-block">
      <a href="{{url('admin/gig/create')}}" class="btn btn-lg btn-success" role="button">Add Gig</a>
      <a href="{{url('admin/band/create')}}" class="btn btn-lg btn-success" role="button">Add Band</a>
      <a href="{{url('admin/venue/create')}}" class="btn btn-lg btn-success" role="button">Add Venue</a>
      <a href="{{url('admin/cms/create')}}" class="btn btn-lg btn-success" role="button">Add Pages</a>
      <a href="{{url('admin/cms/list_pages')}}" class="btn btn-lg btn-success" role="button">Edit Pages</a>
      <a href="{{url('admin/upload')}}" class="btn btn-lg btn-success" role="button">Upload Gig List</a>
      <a href="{{url('admin/download')}}" class="btn btn-lg btn-success" role="button">Download Gig List</a>
      <a href="{{url('admin/sponsor/create')}}" class="btn btn-lg btn-success" role="button">Sponsors</a>
    </div>
  </div>

  @if(Session::has('message'))
    <div class="container">
      <div class="body_text">
        <p class="alert alert-danger">{{ Session::get('message') }}</p>
      </div>
    </div>
  @endif

  @yield('content')


</div>

</body>
</html>