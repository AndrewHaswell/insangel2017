<html>
<head>
  <title>Email Update</title>
  <style>
    body {
      background-image: url("{{ URL::asset('images/graffiti_background.jpg') }}");
      font-family:      Roboto, fantasy;
      }

    h1, h2, h3 {
      font-family: Captain;
      font-size:   40pt;
      }
  </style>
</head>
<body>
<img src="{{ URL::asset('images/insangel.png') }}"/>
<h3>Gigs Approved!</h3>
<p>Thanks for adding your gigs to Insangel.co.uk - they've been approved and are now live on the site.</p>
<a href="{{URL::to('/other')}}">North East Gig Guide</a>
</body>
</html>
