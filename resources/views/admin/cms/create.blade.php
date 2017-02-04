@extends('admin.form')

@section('form_body')

  {!! Form::open(['action' => 'CmsAdminController@store', 'files' => true]) !!}

  <div class="form-group">
    {!! Form::label('title', 'Title: ') !!}
    {!! Form::text('title', (!empty($cms['title']) ? $cms['title'] : null), ['class'=>'form-control']) !!}
  </div>

  {!! Form::hidden('cms_id', (!empty($cms['id']) ? $cms['id'] : 0)) !!}

  <div class="form-group">
    {!! Form::label('content', 'Content: ') !!}
    {!! Form:: textarea('content', (!empty($cms['content']) ? $cms['content'] : null),
    ['class'=>'form-control']) !!}
  </div>

  <div class="form-group">
    {!! Form::submit((!empty($submit) ? $submit : 'Add CMS Page'), ['class' => 'btn btn-primary form-control']) !!}
  </div>

  {!! Form::close() !!}

  @if (!empty($cms['id']))
    {!! Form::open(['action' => ['CmsAdminController@destroy', $cms['id']], 'method' => 'delete']) !!}
    <div class="form-group">
      {!! Form::submit('Delete this CMS page?', ['id' => 'delete_cms', 'class' => 'btn btn-danger btn-primary
      form-control']) !!}
    </div>
    {!! Form::close() !!}
  @endif

@endsection

@section('footer_script')
  <script>

    $(function () {

      $('#delete_cms').click(
        function () {
          if (confirm('Are you certain you wish to delete this page? This CANNOT be reversed')) {
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