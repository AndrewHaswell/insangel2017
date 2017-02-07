@extends('admin.form')

@section('form_body')

    {!! Form::open(['action' => 'BandAdminController@store', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('name', 'Name: ') !!}
        {!! Form::text('name', (!empty($band['band_name']) ? $band['band_name'] : null), ['class'=>'form-control']) !!}
    </div>

    {!! Form::hidden('band_id', (!empty($band['id']) ? $band['id'] : 0)) !!}

    <div class="form-group">
        {!! Form::label('description', 'Description: ') !!}
        {!! Form:: textarea('description', (!empty($band['band_description']) ? $band['band_description'] : null),
        ['class'=>'form-control']) !!}
    </div>

    @if (!empty($band['band_logo']))
        <div class="band_logo"><img src="{{ URL::asset('downloads/band_logos/'.$band['band_logo']) }}"/></div>
    @endif

    <div class="form-group">
        <?php $logo_message = !empty($band['band_logo']) ? 'Change Logo' : 'Add Logo'; ?>
        {!! Form::label('logo', $logo_message.': ') !!}
        {!! Form::file('logo', null, ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('links', 'Links: ') !!}
        {!! Form::text('links', (!empty($band['links']) ? $band['links'] : null), ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit((!empty($submit) ? $submit : 'Add Band'), ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

    @if (!empty($band['id']))
        {!! Form::open(['action' => ['BandAdminController@destroy', $band['id']], 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::submit('Delete this band?', ['id' => 'delete_band', 'class' => 'btn btn-danger btn-primary
            form-control']) !!}
        </div>
        {!! Form::close() !!}
    @endif

@endsection

@section('footer_script')
    <script>

        $(function () {

            $('#delete_band').click(
                    function () {
                        if (confirm('Are you certain you wish to delete this band? This CANNOT be reversed')) {
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