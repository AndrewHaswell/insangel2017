@extends('other_gigs')

@section('js')
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
  <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>
  <link
      href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css"
      rel="stylesheet"/>
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
@endsection

@section('main')

  <?php
  $month_year = '';
  ?>

  @if (!empty($ne_gigs))
    <h2>North East Gigs</h2>



    @foreach ($ne_gigs as $date => $gig)

      <?php
      $my = date('F Y', $date);
      ?>
      @if ($my != $month_year)
        <?php $month_year = $my;?>
        <div class="month_year">{{$month_year}}</div>
      @endif
      <div class="gig_before"></div>
      <div class="gig">

        <?php
        usort($gig, function ($a, $b) {
          return $a['date'] - $b['date'];
        });
        ?>
        <div class="gig_date">
          {{ date('l jS F Y', $date) }}
        </div>

        <table class="ne_gigs" width="100%">

          @foreach ($gig as $this_gig)
            <tr>
              <td style="font-weight: bold" valign="top" width="50%">{{$this_gig['title']}}</td>
              <td style="font-style: italic" valign="top" width="50%">{{$this_gig['venue']}}
                - {{date('g:ia', $this_gig['date'])}}<?= is_numeric($this_gig['cost'])
                  ? ' (&pound;' . number_format($this_gig['cost'], 2) . ')'
                  : ''?></td>

            </tr>


          @endforeach
        </table>

      </div>
      <div class="gig_after"></div>
    @endforeach
  @endif
@endsection

@section('cover')
  <h2>Post Your Gigs</h2>

  <div class="post_gigs">
    <p>
      To add your gigs to the list, please enter the form below. Gigs will not appear until they are approved by an
      admin. To be alerted when your gigs are live, please enter your email address (this is for alerts only and will
      not be attached to the gig or used for any other purpose).</p>
  </div>

  @if (!empty($gig_message))
    <div class="alert alert-danger">
      <p style="text-align: center">- {{ $gig_message }} -</p>
    </div>
  @endif

  @if (count($errors) > 0)
    <div class="alert alert-danger">
      @foreach ($errors->all() as $error)
        <p style="text-align: center">- {{ $error }} -</p>
      @endforeach
    </div>
  @endif

  {!! Form::open(['action' => 'OtherController@store', 'files' => true]) !!}
  <div class="form-group">
    {!! Form::label('name', 'Bands: ') !!}
    {!! Form::text('name', null, ['class'=>'form-control']) !!}
  </div>
  <div class="form-group">
    {!! Form::label('venue', 'Venue: ') !!}
    {!! Form::text('venue', null, ['class'=>'form-control']) !!}
  </div>
  <div class="form-group">
    {!! Form::label('date', 'Date: ') !!}
    {!! Form::text('date', null, ['id'=>'datepicker',
    'class'=>'form-control']) !!}
  </div>
  <div class="form-group">
    {!! Form::label('price', 'Price: ') !!}
    {!! Form::text('price', null, ['class'=>'form-control']) !!}
  </div>
  <div class="form-group">
    {!! Form::label('email', 'Email: (Optional) ') !!}
    {!! Form::text('email', null, ['class'=>'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::submit((!empty($submit) ? $submit : 'Add Venue'), ['class' => 'btn btn-primary form-control']) !!}
  </div>
  {!! Form::close() !!}



@endsection

@section('js_footer')
  <script>
    $(function () {
      $("#datepicker").datetimepicker({dateFormat: "yy-mm-dd", timeformat: "HH:mm:ss", hour: '19', minute: '00'});
    });
  </script>
@endsection