# PetShop

Backend Development Task for Buckhill recruitment, by Irman Ahmad

## Getting Started

Follow these steps to set up the application and run it locally.

### 1. Install Dependencies

Use the `composer install` command to install the required PHP dependencies.

### 2. Configure Application

- Copy the `.env.example` file and rename it as `.env` to set up the application environment variables.
- Use the `php artisan key:generate` command to generate a unique application key.

### 3. Set Up Database and Migrate

- Create a MySQL database for the application. The default database name is `petshop`, but you can change it in
  the `.env` file if needed.
- Use the `php artisan migrate:fresh --seed` command to create and populate the database tables with some sample data.

### 4. Verify Functionality

- Use the `php artisan test` command to run all the tests and confirm that the application is working as expected.

### 5. Swagger Documentation

The API documentation for the application is available in the `api-docs.yaml` file in the public directory.

To view the Swagger documentation in a browser, visit: `{L5_SWAGGER_CONST_HOST}/api/documentation`.
