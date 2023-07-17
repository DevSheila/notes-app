# Laravel and Vue.js Notes App

This is a simple notes  application built with **Laravel** and **Vue.js**.

## Installation Guide

Follow the steps below to set up and run the project:

1. Clone the project:
   ```
   git clone https://github.com/DevSheila/notes-app
   ```

2. Navigate to the project directory:
   ```
   cd notes-app
   ```

3. Install PHP dependencies using Composer:
   ```
   composer install
   ```

4. Copy the `.env-example` file and rename it to `.env`:
   ```
   cp .env-example .env
   ```

5. Edit the `.env` file and update the database connection details:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dbname
   DB_USERNAME=myuser
   DB_PASSWORD=mypass
   ```

6. Migrate the database tables:
   ```
   php artisan migrate
   ```

7. Generate an application encryption key:
   ```
   php artisan key:generate
   ```

8. Install Node.js dependencies:
   ```
   npm install && npm run dev
   ```

9. Start the development server and test the web app:
   ```
   php artisan serve --port 8080
   ```

