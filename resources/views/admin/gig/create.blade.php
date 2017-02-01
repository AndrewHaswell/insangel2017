@extends('admin.form')

@section('form_body')

    {!! Form::open(['action' => 'GigAdminController@store']) !!}

    <div class="form-group">
        {!! Form::label('date', 'Date: ') !!}
        {!! Form::text('date', (!empty($gigs['datetime']) ? $gigs['datetime'] : null), ['id'=>'datepicker',
        'class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('title', 'Title: ') !!}
        {!! Form::text('title', (!empty($gigs['title']) ? $gigs['title'] : null), ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('subtitle', 'Subtitle: ') !!}
        {!! Form::text('subtitle', (!empty($gigs['subtitle']) ? $gigs['subtitle'] : null), ['class'=>'form-control'])
        !!}
    </div>

    <div class="form-group">
        {!! Form::label('cost', 'Cost: ') !!}
        {!! Form::text('cost', (!empty($gigs['cost']) ? $gigs['cost'] : null), ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('notes', 'Notes: ') !!}
        {!! Form::text('notes', (!empty($gigs['notes']) ? $gigs['notes'] : null), ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('cover', 'Cover Gig?') !!}
        {!! Form::checkbox('cover', 1, (!empty($gigs['cover']) && $gigs['cover'] == 'Y' ? true : false) ) !!}
    </div>

    <div class="form-group">
        {!! Form::label('venue', 'Venue: ') !!}
        {!! Form::select('venue', $venues, (!empty($gigs['venue']['venue_name']) ? $gigs['venue']['venue_name'] : null),
        ['id' => 'venue',
        'class'=>'form-control']) !!}
    </div>

    @if (!empty($gigs['id']))
        {!! Form::hidden('gig_id', $gigs['id']) !!}
    @endif

    <div id="hidden_bands">
        @if (!empty($gigs['bands']))
            <?php $band_counter = 1 ?>
            @foreach ($gigs['bands'] as $this_band)
                {!! Form::hidden('band_hidden_'.$band_counter, $this_band['band_name'], ['id' =>
                'band_hidden_'.$band_counter,
                'class'=>'hidden_band_names']) !!}
                <?php $band_counter++ ?>
            @endforeach
        @endif
    </div>

    <div class="form-group">
        {!! Form::label('number_of_bands', 'Number of Bands: ') !!}
        {!! Form::select('number_of_bands', range(0,10), (!empty($gigs['bands']) ?count($gigs['bands']):0), ['id' =>
        'number_of_bands', 'class'=>'form-control']) !!}
    </div>

    <span id="band_list"></span>

    <div class="form-group">
        {!! Form::submit((!empty($submit) ? $submit : 'Add Gig'), ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}

    @if (!empty($gigs['id']))
        {!! Form::open(['action' => ['GigAdminController@destroy', $gigs['id']], 'method' => 'delete']) !!}
        <div class="form-group">
            {!! Form::submit('Delete this gig?', ['id' => 'delete_gig', 'class' => 'btn btn-danger btn-primary
            form-control']) !!}
        </div>
        {!! Form::close() !!}
    @endif

@endsection

@section('footer_script')
    <script>

        $(function () {

            $('#delete_gig').click(
                    function () {
                        if (confirm('Are you certain you wish to delete this gig? This CANNOT be reversed')) {
                            return true;
                        }
                        return false;
                    }
            );

            add_bands();

            $('#number_of_bands').bind('change', add_bands);

            function add_bands() {
                var band_count = $('#number_of_bands').val();
                if (band_count > 0) {
                    $.ajax
                    (
                            {
                                url: '{{ url('ajax/bands') }}/' + band_count,
                                dataType: 'html',
                                type: 'GET',
                                async: true,
                                success: function (data) {
                                    $('#band_list').html(data);

                                    $('.hidden_band_names').each(function (index) {
                                        var id = $(this).attr('name').split('_').pop();
                                        var value = $(this).val();
                                        $('.band_' + id).val(value);
                                    });

                                    $(".band_select").select2({
                                        placeholder: "Select band from list, create new one or leave empty for TBC",
                                        tags: true
                                    });
                                }
                            }
                    );
                }
            }

            $("#venue").select2({
                placeholder: "Select a venue from the list or create a new one",
                tags: true
            });

            $("#number_of_bands").select2({
                placeholder: "Select the number of bands for this gig",
                tags: true
            });

            $(document).on('change', '.band_select', function () {
                var id = $(this).attr('id').split('_').pop();
                if ($('#band_hidden_' + id).length) {
                    $('#band_hidden_' + id).val($(this).val());
                } else {
                    var hidden_html = $('#hidden_bands').html();
                    hidden_html += '<input id="band_hidden_' + id + '" class="hidden_band_names" name="band_hidden_' + id + '" value="' + $(this).val() + '" type="hidden">';
                    $('#hidden_bands').html(hidden_html);
                }
            });

            $("#datepicker").datetimepicker({dateFormat: "yy-mm-dd", timeformat: "HH:mm:ss", hour: '19', minute: '00'});

        });

    </script>
@endsection