<?php

namespace Tests\Feature;

use App\Models\Temperature;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchTemperatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the temperature fetch command with a successful API response.
     */
    public function test_temperature_fetch_command_success()
    {
        // Mock a successful API response
        Http::fake([
            'api.openweathermap.org/*' => Http::response([
                'main' => [
                    'temp' => 25.5,
                ],
            ], 200)
        ]);

        // Run the artisan command
        Artisan::call('temperature:fetch');

        // Assert that the temperature was recorded in the database
        $this->assertDatabaseHas('temperatures', [
            'city' => config('services.openweathermap.city', 'Kyiv'),
            'temperature' => 25.5,
        ]);

        // Assert that the output contains the expected success message
        $output = Artisan::output();
        $this->assertStringContainsString('Temperature recorded for', $output);
    }

    /**
     * Test the temperature fetch command with a failed API response.
     */
    public function test_temperature_fetch_command_failure()
    {
        // Mock a failed API response
        Http::fake([
            'api.openweathermap.org/*' => Http::response(null, 500)
        ]);

        // Run the artisan command
        Artisan::call('temperature:fetch');

        // Assert that no temperature was recorded in the database
        $this->assertDatabaseMissing('temperatures', [
            'city' => config('services.openweathermap.city', 'Kyiv'),
        ]);

        // Assert that the output contains the expected error message
        $output = Artisan::output();
        $this->assertStringContainsString('Failed to fetch temperature data', $output);
    }
}
