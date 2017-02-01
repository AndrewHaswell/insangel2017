@extends('admin.form')

@section('form_body')

  {!! Form::open(['action' => 'UploadAdminController@store']) !!}

  <div class="form-group">
    {!! Form::label('notes', 'Gig List: ') !!}
    {!! Form::textarea('notes', null, ['class'=>'form-control no_editor', 'rows'=>'5']) !!}
  </div>

  <div class="form-group">
    {!! Form::label('spacing', 'Double Spaced?') !!}
    {!! Form::checkbox('double', 1, false ) !!}
  </div>


  <div class="form-group">
    {!! Form::submit( 'Upload Gig List', ['class' => 'btn btn-primary form-control']) !!}
  </div>

  {!! Form::close() !!}



@endsection