<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;

class CarController extends Controller
{
    public function index(Request $r)
    {
        $cars = Car::withCount('parts')
            ->when($r->filled('q'), fn($q)=>$q->where(fn($w)=>$w
                ->where('name','like','%'.$r->q.'%')
                ->orWhere('registration_number','like','%'.$r->q.'%')))
            ->when($r->has('registered') && $r->registered!=='', fn($q)=>$q->where('is_registered', (bool)$r->registered))
            ->orderBy('name')->paginate(10)->withQueryString();

        return view('cars.index', compact('cars'));
    }

    public function create() { return view('cars.create', ['car'=>new Car()]); }

    public function store(StoreCarRequest $request)
    {
        Car::create($request->validated());
        return redirect()->route('cars.index')->with('success','Car created.');
    }

    public function edit(Car $car) { return view('cars.edit', compact('car')); }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update($request->validated());
        return redirect()->route('cars.index')->with('success','Car updated.');
    }

    public function destroy(Car $car)
    {
        // ak nemáš ON DELETE CASCADE na parts.car_id, zvaž:
        // $car->parts()->delete();
        $car->delete();
        return back()->with('success','Car deleted.');
    }
}
