<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    public function delete(FollowUp $followUp)
    {
        $followUp->delete();

        return response()->json(null, 204);
    }
}
