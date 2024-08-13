<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Repositories\TemperatureRepositoryInterface;

class FetchTemperature extends Command
{
    protected $signature = 'temperature:fetch';
    protected $description = 'Fetch current temperature for the specified city';

    private $temperatureRepository;

    public function __construct(TemperatureRepositoryInterface $temperatureRepository)
    {
        parent::__construct();
        $this->temperatureRepository = $temperatureRepository;
    }

    public function handle()
    {
        $city = config('services.openweathermap.city', 'Kyiv');
        $apiKey = config('services.openweathermap.key');
        
        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->temperatureRepository->createTemperature([
                'city' => $city,
                'temperature' => $data['main']['temp'],
                'recorded_at' => now(),
            ]);
            $this->info("Temperature recorded for $city");
        } else {
            $this->error('Failed to fetch temperature data');
        }
    }
}