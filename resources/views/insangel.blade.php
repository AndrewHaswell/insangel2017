<!doctype html>
<html lang="en-GB">

<head>

  <meta charset="UTF-8">
  <title>Gig Guide</title>

  <link href='http://fonts.googleapis.com/css?family=Montez' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Roboto:300,700,400' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Patrick+Hand|Just+Another+Hand' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ URL::asset('css/gig.css') }}" rel="stylesheet">

  <style>
    a {
      color:           inherit;
      text-decoration: none;

      }

    @font-face {
      font-family: Impact;
      src:         url('{{ URL::asset('fonts/Impact Label Reversed.ttf') }}');
      }

    @font-face {
      font-family: Captain;
      src:         url('{{ URL::asset('fonts/American Captain.ttf') }}');
      }

    @font-face {
      font-family: Crimes;
      src:         url('{{ URL::asset('fonts/Plane Crash.ttf') }}');

      }

    .project-container {
      text-align: center;
      padding:    0 30px;
      }

    ul {
      text-align: left;
      display:    inline;
      }

    li,
    .project-box {
      display: inline-block;
      }


    .project-box > a {
      font-family:     Impact, fantasy;
      word-spacing:    -0.3em;
      font-size:       20pt;
      color:           black;
      text-decoration: none;
      padding:         0 10px;
      }

    #navigation li a:hover {
      cursor:           pointer;
      color:            white;
      background-color: #5c5c5c;
      }

    body {
      background-image: url("{{ URL::asset('images/graffiti_background.jpg') }}");
      font-family:      Roboto, fantasy;
      }

    h1, h2, h3 {
      font-family: Captain;
      font-size:   40pt;
      }

    h2 {
      font-size: 30pt;
      }

    h3 {
      font-size: 20pt;
      }

    #cms_page {
      background-color: white;
      border:           1px solid grey;
      padding:          15px;
      margin:           20px 0 0 0;
      }

    .container {
      padding:      0;
      border:       18px solid transparent;
      border-image: url("{{ URL::asset('images/dirt_border.png') }}") 18 18 repeat;
      }

    .body_text {
      background-image: url("{{ URL::asset('images/dirt.png') }}");
      padding:          0 20px 30px 20px;
      }

    .link_text {
      background-image: url("{{ URL::asset('images/dirt.png') }}");
      padding:          3px;
      }

    #cover_gigs {
      background-color: white;
      padding:          10px;
      border:           1px solid black;
      }

    .band_logo img {
      display:    block;
      margin:     -1px auto 8px auto;
      max-height: 250px;
      }

    .cover_gig_title {
      font-size:     14pt;
      border-bottom: 1px dashed black;
      }

    .cover_gigs {
      margin: 10px 0;
      }

    .date_row {
      text-align:  center;
      font-size:   12pt;
      line-height: 1.1em;
      margin:      0 0 4px 0;
      padding:     0;
      }

    .date_row > .venue_name_small {
      font-weight: bold;
      }

    .band_title, .band_details_mini_title {
      font-family:      "Captain";
      letter-spacing:   0.2em;
      text-align:       left;
      font-size:        18pt;
      margin:           0 0 8px 0;
      color:            #ffffff;
      background-color: #595959;
      padding:          5px 10px;
      }

    .band_details {
      padding: 5px 10px;
      }

    .band_details_mini_title {
      font-size:        12pt;
      color:            #5f5f5f;
      padding:          8px 0;
      background-color: transparent;
      border-bottom:    1px dashed #8c8c8c;
      }

    .band_gig {

      padding:          4px 0 4px 15px;
      background-color: transparent;
      border-bottom:    1px dashed #8c8c8c;
      }

    .venue_page_gig {
      margin:        0 0 6px 0;
      border-bottom: 1px dashed grey;
      }

    .venue_page_gig p {
      margin-bottom: 4px;
      text-align:    center;
      font-size:     12pt;
      }

    .venue_page_gig p.small_gig_date {
      font-weight: bold;

      }


  </style>

</head>

<body>
<div class="container" style="border:none">
  <div class="row">
    <a href="/">
      <div id="insangel_logo" class="col-md-3"><img src="{{ URL::asset('images/insangel.png') }}"/></div>
    </a>
  </div>
</div>

<div class="container">
  <div class="link_text">
    <div class="row">
      @include('includes.menu')
    </div>
  </div>
</div>

@if(Session::has('message'))
  <div class="container">
    <div class="body_text">
      <p class="alert alert-danger">{{ Session::get('message') }}</p>
    </div>
  </div>
@endif

<div class="container">
  <div class="body_text">
    @yield('content')
  </div>
</div>

</body>
</html>