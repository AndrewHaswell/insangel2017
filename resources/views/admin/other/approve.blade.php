@extends('admin.admin')

@section('content')


  @if (!empty($other_gigs) && count($other_gigs) > 0)
    {!! Form::open(['action' => 'OtherAdminController@store']) !!}

    <table id="upcoming" class="table table-striped table-hover">

      <thead class="thead-default">
      <tr>
        <th>Name</th>
        <th>Venue</th>
        <th>Date</th>
        <th>Cost</th>
        <th>Approve</th>
        <th>Delete</th>
      </tr>
      </thead>

      @foreach ($other_gigs as $gig)
        <tr>

          <td>
            {{ $gig->name }}
          </td>
          <td>
            {{ $gig->venue }}
          </td>
          <td>
            {{ $gig->datetime }}
          </td>
          <td>
            {{ $gig->cost }}
          </td>
          <td>
            <div class="form-group">
              {!! Form::checkbox('approve[]', $gig->id, true ) !!}
            </div>
          </td>
          <td>
            <div class="form-group">
              {!! Form::checkbox('delete[]', $gig->id, false ) !!}
            </div>
          </td>
        </tr>
      @endforeach
      <tr>
        <td colspan="6">
          <div class="form-group">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
          </div>
        </td>
      </tr>

    </table>
    {!! Form::close() !!}
  @else
    No gigs to approve / delete
  @endif

@endsection
