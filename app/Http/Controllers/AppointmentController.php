<?php
namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Availability;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{ 
    use ImageUpload;
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

  public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'patient_name' => 'required',
        'gender' => 'required',
        'age' => 'required|integer',
        'phone' => 'required',
        'clinic' => 'required',
        'clinic_address' => 'required',
        'availability_id' => 'required',
        'doctor_id' => 'required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 400);
    }

    $prescription = null;
    if ($request->hasFile('prescription')) {
        $prescription = $this->uploadImage($request->file('prescription'));
    }

    $labReport = null;
    if ($request->hasFile('lab_report')) {
        $labReport = $this->uploadImage($request->file('lab_report'));
    }

    $uploadDocs = null;
    if ($request->hasFile('upload_docs')) {
        $uploadDocs = $this->uploadImage($request->file('upload_docs'));
    }

    $availability = Availability::findOrFail($request->availability_id);

    // Generate the serial number based on the number of existing appointments
    $serialNo = $availability->appointments()->count() + 1;

    $appointmentData = array_merge($request->all(), [
        'serial_no' => $serialNo,
        'prescription' => $prescription,
        'lab_report' => $labReport,
        'upload_docs' => $uploadDocs,
        'doctor_id' => $request->input('doctor_id'),
    ]);

    $appointment = Appointment::create($appointmentData);

    return response()->json($appointment, 201);
}


    public function show($id)
    {
        $appointment = Appointment::findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'patient_name' => 'required',
            'gender' => 'required',
            'age' => 'required|integer',
            'phone' => 'required',
            'clinic' => 'required',
            'clinic_address' => 'required',
            'availability_id' => 'required|exists:availabilities,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }



        $appointment->update($request->all());
        return response()->json($appointment);
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return response()->json(null, 204);
    }

    public function getDoctorAppointments()
    {
        $appointments = Appointment::whereHas('availability', function ($query)  {
            $query->where('doctor_id', auth()->user()->id);
        })
        ->with('availability')
        ->get();

        return response()->json($appointments);
    }
    public function getDoctorAppointmentsByDay()
    {
        $appointments = Appointment::whereHas('availability', function ($query)  {
            $query->where('doctor_id', auth()->user()->id)
            ->where('day', request('day'));
        })
        ->with('availability')
        ->get();

        return response()->json($appointments);
    }

    public function getDoctorAppointmentsByDate(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $appointments = Appointment::whereHas('availability', function ($query) {
            $query->where('doctor_id', auth()->user()->id);
        })
        ->with('availability')
        ->when($startDate, function ($query) use ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query) use ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        })
        ->get();

        return response()->json($appointments);
    }
}
