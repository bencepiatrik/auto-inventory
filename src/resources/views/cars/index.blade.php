@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Cars</h1>
        <a class="btn btn-primary" href="{{ route('cars.create') }}">+ New Car</a>
    </div>

    <form class="row g-2 mb-3">
        <div class="col-sm-6 col-md-5">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search name / reg. no.">
        </div>
        <div class="col-sm-4 col-md-3">
            <select name="registered" class="form-select">
                <option value="">Registered: any</option>
                <option value="1" @selected(request('registered')==='1')>Yes</option>
                <option value="0" @selected(request('registered')==='0')>No</option>
            </select>
        </div>
        <div class="col-sm-2 col-md-2">
            <button class="btn btn-outline-secondary w-100">Filter</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead><tr>
                <th>Name</th><th>Reg. number</th><th>Registered</th><th class="text-end">Parts</th><th></th>
            </tr></thead>
            <tbody>
            @forelse ($cars as $c)
                <tr>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->registration_number ?? '—' }}</td>
                    <td>
                        @if($c->is_registered)
                            <span class="badge text-bg-success">Yes</span>
                        @else
                            <span class="badge text-bg-secondary">No</span>
                        @endif
                    </td>
                    <td class="text-end">{{ $c->parts_count }}</td>
                    <td class="text-end">
                        <a href="{{ route('cars.edit',$c) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('cars.destroy',$c) }}" method="post" class="d-inline" onsubmit="return confirm('Delete car?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">No cars.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>


    {{ $cars->links('pagination::bootstrap-5') }}


@endsection
