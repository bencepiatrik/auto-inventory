@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-3">{{ $part->exists ? 'Edit Part' : 'New Part' }}</h1>

    <form method="post" action="{{ $part->exists ? route('parts.update',$part) : route('parts.store') }}" class="row gy-3">
        @csrf
        @if($part->exists) @method('PUT') @endif

        <div class="col-md-5">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" value="{{ old('name',$part->name) }}" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Serial number</label>
            <input name="serialnumber" class="form-control" value="{{ old('serialnumber',$part->serialnumber) }}" required>
        </div>

        <div class="col-md-3">
            <label class="form-label">Quantity</label>
            <input type="number" min="1" name="quantity" class="form-control" value="{{ old('quantity',$part->quantity ?? 1) }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Car</label>
            <select name="car_id" class="form-select" required>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}" @selected(old('car_id',$part->car_id)==$car->id)>
                        {{ $car->name }} @if($car->is_registered && $car->registration_number) ({{ $car->registration_number }}) @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12">
            <button class="btn btn-primary">{{ $part->exists ? 'Save changes' : 'Create' }}</button>
            <a href="{{ route('parts.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>
    </form>
@endsection
