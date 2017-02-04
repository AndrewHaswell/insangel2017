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
            color: rgba(0, 0, 250, 0.46);
            font-weight:      bold;
            font-size: 8pt;
            margin-bottom: 5px;
            }

    </style>
</head>
<body>

<div class="container">

    <img src="{{ URL::asset('images/insangel.png') }}"/>

    <div style="margin: 20px 0">
        <div class="center-block">
            <a href="{{url('admin/gig/create')}}" class="btn btn-lg btn-success" role="button">Add Gig</a>
            <a href="{{url('admin/band/create')}}" class="btn btn-lg btn-success" role="button">Add Band</a>
            <a href="{{url('admin/venue/create')}}" class="btn btn-lg btn-success" role="button">Add Venue</a>
            <a href="{{url('admin/cms/create')}}" class="btn btn-lg btn-success" role="button">Add CMS Pages</a>
            <a href="{{url('admin/upload')}}" class="btn btn-lg btn-success" role="button">Upload Gig List</a>
            <a href="{{url('admin/download')}}" class="btn btn-lg btn-success" role="button">Download Gig List</a>
        </div>
    </div>


    <div class="row">

        @if (!empty($gigs))
            @foreach ($gigs as $gig)

                <div class="gig">

                    @if ($gig['cover'] == 'Y')
                        <div class="cover">AVAILABLE GIGS</div>
                    @endif

                    <h3>{{ $gig['title'] ? $gig['title'] : '' }}
                        <small>{{Carbon\Carbon::parse($gig['datetime'])->format('l jS F Y')}}</small>
                        @if (!empty($delete))

                            <span class="edit"><a href="/admin/gig/{{$gig['id']}}/edit"><img
                                            src="{{ URL::asset('images/edit.png') }}"/></a></span>
                        @endif
                    </h3>

                    @if (!empty($gig['subtitle']))
                        <h4>{{$gig['subtitle']}}</h4>
                    @endif

                    <p class="lead"><em><a
                                    href="/admin/venue/{{$gig['venue']['id']}}/edit">{{$gig['venue']['venue_name']}}</a></em>
                    </p>

                    <div>
                        <?php $band_count = count($gig['bands']); ?>
                        <?php $counter = 1; ?>
                        @foreach ($gig['bands'] as $band)
                            <a href="/admin/band/{{$band['id']}}/edit">{{$band['band_name']}}</a>
                            @if ($counter < $band_count)
                                -
                            @endif
                            <?php $counter++; ?>
                        @endforeach
                    </div>


                        @if (!empty($gig['notes']))
                        <small>{{$gig['notes']}} |</small>
                        @endif
                        @if (!empty($gig['cost']))
                        <small>{{is_numeric($gig['cost']) ? '&pound;' . number_format($gig['cost'], 2) : $gig['cost']}} |</small>
                        @endif
                    <small>{{Carbon\Carbon::parse($gig['datetime'])->format('g:i a')}} |</small>
                    <small>07901 616 185</small>



                </div>

            @endforeach
        @endif


    </div>
</div>

</body>
</html>