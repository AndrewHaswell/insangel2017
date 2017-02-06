@extends('bands')

@section('main')

  @if (!empty($band['band_logo']) && file_exists('downloads/band_logos/'.$band['band_logo']))
    <div class="band_logo"><img style="max-width: 90%" title="{{$band['band_name']}}"
                                src="{{ URL::asset('downloads/band_logos/'.$band['band_logo']) }}"/>
    </div>
  @endif

  <div class="band_title">{{$band['band_name']}}</div>

  @if (!empty($band['band_description']))
    <div class="band_details_mini_title">About:</div>
    <div class="band_details">{!!  $band['band_description'] !!}</div>
  @endif

  @if (!empty($band->gigs))
    <div class="band_details_mini_title">Upcoming Gigs:</div>
    @foreach ($band->gigs as $gig)
      <p class="band_gig">{{Carbon\Carbon::parse($gig['datetime'])->format('l jS F Y')}}
        - {{ $gig->venue['venue_name'] }}</p>
    @endforeach
  @endif

@endsection