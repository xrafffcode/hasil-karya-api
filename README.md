## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/xrafffcode/hasil-karya-api
   ```

2. Navigate to the project directory:
   ```bash
   cd hasil-karya-api
   ```

3. Install dependencies
   ```bash
   composer install
   ```

4. Copy the .env.example file to .env and configure the database connection
   ```bash
   cp .env.example .env
   ```

5. Generate application key
   ```bash
   php artisan key:generate
   ```

6. Run database migrations and seeders
   ```bash
   php artisan migrate --seed
   ```

7. Start the development serve
   ```bash
   php artisan serve
   ```

## Creating API
```bash
php artisan make:api Name
``

