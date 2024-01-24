<?php

namespace App\Http\Controllers;

use App\Models\Academic;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;

class AcademicController extends Controller
{

    use ImageUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all academic records
        $academics = Academic::where('doctor_id',auth()->user()->id)->get();

        // Return a JSON response or a view to display the academics
        return response()->json($academics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
       $validatedData = $request->validate([
    'file' => 'nullable',
    'college' => 'required',
    'degree' => 'required',
    'reg_no' => 'required|unique:academics,reg_no,NULL,id,doctor_id,' . auth()->user()->id,
    'reg_doc' => 'nullable|unique:academics,reg_doc,NULL,id,doctor_id,' . auth()->user()->id,
]);


        $file=null;
        $reg_doc=null;
        if($request->file){
            $file=$this->uploadImage($request->file);

        }

        if($request->reg_doc){
            $reg_doc=$this->uploadImage($request->reg_doc);

        }
        // Create a new academic record
        $academic = Academic::create([...$request->all(),'doctor_id'=>auth()->user()->id,
        'file'=>$file,'reg_doc'=>$reg_doc]);

        // Return a JSON response or a view to display the created academic record
        return response()->json($academic, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Academic  $academic
     * @return \Illuminate\Http\Response
     */
    public function show(Academic $academic)
    {
        // Return a JSON response or a view to display the specified academic record
        return response()->json($academic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Academic  $academic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Academic $academic)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'college' => 'required',
            'degree' => 'required',
        ]);


        if($request->file){
                    $file=$this->uploadImage($request->file);
                    $validatedData['file']=$file;
        }
        if($request->reg_doc){
                    $reg_doc=$this->uploadImage($request->reg_doc);
                    $validatedData['reg_doc']=$reg_doc;
        }
        // Create a new academic record

        // Update the academic record with the new data
        $academic->update([...$validatedData,'doctor_id'=>auth()->user()->id]);

        // Return a JSON response or a view to display the updated academic record
        return response()->json($academic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Academic  $academic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Academic $academic)
    {
        // Delete the academic record
        $academic->delete();

        // Return a JSON response or a view to indicate successful deletion
        return response()->json(['message' => 'Academic record deleted']);
    }
}
