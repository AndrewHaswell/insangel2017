<!doctype html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <title>{{!empty($title)?$title:'New Gig'}}</title>

    <style>
        .band_logo {
            margin: 25px 0;
            }

        .band_logo img {
            display: block;
            margin: 0 auto;
            max-width:  350px;
            max-height: 200px;
            }
    </style>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css"
          rel="stylesheet"/>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>

    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script>tinymce.init({selector: "textarea:not(.no_editor)", invalid_elements: "style", plugins: "image"});</script>
</head>

<body>
<div id="head">
    <div id="insangel_logo"><img style = "display:block; margin: 0 auto 10px auto" src="{{ URL::asset('images/insangel.png') }}"/></div>
</div>
<div class="container">
    <h1>{{!empty($title)?$title:'New Gig'}}</h1>
    <hr/>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
    @endif

    @yield('form_body')

</div>

@yield('footer_script')
</body>


</html>