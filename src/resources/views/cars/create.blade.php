@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">{{ $car->exists ? 'Edit Car' : 'New Car' }}</h1>

    <form method="post" action="{{ $car->exists ? route('cars.update',$car) : route('cars.store') }}" class="row gy-3">
        @csrf
        @if($car->exists) @method('PUT') @endif

        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" value="{{ old('name',$car->name) }}" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Is registered?</label>
            <select name="is_registered" class="form-select">
                <option value="0" @selected(old('is_registered',$car->is_registered)==0)>No</option>
                <option value="1" @selected(old('is_registered',$car->is_registered)==1)>Yes</option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Registration number</label>
            <input name="registration_number" class="form-control" value="{{ old('registration_number',$car->registration_number) }}">
            <div class="form-text">Required only if registered = Yes</div>
        </div>

        <div class="col-12">
            <button class="btn btn-primary">{{ $car->exists ? 'Save changes' : 'Create' }}</button>
            <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
@endsection
