<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        
        return view('backend.user',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.user-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [ 
            'name' => 'required',
            'email' => 'required|max:255|email|unique:users,email',
            'password' => 'required',
            
            'user_type' => '',
            'user_pluck' => 'required',
            'is_she' => 'required|boolean',
            'phone_number' => 'required|string|unique:users',
            // 'pin' => 'required',
            // 'present_address' => 'required',
            // 'permanent_address' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); // Use Hash::make for password hashing
       
        $user->user_type = $request->input('user_type');
        $user->user_pluck = $request->input('user_pluck');
        $user->is_she = $request->input('is_she');
        $user->phone_number = $request->input('phone_number');
        $user->pin = $request->input('pin');
        $user->present_address = $request->input('present_address');
        $user->permanent_address = $request->input('permanent_address');

        // Upload image if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('files'), $imageName);
            $user->image = $imageName;
        }

        $user->save();
  return response()->json(['message' => 'User Registered Successfully']);
        
    }

public function login(Request $request)
{
    $request->validate([
        'phone_number' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('phone_number', $request->phone_number)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Incorrect phone number or password'], 200);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'User logged in successfully',
        'token' => $token,
        'user' => $user,
    ], 200);
}

public function getProfile()
{
    // Ensure the user is authenticated
    $user = Auth::user();

    // Return the user profile data
    return response()->json([
        'name' => $user->name,
        'phone_number' => $user->phone_number,
        'pin' => $user->pin,
        'present_address' => $user->present_address,
        'permanent_address' => $user->permanent_address,
    ]);
}
public function updateProfile(Request $request)
{
    // Ensure the request has a valid token
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Validate the incoming request
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone_number' => ['required', 'string', 'max:15'],
        'pin' => ['required', 'string'],
        'present_address' => ['required', 'string'],
        'permanent_address' => ['required', 'string'],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        // Add validation rules for other fields as needed
    ]);

    // Allow mass assignment for all fields
    $user->forceFill($request->all());

    // Update user image if provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('files'), $imageName);
        $user->image = $imageName;
    }

    $user->save();

    return response()->json(['message' => 'User profile updated successfully']);
}


 public function updatePassword(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if the old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Incorrect old password'], 400);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully'], 200);
    }
    
     public function logout(Request $request)
    {
        // Revoke the user's current token
        auth()->user()->currentAccessToken()->delete();

        // Return a response indicating the user is logged out
        return response()->json(['message' => 'Logout successful']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        //delete
        $user->delete();
        return redirect('admin/user')->with('success','User deleted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        
        
       // return view('backend.page-edit');
        return view('backend.user-edit',['user'=> $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[           
            'name' => 'required',
            'email' => 'required|max:255|email',                          
            'status' => 'required',
        ]);
   


        $user = User ::find($id);
        //input method is used to get the value of input with its
        //name specified
        $user->name = $request->input('name');
        $user->email = $request->input('email');          
        $user->status = $request->input('status');
        $user->save(); //persist the data
       
        return redirect('admin/user/'.$user->id. '/edit' )->with('success','User updated Successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        //delete
        $user->delete();
        return redirect()->route('users.index');
    }
}
