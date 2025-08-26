@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 m-0">Facilities</h1>
  <a href="{{ route('facilities.create') }}" class="btn btn-primary">Add Facility</a>
  </div>

<form method="get" class="row g-2 mb-3">
  <div class="col-md-4">
    <input type="text" class="form-control" name="q" placeholder="Search by name, city, or material" value="{{ $search }}">
  </div>
  <div class="col-md-3">
    <select class="form-select" name="material_id">
      <option value="">Filter by material</option>
      @foreach ($materials as $mat)
        <option value="{{ $mat->id }}" @selected($materialId == $mat->id)>{{ $mat->name }}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-3">
    <select class="form-select" name="sort">
      <option value="updated_desc" @selected($sort==='updated_desc')>Sort: Last Updated (newest)</option>
      <option value="updated_asc" @selected($sort==='updated_asc')>Sort: Last Updated (oldest)</option>
    </select>
  </div>
  <div class="col-md-2 d-flex gap-2">
    <button class="btn btn-secondary w-100" type="submit">Apply</button>
    <a class="btn btn-outline-success" href="{{ route('facilities.export', request()->query()) }}">CSV</a>
  </div>
</form>

<div class="table-responsive">
  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>Business Name</th>
        <th>Last Updated</th>
        <th>Address</th>
        <th>Materials Accepted</th>
        <th style="width:140px"></th>
      </tr>
    </thead>
    <tbody>
      @forelse ($facilities as $facility)
        <tr>
          <td><a href="{{ route('facilities.show', $facility) }}">{{ $facility->business_name }}</a></td>
          <td>{{ \Illuminate\Support\Carbon::parse($facility->last_update_date)->toDateString() }}</td>
          <td>{{ $facility->full_address }}</td>
          <td>
            <span class="small">{{ $facility->materials->pluck('name')->implode(', ') }}</span>
          </td>
          <td class="text-end">
            <a href="{{ route('facilities.edit', $facility) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            <form action="{{ route('facilities.destroy', $facility) }}" method="post" class="d-inline" onsubmit="return confirm('Delete this facility?')">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5" class="text-center text-muted">No facilities found.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div class="mt-3">
  {{ $facilities->links() }}
  </div>
@endsection

