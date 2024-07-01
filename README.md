# Package Manager

Package Manager that manages items and selects the best and smallest box among the list. Requires PHP 8.2.

## Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop)

## Getting Started

1. **Clone the repository:**
```bash
git clone https://github.com/chardrreyes/laravel-package-manager.git
cd laravel-package-manager
```

2. **Build and start the Docker container:**
```bash
docker-compose up -d --build
```

3. **Install PHP dependencies:**
```bash
docker-compose exec app composer install
```

4. **Generate application key:**
```bash
docker-compose exec app php artisan key:generate
```
    
5. **Initialize migration:**
```bash
docker-compose exec app php artisan migrate
```
## Running Test
```bash
docker-compose exec app php artisan test
```

## Alternative
Required
- [Composer](https://getcomposer.org/download/)
- [PostgreSQL](https://www.postgresql.org/download/windows/)
- [Latest PHP](https://www.php.net/)

1. **Install composer and run this commands**
```bash
php artisan key:generate
php artisan migrate
php artisan serve
```
2. Testing
```bash
php artisan test
```



