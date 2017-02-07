@extends('gigs')

@section('main')
  @if (!empty($gigs))
    <h2>Gigs</h2>
    @foreach ($gigs as $gig)
      <div class="gig_before"></div>
      <div class="gig">
        @if (!empty($gig['title']))
          <div class="gig_title">{{ $gig['title']}}</div>
        @endif
        @if (!empty($gig['subtitle']))
          <div class="subtitle">{{$gig['subtitle']}}</div>
        @endif
        <div class="gig_date">
          {{Carbon\Carbon::parse($gig['datetime'])->format('l jS F Y')}}
        </div>
        <div class="venue">@ <a href="venues/{{$gig['venue']['seo_name']}}">{{$gig['venue']['venue_name']}}</a></div>
        <div class="bands">
          @foreach ($gig['bands'] as $band)
            <div class="band"><a
                  href="{{!empty($delete)?'/admin/band/'.$band['id'].'/edit':'bands/'.insangel_case($band['band_name'])}}">{{$band['band_name']}}</a>
            </div>
          @endforeach
        </div>
        <div class="details">
          @if (!empty($gig['notes']))
            <span class="detail">{{$gig['notes']}}</span>
          @endif
          @if (!empty($gig['cost']))
            <span
                class="detail">{{is_numeric($gig['cost']) ? '&pound;' . number_format($gig['cost'], 2) : $gig['cost']}}</span>
          @endif
          <span class="detail">{{Carbon\Carbon::parse($gig['datetime'])->format('g:i a')}}</span>
          <span class="detail-last">07901 616 185</span>
        </div>
        @if (!empty($gig['links']))
          <br style="margin-bottom: 40px"/>
          <div class="social_media">
            <div class="social_media_links">
              <?php
              $links = explode(',', $gig['links']);
              foreach ($links as $link) {
                show_social_link($link);
              }
              ?>
            </div>
          </div>
        @endif

      </div>
      <div class="gig_after"></div>

    @endforeach
  @endif
@endsection


@section('cover')
  @if (!empty($cover_gigs))
    <h2>Available Gigs</h2>
    <div id="cover_gigs">

      @if (!empty($cover_gigs))
        @foreach ($cover_gigs as $cover_gig)

          @if (count($cover_gig['gigs'])>0)

            <div class="cover_gig_title">{{$cover_gig['venue_name']}}</div>

            <div class="cover_gigs">
              @if (!empty($cover_gig['gigs']))

                @foreach ($cover_gig['gigs'] as $gig)
                  <div id="cover_gig">{{date('l jS F', strtotime($gig['datetime']))}}
                    :: <strong>{{implode(' | ', $gig->bands->lists('band_name')->toArray())}}</strong></div>
                @endforeach

              @endif
            </div>
          @endif
        @endforeach
      @endif


    </div>
  @endif
@endsection