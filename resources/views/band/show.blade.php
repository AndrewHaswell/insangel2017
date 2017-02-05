@extends('bands')

@section('main')
  <?php $band_counter = 1; ?>
  <h2>Bands</h2>
  @foreach ($bands as $band)
    @if ($band_counter === 1)
      <div class="row">
        @endif
        <div class="col-md-4">
          <div class="gig_before"></div>
          <div class="gig">
            <a href="bands/{{$band['seo_name']}}">
              @if (!empty($band['band_logo']) && file_exists('downloads/band_logos/'.$band['band_logo']))
                <div class="band_logo"><img style="max-width: 90%" title="{{$band['band_name']}}"
                                            src="{{ URL::asset('downloads/band_logos/'.$band['band_logo']) }}"/>
                </div>
              @else
                <div class="band_title">{{$band['band_name']}}</div>
              @endif
            </a>
            @foreach ($band['gigs'] as $gig)
              <p class="date_row"><span class="gig_date_small">{{date('D jS F', strtotime($gig['datetime']))}}</span> -
                <span class="venue_name_small">{{$gig['venue']['venue_name']}}</span></p>
            @endforeach
            <div>&nbsp;</div>
          </div>
          <div class="gig_after"></div>
        </div>
        @if ($band_counter % 3 == 0)
      </div>
      <?php $band_counter = 1;?>
    @else
      <?php $band_counter++;?>
    @endif

  @endforeach
@endsection