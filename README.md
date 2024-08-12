# Weather Microservice

## Overview

This microservice fetches and stores hourly temperature data for a specified city and provides an API to retrieve historical temperature data. It's built using the Laravel framework and runs within Docker containers.

## Features

-   Fetches temperature data hourly for a specified city (configurable via environment variables).
-   Stores temperature data in a SQLite database.
-   Provides an API endpoint to retrieve temperature data for a specific day.
-   Uses token-based authentication with Laravel Sanctum.
-   Includes Docker configuration for easy setup and deployment.
-   Runs scheduled tasks using Laravel's built-in scheduler, managed by Docker.

## Requirements

-   Docker and Docker Compose
-   PHP 8.2+ (for local development)

## Project Structure

Key files and directories:

-   `app/Console/Commands/FetchTemperature.php`: Command to fetch temperature data.
-   `app/Http/Controllers/Api/V1/TemperatureController.php`: API controller for temperature data.
-   `app/Models/User.php`: User model with custom token generation.
-   `routes/api.php`: API route definitions.
-   `routes/console.php`: Scheduled task definitions.
-   `database/migrations/`: Database migration files.
-   `Dockerfile`, `docker-compose.yml`, and `nginx/nginx.conf`: Docker configuration files.

## Setup

### Local Setup

1. Clone the repository:

    ```bash
    git clone <repository-url>
    cd weather-microservice
    ```

2. Install dependencies:

    ```bash
    composer install
    ```

3. Install npm dependencies

    ```bash
    npm install
    ```

4. Build Vite assets

    ```bash
    npm run build
    ```

5. Copy the `.env.example` file to `.env` and configure your environment variables. **Use your API key for `OPENWEATHERMAP_API_KEY`**:

    ```bash
    cp .env.example .env
    ```

6. Generate an application key:

    ```bash
    php artisan key:generate
    ```

7. Run database migrations:

    ```bash
    php artisan migrate
    ```

8. Create a user and generate an API token:

    ```bash
    php artisan db:seed
    php artisan api:token test@example.com read_token
    ```

    Make sure to save the generated token for API requests.

### Docker Setup

1. Ensure Docker and Docker Compose are installed on your system.

2. Build and start the Docker containers:

    ```bash
    docker-compose build
    ```

    ```bash
    docker-compose up -d
    ```

3. The application should now be running at `http://localhost:8000`.

4. To run commands inside the Docker container:

    ```bash
    docker-compose exec app php artisan <command>
    ```

### Running Scheduled Tasks

Scheduled tasks are handled by Laravel's scheduler, which is run continuously within a Docker service defined in `docker-compose.yml`.
The `task` service runs the scheduler, so all tasks defined in `routes/console.php` will be executed at their scheduled times.

To monitor the scheduler's output, you can check the logs of the `task` service:

```bash
docker-compose logs -f task
```

## Usage

### Fetching Temperature Data

The microservice is set up to fetch temperature data hourly. You can manually trigger a fetch using:

```
php artisan temperature:fetch
```

Or, if using Docker:

```
docker-compose exec app php artisan temperature:fetch
```

### Retrieving Temperature Data

To retrieve temperature data for a specific day, make a GET request to the `/api/v1/temperatures` endpoint with the following parameters:

-   `day`: The date for which to retrieve temperatures (format: Y-m-d)

Include your API token in the Authorization header:

```
Authorization: Bearer YOUR_API_TOKEN
```

Example curl request:

```
curl -i "http://127.0.0.1:8000/api/v1/temperatures?day=2024-08-12" -H "Authorization: Bearer YOUR_API_TOKEN"

```

## Testing

To run the test suite:

```
php artisan test
```

Or, if using Docker:

```
docker-compose exec app php artisan test
```

## Implementation Details

-   The project uses Laravel Sanctum for API authentication.
-   Custom token generation is implemented in the User model to create 32-character tokens.
-   Scheduled tasks are defined in `routes/console.php` for better organization.
-   The `FetchTemperature` command is scheduled to run hourly.
-   SQLite is used as the database for simplicity in this test task.

## Possible Improvements

1. Implement caching to reduce database queries for frequently accessed data.
2. Add more comprehensive error handling and logging.
3. Implement rate limiting on the API to prevent abuse.
4. Add unit and integration tests for better code coverage.
5. Implement a front-end dashboard for visualizing temperature data.
6. Add support for multiple cities.
7. Implement data validation and sanitization for incoming API requests.
8. Consider using a more robust database solution for production environments.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
