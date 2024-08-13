<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Temperature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TemperatureRepositoryInterface;

class TemperatureController extends Controller
{
    private $temperatureRepository;

    public function __construct(TemperatureRepositoryInterface $temperatureRepository)
    {
        $this->temperatureRepository = $temperatureRepository;
    }
    
    public function getDailyTemperatures(Request $request)
    {
        $request->validate([
            'day' => 'required|date_format:Y-m-d',
        ]);

        $temperatures = $this->temperatureRepository->getDailyTemperatures($request->day);

        return response()->json($temperatures);
    }
}