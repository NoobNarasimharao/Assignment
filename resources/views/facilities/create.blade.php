@extends('layouts.main')

@section('content')
<h1 class="h3 mb-3">Add Facility</h1>
<form method="post" action="{{ route('facilities.store') }}">
  @include('facilities._form')
</form>
@endsection

