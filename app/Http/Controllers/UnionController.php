<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Union;
use App\Models\Thana;
use Illuminate\Http\Request;

class UnionController extends Controller
{
    public function index()
    {
        $unions = Union::with('thana')->get();
        return response()->json(['data' => $unions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:unions|max:255',
            'thana_id' => 'exists:thanas,id' // Ensure the thana_id exists in the thanas table
        ]);

        $union = Union::create($request->all());

        return response()->json(['data' => $union], 201);
    }

    public function show(Union $union)
    {
        $union->load('thana');
        return response()->json(['data' => $union]);
    }

    public function update(Request $request, Union $union)
    {
        $request->validate([
            'name' => 'required|unique:unions,name,' . $union->id . '|max:255',
            'thana_id' => 'exists:thanas,id' // Ensure the thana_id exists in the thanas table
        ]);

        $union->update($request->all());

        return response()->json(['data' => $union]);
    }

    public function destroy(Union $union)
    {
        $union->delete();

        return response()->json(['message' => 'Union deleted successfully']);
    }
}
