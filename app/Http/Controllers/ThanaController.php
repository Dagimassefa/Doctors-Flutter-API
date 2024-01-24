<?php
namespace App\Http\Controllers;
use App\Models\Thana;
use App\Models\Division;
use Illuminate\Http\Request;

class ThanaController extends Controller
{
    public function index()
    {
        $thanas = Thana::with('division')->get();
        return response()->json($thanas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:thanas|max:255',
            'division_id' => 'exists:divisions,id' // Ensure the division_id exists in the divisions table
        ]);

        $thana = Thana::create($request->all());

        return response()->json($thana, 201);
    }

    public function show(Thana $thana)
    {
        $thana->load('unions');
        return response()->json($thana);
    }

    public function update(Request $request, Thana $thana)
    {
        $request->validate([
            'name' => 'required|unique:thanas,name,' . $thana->id . '|max:255',
            'division_id' => 'exists:divisions,id' // Ensure the division_id exists in the divisions table
        ]);

        $thana->update($request->all());

        return response()->json(['data' => $thana]);
    }

    public function destroy(Thana $thana)
    {
        $thana->delete();

        return response()->json(['message' => 'Thana deleted successfully']);
    }
}
