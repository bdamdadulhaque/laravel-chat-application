@extends('admin.app')
@section('content')
<div class="pt-3 pb-2 mb-3">
    <h3>Admin Dashboard</h3>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
        You are logged in!
</div>
@endsection