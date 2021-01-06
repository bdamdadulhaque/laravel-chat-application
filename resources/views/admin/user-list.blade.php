@extends('admin.app')
@section('content')
<div class="pt-3 pb-2 mb-3">
  <h3>User List</h3>
  <div class="table-responsive">
    <table class="table table-striped table-sm text-center">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection