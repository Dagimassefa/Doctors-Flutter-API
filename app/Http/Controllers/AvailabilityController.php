<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function index()
    {
        $appointments = Doctor::with('availability')->get();
        return response()->json($appointments);
    }

public function store(Request $request)
{
    $input = $request->all();

    // Check if there is any overlapping availability for the same day and time range
    $existingAvailability = Availability::where('day', $input['day'])
        ->where(function ($query) use ($input) {
            $query->whereBetween('start_time', [$input['start_time'], $input['end_time']])
                ->orWhereBetween('end_time', [$input['start_time'], $input['end_time']]);
        })
        ->first();

    if ($existingAvailability) {
        return response()->json([
            'error' => 'The selected time range is already taken for this day.'
        ], 400);
    }

    // Create the new availability if no overlapping record is found
    $appointment = Availability::create($input);

    return response()->json($appointment, 201);
}


    public function show($id)
    {
        $doctor=Doctor::findOrFail($id);
       $ava= $doctor->availability;
        return response()->json($ava);
    }

   public function update(Request $request, Availability $availability)
{
    // Check if the availability exists
    if (!$availability) {
        return response()->json(['error' => 'Availability not found'], 404);
    }

    // Update the availability
    $availability->update(array_merge($request->except('_method', '_token')));

    return response()->json($availability);
}


    public function destroy(Availability $availability)
    {
        $availability->delete();
        return response()->json(null, 204);
    }
}
