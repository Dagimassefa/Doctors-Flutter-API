<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Traits\ImageUpload;

use Illuminate\Support\Str;
class SpecializationController extends Controller
{
  public function create(Request $request)
{
     $request->validate([
        'name' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'doctor_id' => 'required|exists:doctors,id',
    ]);

    $specialization = new Specialization();
    $specialization->name = $request->input('name');
    $specialization->doctor_id = $request->input('doctor_id');

    if ($request->image) {
    $image = $this->uploadImage($request->image);
    $specialization->image = $image;
}

    $specialization->save();

    return response()->json($specialization, 201);
}
public function uploadImage($file)
{
    try {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            $imageName = Str::uuid()->toString() . '.' . $file->extension();
            // Public Folder
            $file->move(public_path('files'), $imageName);
            return $imageName;
        }
        return null; // Or handle the case when $file is not an instance of UploadedFile
    } catch (\Throwable $th) {
        throw $th;
    }
}
public function getSpecialization()
    {
        $specializations = Specialization::all();

        return response()->json($specializations, 200);
    }

}
