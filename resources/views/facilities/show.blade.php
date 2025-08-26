@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 m-0">{{ $facility->business_name }}</h1>
  <div class="d-flex gap-2">
    <a class="btn btn-outline-primary btn-sm" href="{{ route('facilities.edit', $facility) }}">Edit</a>
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('facilities.index') }}">Back</a>
  </div>
</div>

<div class="row g-4">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <dl class="row mb-0">
          <dt class="col-sm-4">Business Name</dt>
          <dd class="col-sm-8">{{ $facility->business_name }}</dd>
          <dt class="col-sm-4">Last Updated</dt>
          <dd class="col-sm-8">{{ \Illuminate\Support\Carbon::parse($facility->last_update_date)->toFormattedDateString() }}</dd>
          <dt class="col-sm-4">Address</dt>
          <dd class="col-sm-8">{{ $facility->full_address }}</dd>
          <dt class="col-sm-4">Materials</dt>
          <dd class="col-sm-8">{{ $facility->materials->pluck('name')->implode(', ') }}</dd>
        </dl>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="ratio ratio-4x3">
      <iframe
        src="https://www.google.com/maps?q={{ urlencode($facility->full_address) }}&output=embed"
        style="border:0;" allowfullscreen loading="lazy"></iframe>
    </div>
  </div>
</div>
@endsection

