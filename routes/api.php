<?php

use App\Http\Controllers\AcademicController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DivisionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorForgotPasswordController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ThanaController;
use App\Http\Controllers\UnionController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\HealthProfileController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\LabRegistrationController;
use App\Http\Controllers\BookedDiagnosticTestsController;

use App\Http\Controllers\AmbulanceController;
use App\Http\Controllers\SacmoController;
use App\Http\Controllers\BloodDonorController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('userProfile', 'userProfile');
});


Route::apiResource('zones', ZoneController::class);
Route::apiResource('regions', RegionController::class);
Route::apiResource('branches', BranchController::class);
Route::apiResource('districts', DistrictController::class);
Route::apiResource('divisions', DivisionController::class);
Route::apiResource('thanas', ThanaController::class);
Route::apiResource('unions', UnionController::class);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [DoctorController::class, 'getProfile']);
    Route::put('/profile', [DoctorController::class, 'updateProfile']);
    Route::put('/update-password', [DoctorController::class, 'updatePassword']);
    Route::post('/logout', [DoctorController::class, 'logout']);
    Route::post('/doctors/{doctorId}/certificates', [DoctorController::class, 'createCertificate']);
    Route::get('/doctors/{doctorId}/certificates', [DoctorController::class, 'listCertificates']);
    Route::get('/doctor/appointments', [AppointmentController::class, 'getDoctorAppointments']);
    Route::get('/doctor/day_appointments', [AppointmentController::class, 'getDoctorAppointmentsByDay']);
    Route::get('/doctor/date_appointments', [AppointmentController::class, 'getDoctorAppointmentsByDate']);

    Route::apiResource('academics', AcademicController::class);
    Route::apiResource('availabilities', AvailabilityController::class);
    Route::apiResource('appointments', AppointmentController::class);



    Route::apiResource('prescriptions', PrescriptionController::class);
    Route::apiResource('medicines', MedicineController::class);
    Route::delete('medicines/{medicine}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
    Route::apiResource('follow-ups', FollowUpController::class);
    // Route::delete('follow-ups/{followUp}', [FollowUpController::class, 'destroy'])->name('follow-ups.destroy');
    Route::apiResource('referrals', ReferralController::class);
    Route::delete('referrals/{referral}', [ReferralController::class, 'destroy'])->name('referrals.destroy');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/admin/doctors', [AdminDoctorController::class, 'index']);
        // Route::get('/admin/users', [AdminUserController::class, 'index']);
    });
});
Route::get('/doctor/{id}/availabilities', [AvailabilityController::class, 'show']);
// In your routes file
Route::post('/doctor/availabilities', [AvailabilityController::class, 'store'])->name('doctor.availabilities.store');



//admin


// Route::get('/about-us', [AboutUsController::class, 'index']);
// Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::post('/register-doctor', [DoctorController::class, 'register']);
Route::post('/login-doctor', [DoctorController::class, 'login']);
Route::post('doctor/forgot-password', [DoctorForgotPasswordController::class, 'forgotPassword']);
Route::post('doctor/reset-password', [DoctorForgotPasswordController::class, 'reset'])->name('password.reset');



Route::post('/users', [UserController::class, 'store'])->name('user.store');
Route::post('/users/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->get('/users/profile', [UserController::class, 'getProfile']);
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/users/profile', [UserController::class, 'updateProfile']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/users/update-password', [UserController::class, 'updatePassword']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users/logout', [UserController::class, 'logout']);
});



Route::post('/admin/register', [AdminPanelController::class, 'store']);
Route::post('/admin/login', [AdminPanelController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/admin/users/{userId}', [AdminPanelController::class, 'deleteUser']);
    });
Route::middleware('auth:sanctum')->group(function () {
Route::get('/admin/userslist', [AdminPanelController::class, 'showUsers']);
 });
 Route::middleware('auth:sanctum')->group(function () {
    Route::put('/admin/editusers/{userId}', [AdminPanelController::class, 'editUser']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/filter-doctors/{zoneIds}', [AdminPanelController::class, 'filterDoctors']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/filter-doctors-with-region/{regionIds}', [AdminPanelController::class, 'filterDoctorsWithRegion']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/admin/filter-doctors-with-region-and-zone/{regionIds}/{zoneIds}', [AdminPanelController::class, 'filterDoctorsWithRegionAndZone']);
});
Route::get('/filter-doctors-by-name', [AdminPanelController::class, 'filterDoctorsByName']);
Route::get('/filter-doctors-by-specialization', [AdminPanelController::class, 'filterDoctorsBySpecialization']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/lab-registration', [LabRegistrationController::class, 'store']);
    Route::put('/lab-registration/{labRegistrationId}', [LabRegistrationController::class, 'edit']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/Book-New-Diagnostic-Test', [BookedDiagnosticTestsController::class, 'store']);
       Route::put('/booked-diagnostic-test/{bookedDiagnosticTestId}', [BookedDiagnosticTestsController::class, 'edit']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/health-profiles', [HealthProfileController::class, 'store']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::put('/edit-health-profiles/{healthProfileId}', [HealthProfileController::class, 'editHealthProfile']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/medicines', [MedicineController::class, 'getAllMedicines']);
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/patients/{userId}/family-members', [FamilyMemberController::class, 'addFamilyMember']);
    Route::put('/family-members/{familyMemberId}', [FamilyMemberController::class, 'editFamilyMember']);
});

Route::post('/specializations', [SpecializationController::class, 'create']);
Route::get('/specializations', [SpecializationController::class, 'getSpecialization']);

// ambulance api
Route::get('/ambulances', [AmbulanceController::class, 'getAllAmbulances']);
Route::get('/ambulances/by-region/{region_id}', [AmbulanceController::class, 'getByRegion']);
Route::get('/ambulances/by-zone/{zone_id}', [AmbulanceController::class, 'getByZone']);
Route::get('/ambulances/by-branch/{branch_id}', [AmbulanceController::class, 'getByBranch']);
//sacmo api 
Route::get('/sacmos', [SacmoController::class, 'index']);
Route::get('/sacmos/{id}', [SacmoController::class, 'show']);
Route::get('/sacmos/by-district/{district_id}', [SacmoController::class, 'getByDistrict']);
// blood donor 
Route::get('/blood_donors/by-region/{regionId}', [BloodDonorController::class, 'getByRegion']);
Route::get('/blood_donors/by-zone/{zoneId}', [BloodDonorController::class, 'getByZone']);
Route::get('/blood_donors/by-branch/{branchId}', [BloodDonorController::class, 'getByBranch']);

//search doctors based on timeslot 
Route::get('/get-doctors-by-time', [DoctorController::class, 'getDoctorsByTime']);



