@extends('layouts.main')

@section('content')
<h1 class="h3 mb-3">Edit Facility</h1>
<form method="post" action="{{ route('facilities.update', $facility) }}">
  @method('PUT')
  @include('facilities._form')
</form>
@endsection

