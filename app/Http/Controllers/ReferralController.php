<?php

namespace App\Http\Controllers;

use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function delete(Referral $referral)
    {
        $referral->delete();

        return response()->json(null, 204);
    }
}
