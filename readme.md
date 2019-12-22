# NBH task API

Built in Lumen
## Getting Started

First, clone the repository and cd into it:

```bash
git clone https://github.com/sultansagi/nbh-backend
cd nbh-backend
```

Next, update and install with composer:

```bash
composer update --no-scripts
composer install
```

Next, create a database.sqlite file:

```bash
touch database.sqlite
cp .env.example .env
```

Lastly, run the following command to migrate your database using the credentials:

```bash
php artisan migrate
```

Generate your API secret:
```bash
php artisan jwt:secret
```

Also we can check PHPUnit tests, by running:
```bash
vendor/bin/phpunit
```

You should now be able to start the server using `php artisan serve` and go to http://localhost:8000 to view the app!

Visit http://localhost:8000. Success!

## Contributing

Feel free to contribute to anything.