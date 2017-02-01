@extends('admin.form')

@section('form_body')

    {!! Form::open(['action' => 'GigAdminController@upload', 'files' => true]) !!}

    <div class="form-group">
        {!! Form::label('description', 'Description: ') !!}
        {!! Form:: textarea('description', null),
        ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Upload', ['class' => 'btn btn-primary form-control']) !!}
    </div>

    {!! Form::close() !!}



@endsection
