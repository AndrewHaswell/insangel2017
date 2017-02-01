<!doctype html>
<html lang="en-GB">

<head>

    <meta charset="UTF-8">
    <title>Gig Guide</title>

    <link href='http://fonts.googleapis.com/css?family=Montez' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,700,400' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Patrick+Hand|Just+Another+Hand' rel='stylesheet' type='text/css'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ URL::asset('css/gig.css') }}" rel="stylesheet">

    <style>

        @font-face {
            font-family: Impact;
            src:         url('{{ URL::asset('fonts/Impact Label Reversed.ttf') }}');
            }

        #navigation {
            position: relative;
            }

        #navigation .menu-item {
            background-color: black;
            width:            200px;
            float:            right;
            margin:           10px;
            padding:          5px 10px;
            border:           2px solid white;
            text-align:       center;
            position:         relative;
            }

        #navigation .menu-item > a {
            font-family:     Impact, fantasy;
            font-size:       16pt;
            color:           white;
            text-decoration: none;
            }

        #navigation .menu-item:hover {
            background-color: #5c5c5c;
            }

        body {
            background-image: url("{{ URL::asset('images/graffiti_background.png') }}");
            font-family:      Roboto, fantasy;
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

        #cover_gigs {
            background-color: white;
            padding:          10px;
            border:           1px solid black;
            }

        .band_logo img {
            display: block;
            margin:  -1px auto 8px auto;
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

        .band_title {
            font-family:   "Patrick Hand";
            text-align:    center;
            font-size:     24pt;
            margin-bottom: 8px;
            color:         #9c4c49;
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
        <div id="insangel_logo" class="col-md-3"><img src="{{ URL::asset('images/insangel.png') }}"/></div>
            @include('includes.menu')
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