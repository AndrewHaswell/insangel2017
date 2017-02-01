@extends('admin.form')

@section('form_body')

    {!! Form::open(['action' => 'VenueAdminController@store', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name: ') !!}
        {!! Form::text('name', (!empty($venue['venue_name']) ? $venue['venue_name'] : null), ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Description: ') !!}
        {!! Form:: textarea('description', (!empty($venue['venue_description']) ? $venue['venue_description'] : null),
        ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('address', 'Address: ') !!}
        {!! Form:: text('address', (!empty($venue['venue_address']) ? $venue['venue_address'] : null),
        ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('telephone', 'Telephone: ') !!}
        {!! Form:: text('telephone', (!empty($venue['venue_telephone']) ? $venue['venue_telephone'] : null),
        ['class'=>'form-control']) !!}
    </div>

    @if (!empty($venue['venue_logo']))
        <div class="venue_logo"><img src="{{ URL::asset('downloads/venue_logos/'.$venue['venue_logo']) }}"/></div>
    @endif

    <div class="form-group">
        <?php $logo_message = !empty($venue['venue_logo']) ? 'Change Logo' : 'Add Logo'; ?>
        {!! Form::label('logo', $logo_message.': ') !!}
        {!! Form::file('logo', null, ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit((!empty($submit) ? $submit : 'Add Venue'), ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

@endsection

@section('footer_script')
    <script>
        // Prevent bootstrap dialog from blocking focusin
        $(document).on('focusin', function (e) {
            if ($(e.target).closest(".mce-window").length) {
                e.stopImmediatePropagation();
            }
        });
    </script>
@endsection