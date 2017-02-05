@extends('admin.admin')

@section('content')

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
@endsection