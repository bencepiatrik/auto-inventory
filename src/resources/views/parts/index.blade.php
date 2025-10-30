@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Parts</h1>
        <a class="btn btn-primary" href="{{ route('parts.create') }}">+ New Part</a>
    </div>

    <form class="row g-2 mb-3">
        <div class="col-sm-6 col-md-5">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search name / serial">
        </div>
        <div class="col-sm-4 col-md-3">
            <select name="car_id" class="form-select">
                <option value="">Car: any</option>
                @foreach($cars as $car)
                    <option value="{{ $car->id }}" @selected(request('car_id')==$car->id)>{{ $car->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2 col-md-2">
            <button class="btn btn-outline-secondary w-100">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead><tr>
                <th>Name</th><th>Serial</th><th class="text-end">Qty</th><th>Car</th><th></th>
            </tr></thead>
            <tbody>
            @forelse ($parts as $p)
                <tr>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->serialnumber }}</td>
                    <td class="text-end">{{ $p->quantity }}</td>
                    <td>{{ optional($p->car)->name ?? '—' }}</td>
                    <td class="text-end">
                        <a href="{{ route('parts.edit',$p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('parts.destroy',$p) }}" method="post" class="d-inline" onsubmit="return confirm('Delete part?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No parts.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $parts->links('pagination::bootstrap-5') }}

@endsection
