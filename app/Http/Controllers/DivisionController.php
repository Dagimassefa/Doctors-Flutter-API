<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::all();
        return response()->json(['data' => $divisions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:divisions|max:255',
            'district_id' => 'exists:districts,id' // Ensure the district_id exists in the districts table
        ]);

        $division = Division::create($request->all());

        return response()->json(['data' => $division], 201);
    }

    public function show(Division $division)
    {
        return response()->json($division->load('thanas'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|unique:divisions,name,' . $division->id . '|max:255',
            'district_id' => 'exists:districts,id' // Ensure the district_id exists in the districts table
        ]);

        $division->update($request->all());

        return response()->json(['data' => $division]);
    }

    public function destroy(Division $division)
    {
        $division->delete();

        return response()->json(['message' => 'Division deleted successfully']);
    }
}
