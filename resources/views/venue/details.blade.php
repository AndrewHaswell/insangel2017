@extends('venues')

@section('main')

  <!--
  "id" => 1
  "venue_name" => "Donnington"
  "seo_name" => "donnington"
  "venue_description" => ""
  "venue_logo" => ""
  "venue_address" => ""
  "venue_telephone" => ""
  "created_at" => "2017-02-01 08:27:23"
  "updated_at" => "2017-02-01 22:10:13"
  -->

  @if (!empty($venue['venue_logo']) && file_exists('downloads/venue_logos/'.$venue['venue_logo']))
    <div class="band_logo"><img style="max-width: 90%" title="{{$venue['venue_name']}}"
                                src="{{ URL::asset('downloads/venue_logos/'.$venue['venue_logo']) }}"/>
    </div>
  @endif



  <div class="band_title">{{$venue['venue_name']}}</div>

  @if (!empty($venue['venue_description']))
    <div class="band_details_mini_title">About:</div>
    <div class="band_details">{!!  $venue['venue_description'] !!}</div>
  @endif
  @if (!empty($venue['venue_address']))
    <div class="band_details_mini_title">Address:</div>
    <div class="band_details"><a
          href="https://www.google.co.uk/maps?q={!!  html_entity_decode($venue['venue_name'] . ', '.$venue['venue_address']) !!}">{!!  $venue['venue_address'] !!}</a>
    </div>
  @endif

  @if (!empty($venue->gigs))
    <div class="band_details_mini_title">Upcoming Gigs:</div>
    @foreach ($venue->gigs as $gig)

      <?php
      $this_gig_bands = [];
      foreach ($gig->bands as $band) {
        $this_gig_bands[] = $band['band_name'];
      }
      ?>

      <p class="band_gig">{{Carbon\Carbon::parse($gig['datetime'])->format('l jS F Y')}}
        - {{implode('&nbsp;&nbsp;|&nbsp;&nbsp;',$this_gig_bands)}}</p>
    @endforeach
  @endif

  @if (!empty($venue['links']))
    <div class="social_media" style="top:0">
      <div class="social_media_links">
        <?php
        $links = explode(',', $venue['links']);
        foreach ($links as $link) {
          show_social_link($link);
        }
        ?>
      </div>
    </div>
    <br/>
  @endif


@endsection