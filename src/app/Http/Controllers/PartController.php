<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\StorePartRequest;
use App\Http\Requests\UpdatePartRequest;

class PartController extends Controller
{
    public function index(Request $r)
    {
        $parts = Part::with('car')
            ->when($r->filled('q'), fn($q)=>$q->where(fn($w)=>$w
                ->where('name','like','%'.$r->q.'%')
                ->orWhere('serialnumber','like','%'.$r->q.'%')))
            ->when($r->filled('car_id'), fn($q)=>$q->where('car_id', $r->car_id))
            ->orderBy('name')->paginate(10)->withQueryString();

        $cars = Car::orderBy('name')->get(['id','name']);
        return view('parts.index', compact('parts','cars'));
    }

    public function create()
    {
        $cars = Car::orderBy('name')->get(['id','name','registration_number','is_registered']);
        return view('parts.create', ['part'=>new Part(),'cars'=>$cars]);
    }

    public function store(StorePartRequest $request)
    {
        Part::create($request->validated());
        return redirect()->route('parts.index')->with('success','Part created.');
    }

    public function edit(Part $part)
    {
        $cars = Car::orderBy('name')->get(['id','name','registration_number','is_registered']);
        return view('parts.edit', compact('part','cars'));
    }

    public function update(UpdatePartRequest $request, Part $part)
    {
        $part->update($request->validated());
        return redirect()->route('parts.index')->with('success','Part updated.');
    }

    public function destroy(Part $part)
    {
        $part->delete();
        return back()->with('success','Part deleted.');
    }
}
