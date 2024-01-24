<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Referral;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{

    public function index()
    {
        $prescription=Prescription::with('appointment', 'doctor', 'referrals', 'medicines', 'follow_ups')->get();

        return response()->json($prescription);
    }

    public function store(Request $request)
    {
        $prescription = Prescription::create($request->all());

        if ($request->has('referrals')) {
            $referralData = $request->input('referrals');
            $prescription->referrals()->createMany($referralData);
        }

        if ($request->has('medicines')) {
            $medicinesData = $request->input('medicines');
            $prescription->medicines()->createMany($medicinesData);
        }

        if ($request->has('follow_ups')) {
            $followUpsData = $request->input('follow_ups');
            $prescription->follow_ups()->createMany($followUpsData);
        }

        return response()->json($prescription, 201);
    }

    public function show(Prescription $prescription)
    {
        $prescription->load('appointment', 'doctor', 'patient', 'referral', 'medicines', 'followUps');

        return response()->json($prescription);
    }

    public function update(Request $request, Prescription $prescription)
    {
        $prescription->update($request->all());

        if ($request->has('referral')) {
            $referralData = $request->input('referral');
            $prescription->referral()->updateOrCreate([], $referralData);
        } else {
            $prescription->referral()->delete();
        }

        if ($request->has('medicines')) {
            $medicinesData = $request->input('medicines');
            $prescription->medicines()->delete();
            $prescription->medicines()->createMany($medicinesData);
        } else {
            $prescription->medicines()->delete();
        }

        if ($request->has('follow_ups')) {
            $followUpsData = $request->input('follow_ups');
            $prescription->followUps()->delete();
            $prescription->followUps()->createMany($followUpsData);
        } else {
            $prescription->followUps()->delete();
        }

        return response()->json($prescription);
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->referral()->delete();
        $prescription->medicines()->delete();
        $prescription->followUps()->delete();
        $prescription->delete();

        return response()->json(null, 204);
    }
}
