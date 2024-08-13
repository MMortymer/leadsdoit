<?php

namespace App\Repositories;

interface TemperatureRepositoryInterface
{
    public function getDailyTemperatures(string $date);
    public function createTemperature(array $data);
}