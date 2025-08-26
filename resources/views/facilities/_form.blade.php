@csrf
<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">Business Name</label>
    <input type="text" name="business_name" class="form-control" value="{{ old('business_name', $facility->business_name ?? '') }}" required>
    @error('business_name')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Last Update Date</label>
    <input type="date" name="last_update_date" class="form-control" value="{{ old('last_update_date', isset($facility) ? (is_string($facility->last_update_date) ? $facility->last_update_date : $facility->last_update_date->format('Y-m-d')) : '') }}" required>
    @error('last_update_date')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6">
    <label class="form-label">Street Address</label>
    <input type="text" name="street_address" class="form-control" value="{{ old('street_address', $facility->street_address ?? '') }}" required>
    @error('street_address')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-3">
    <label class="form-label">City</label>
    <input type="text" name="city" class="form-control" value="{{ old('city', $facility->city ?? '') }}" required>
    @error('city')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-1">
    <label class="form-label">State</label>
    <input type="text" name="state" class="form-control" value="{{ old('state', $facility->state ?? '') }}" required>
    @error('state')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-2">
    <label class="form-label">Postal Code</label>
    <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $facility->postal_code ?? '') }}" required>
    @error('postal_code')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-12">
    <label class="form-label">Materials Accepted</label>
    <div class="row row-cols-2 row-cols-md-3 g-2">
      @foreach($materials as $mat)
        <div class="col">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="materials[]" value="{{ $mat->id }}" id="mat{{ $mat->id }}"
              @checked(in_array($mat->id, old('materials', isset($facility) ? $facility->materials->pluck('id')->all() : [])))>
            <label class="form-check-label" for="mat{{ $mat->id }}">{{ $mat->name }}</label>
          </div>
        </div>
      @endforeach
    </div>
    @error('materials')<div class="text-danger small">{{ $message }}</div>@enderror
  </div>

  <div class="col-12 d-flex gap-2">
    <button class="btn btn-primary" type="submit">Save</button>
    <a href="{{ route('facilities.index') }}" class="btn btn-outline-secondary">Cancel</a>
  </div>
</div>

