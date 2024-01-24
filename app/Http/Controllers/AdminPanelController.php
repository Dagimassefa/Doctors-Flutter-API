<?php

namespace App\Http\Controllers;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
class AdminPanelController extends Controller
{
   public function store(Request $request)
{
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|max:255|email|unique:users,email',
        'password' => 'required',
        'user_pluck' => 'required',
        'is_she' => 'required|boolean',
        'phone_number' => 'required|string|unique:users',
        'pin' => 'required',
        'present_address' => 'required',
        'permanent_address' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $user = new User();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password'));

    // Set user type to 1 for admins
    $user->user_type = 1;

    $user->user_pluck = $request->input('user_pluck');
    $user->is_she = $request->input('is_she');
    $user->phone_number = $request->input('phone_number');
    $user->pin = $request->input('pin');
    $user->present_address = $request->input('present_address');
    $user->permanent_address = $request->input('permanent_address');

    // Upload image if provided
    // if ($request->hasFile('image')) {
    //     $image = $request->file('image');
    //     $imageName = time() . '.' . $image->getClientOriginalExtension();
    //     $image->move(public_path('files'), $imageName);
    //     $user->image = $imageName;
    // }
    $image=null;
      if($request->image){
     $image = $this->uploadImage($request->image);
      }

    $user->save();

    return redirect()->route('welcome')->with('success', 'Admin Added Successfully');
}
public function login(Request $request)
{
    $request->validate([
        'phone_number' => 'required|string',
        'password' => 'required|string',
    ]);

    $user = User::where('phone_number', $request->phone_number)
                ->where('user_type', 1) // Ensure the user type is 1 for admin
                ->first();

    if (!$user) {
        return response()->json(['message' => 'Incorrect phone number and password'], 400);
    }

    $check = Hash::check($request->password, $user->password);

    if (!$check) {
        return response()->json(['message' => 'Incorrect password'], 404);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user,
    ], 200);
}
public function showUsers()
{
    $user = auth()->user();

    // Check if the user is authenticated and has user_type = 1 (admin)
    if ($user && $user->user_type === 1) {
        // Retrieve all users
        $users = User::all();

        return response()->json(['users' => $users], 200);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
}
public function deleteUser($userId)
{
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Check if the authenticated user is an admin
    $adminUser = Auth::user();

    if ($adminUser && $adminUser->user_type === 1) {
        // If the authenticated user is an admin, delete the user
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
}
public function editUser(Request $request, $userId)
{
    // Validate the request data
    $this->validate($request, [
        'name' => 'required',
        'email' => 'required|max:255|email|unique:users,email,' . $userId,
        'user_pluck' => 'required',
        'is_she' => 'required|boolean',
        'phone_number' => 'required|string|unique:users,phone_number,' . $userId,
        'pin' => 'required',
        'present_address' => 'required',
        'permanent_address' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Check if the authenticated user is an admin or the user being edited
    $loggedInUser = Auth::user();

    if (!$loggedInUser || ($loggedInUser->user_type !== 1 && $loggedInUser->id != $userId)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Find the user to edit
    $user = User::find($userId);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Update user attributes
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->user_pluck = $request->input('user_pluck');
    $user->is_she = $request->input('is_she');
    $user->phone_number = $request->input('phone_number');
    $user->pin = $request->input('pin');
    $user->present_address = $request->input('present_address');
    $user->permanent_address = $request->input('permanent_address');

    // Upload image if provided
  $image=null;
      if($request->image){
     $image = $this->uploadImage($request->image);
      }

    // Save the changes
    $user->save();

    return response()->json(['message' => 'User updated successfully'], 200);
}
public function filterDoctors($zoneIds)
{
    $zoneIds = explode(',', $zoneIds);

    $doctors = Doctor::when($zoneIds, function ($query) use ($zoneIds) {
        $query->whereIn('zone_id', $zoneIds);
    })->get();

    return response()->json(['doctors' => $doctors], 200);
}
public function filterDoctorsWithRegion($regionIds)
{
    $regionIds = explode(',', $regionIds);

    $doctors = Doctor::when($regionIds, function ($query) use ($regionIds) {
        $query->whereIn('region_id', $regionIds);
    })->get();

    return response()->json(['doctors' => $doctors], 200);
}
public function filterDoctorsByName(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
        ]);

        $name = $request->input('name');

        $doctors = Doctor::where('first_name', 'like', '%' . $name . '%')
            ->orWhere('last_name', 'like', '%' . $name . '%')
            ->get();

        return response()->json(['doctors' => $doctors], 200);
    }
     public function filterDoctorsBySpecialization(Request $request)
    {
        $request->validate([
            'specialization' => 'string|required',
        ]);

        $specialization = $request->input('specialization');

        $doctors = Doctor::where('specialist', 'like', '%' . $specialization . '%')
            ->get();

        return response()->json(['doctors' => $doctors], 200);
    }
public function filterDoctorsWithRegionAndZone($regionIds, $zoneIds)
{
    $regionIds = explode(',', $regionIds);
    $zoneIds = explode(',', $zoneIds);

    $doctors = Doctor::when($regionIds, function ($query) use ($regionIds) {
        $query->whereIn('region_id', $regionIds);
    })->when($zoneIds, function ($query) use ($zoneIds) {
        $query->whereIn('zone_id', $zoneIds);
    })->get();

    return response()->json(['doctors' => $doctors], 200);
}






}
