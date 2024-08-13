<?php

namespace App\Repositories;

use App\Models\Temperature;

class EloquentTemperatureRepository implements TemperatureRepositoryInterface
{
    public function getDailyTemperatures(string $date)
    {
        return Temperature::whereDate('recorded_at', $date)
            ->orderBy('recorded_at')
            ->get(['temperature', 'recorded_at']);
    }

    public function createTemperature(array $data)
    {
        return Temperature::create($data);
    }
}