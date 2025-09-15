# Fizz-Buzz API

A Laravel-based REST API that generates customizable FizzBuzz sequences and tracks usage statistics. This project implements a flexible FizzBuzz algorithm where you can specify custom integers and replacement strings, along with comprehensive request tracking and analytics.

## Features

- **Customizable FizzBuzz Generation**: Generate sequences with custom integers and replacement strings
- **Request Statistics**: Track and analyze the most frequently used parameter combinations
- **RESTful API**: Clean, well-documented API endpoints
- **Input Validation**: Comprehensive validation with detailed error messages
- **Docker Support**: Easy development setup with Docker Compose
- **Testing**: Full test coverage with PHPUnit
- **Laravel Best Practices**: Clean architecture with services, interfaces, and actions

## Requirements

- PHP 8.2 or higher
- Composer
- MySQL 8.0 (or use Docker)
- Node.js and NPM (for frontend assets)

## Installation

### Using Docker (Recommended)

1. Clone the repository:
```bash
git clone <repository-url>
cd fizz_buzz
```

2. Copy the environment file:
```bash
cp .env.example .env
```

3. Start the application with Docker:
```bash
docker compose -f compose.dev.yaml up --build
```

4. Install dependencies and run migrations:
```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```

## API Endpoints

### Generate FizzBuzz Sequence

**GET** `/api/fizzbuzz`

Generates a FizzBuzz sequence based on the provided parameters.

#### Parameters

| Parameter | Type | Required | Description | Constraints |
|-----------|------|----------|-------------|-------------|
| `int1` | integer | Yes | First integer for FizzBuzz logic | 1-5000, different from int2, ≤ limit |
| `int2` | integer | Yes | Second integer for FizzBuzz logic | 1-5000, ≤ limit |
| `limit` | integer | Yes | Upper limit for the sequence | 1-5000 |
| `str1` | string | Yes | String to display for multiples of int1 | Max 15 characters |
| `str2` | string | Yes | String to display for multiples of int2 | Max 15 characters |

#### Example Request

```bash
curl "http://localhost:8000/api/fizzbuzz?int1=3&int2=5&limit=15&str1=fizz&str2=buzz"
```

#### Example Response

```json
{
    "result": "1,2,fizz,4,buzz,fizz,7,8,fizz,buzz,11,fizz,13,14,fizzbuzz"
}
```

### Get Statistics

**GET** `/api/fizzbuzz/stats`

Returns the most frequently used parameter combination.

#### Example Response

```json
{
    "result": {
        "parameters": {
            "int1": 3,
            "int2": 5,
            "limit": 100,
            "str1": "fizz",
            "str2": "buzz"
        },
        "hits": 42
    }
}
```

## API Documentation (Swagger)

The API includes comprehensive Swagger/OpenAPI documentation that provides an interactive interface for exploring and testing the endpoints.

### Accessing the Documentation

- **Swagger UI**: `http://localhost:8000/api/spec` - Interactive web interface
- **OpenAPI JSON**: `http://localhost:8000/api/spec-json` - Raw JSON specification

### Features

- **Interactive Testing**: Test API endpoints directly from the browser
- **Request/Response Examples**: See example requests and responses for each endpoint
- **Parameter Validation**: Understand required parameters and their constraints
- **Schema Documentation**: View detailed data models and validation rules

### Setup for Development

If you're setting up the project from scratch, the Swagger documentation will be automatically available.
After any documentation update, you just need to run:

```bash
docker compose -f compose.dev.yaml exec workspace php artisan l5-swagger:generate
```

The documentation is automatically updated when you run the generate command, so you can refresh the Swagger UI to see the latest changes.

## How It Works

The Fizz-Buzz algorithm works as follows:

1. For each number from 1 to the specified limit:
   - If the number is divisible by `int1`, append `str1` to the output
   - If the number is divisible by `int2`, append `str2` to the output
   - If the number is divisible by both `int1` and `int2`, append both strings
   - If the number is not divisible by either, use the number itself

2. Each request is automatically tracked in the database for statistics

## Testing

Run the test suite:

```bash
docker compose -f compose.dev.yaml exec workspace php artisan test
```

The project includes:
- **Unit Tests**: Test individual service methods
- **Feature Tests**: Test API endpoints and integration

## For Production

```bash
docker compose -f compose.prod.yaml up --build -d
```

### Code Quality

The project follows Laravel best practices:
- **SOLID Principles**: Clean separation of concerns
- **Dependency Injection**: Services injected via interfaces
- **Action Pattern**: Single-purpose action classes
- **Form Requests**: Dedicated validation classes
- **Service Layer**: Business logic separated from controllers

## Database Schema

The application uses a single table `fizzbuzz_request_stats` to track usage:

```sql
CREATE TABLE fizzbuzz_request_stats (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    int1 INT UNSIGNED,
    int2 INT UNSIGNED,
    limit INT UNSIGNED,
    str1 VARCHAR(15),
    str2 VARCHAR(15),
    hits BIGINT UNSIGNED DEFAULT 0,
    PRIMARY KEY fbrs_pk (int1, int2, limit, str1, str2),
    INDEX (hits)
);
```

## Error Handling

The API provides detailed error responses for validation failures:

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "int1": ["int1 and int2 must be different."],
        "limit": ["The limit field is required."]
    }
}
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass
6. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
