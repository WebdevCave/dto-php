# Webdevcave DTO

Provides a foundation for data transfer objects in PHP applications. Built with support for `ArrayAccess`, `JsonSerializable` interfaces and hydration provided by our dependency injection container (`webdevcave/yadic`).

## Requirements

- PHP >= 8.4.1
- [Composer](https://getcomposer.org/)

## Installation

Using composer:

```bash
composer require webdevcave/dto
```

## Usage example

Extend the `DataTransferObject` class and define your properties. You can use the `from()` method to hydrate the DTO from an array.

```php
use Webdevcave\DTO\DataTransferObject;

class UserDTO extends DataTransferObject
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {}
}

// Hydrating from array
$data = ['name' => 'John Doe', 'email' => 'john@example.com'];
$user = UserDTO::from($data);

echo $user->name; // John Doe

// ArrayAccess
echo $user['email']; // john@example.com

// JSON Serialization
echo json_encode($user);
```

## Scripts

The following scripts are available via Composer:

- `composer test`: Run the tests
- `composer test-coverage`: Run the tests with coverage (requires Xdebug)
- `composer check-coverage`: Check the coverage (run test-coverage first)

## Tests

The project uses PHPUnit for testing. You can run the tests using:

```bash
composer test
```

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or a pull request on GitHub.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
