@extends('admin.form')

@section('form_body')

  {!! Form::open(['action' => 'SponsorController@store', 'files' => true]) !!}



  {!! Form::hidden('sponsor_id', (!empty($sponsor['id']) ? $sponsor['id'] : 0)) !!}



  @if (!empty($sponsor['banner_url']))
    <div class="band_logo"><img src="{{ URL::asset('sponsors/'.$sponsor['banner_url']) }}"/></div>
  @endif

  <div class="form-group">
    <?php $logo_message = !empty($sponsor['banner_url'])
      ? 'Change Logo'
      : 'Add Logo'; ?>
    {!! Form::label('logo', $logo_message.': ') !!}
    {!! Form::file('logo', null, ['class'=>'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::label('link_url', 'Link: ') !!}
    {!! Form::text('link_url', (!empty($sponsor['link_url']) ? $sponsor['link_url'] : null), ['class'=>'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::submit((!empty($submit) ? $submit : 'Add Sponsor'), ['class' => 'btn btn-primary form-control']) !!}
  </div>

  {!! Form::close() !!}

  @if (!empty($sponsor['id']))
    {!! Form::open(['action' => ['SponsorController@destroy', $sponsor['id']], 'method' => 'delete']) !!}
    <div class="form-group">
      {!! Form::submit('Delete this sponsor?', ['id' => 'delete_sponsor', 'class' => 'btn btn-danger btn-primary
      form-control']) !!}
    </div>
    {!! Form::close() !!}
  @endif

@endsection

@section('footer_script')
  <script>

    $(function () {

      $('#delete_sponsor').click(
        function () {
          if (confirm('Are you certain you wish to delete this sponsor? This CANNOT be reversed')) {
            return true;
          }
          return false;
        }
      );

    });

    // Prevent bootstrap dialog from blocking focusin
    $(document).on('focusin', function (e) {
      if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
      }
    });
  </script>
@endsection