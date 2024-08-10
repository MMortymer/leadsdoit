<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Temperature;

class TemperatureController extends Controller
{
    public function getDailyTemperatures(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if (!$request->user()->tokenCan('read')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'day' => 'required|date_format:Y-m-d',
        ]);

        $temperatures = Temperature::whereDate('recorded_at', $request->day)
            ->orderBy('recorded_at')
            ->get(['temperature', 'recorded_at']);

        return response()->json($temperatures);
    }
}