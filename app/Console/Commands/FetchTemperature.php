<?php

namespace App\Console\Commands;

use App\Models\Temperature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchTemperature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temperature:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch current temperature for the specified city';

    /**
     * Execute the console command.
     */
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
            Temperature::create([
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
