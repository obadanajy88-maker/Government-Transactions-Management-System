# Electronic Transactions Management System

A modern web application for managing electronic transactions with role-based access for citizens, employees, and managers. The project is built with Laravel 12, Inertia.js, React, Tailwind CSS, and SQLite.

## Overview

This system allows users to:

- register and sign in securely
- submit new transactions with attachments
- track transaction status
- process transactions for staff members
- manage workflow between different roles

## Features

- Authentication and authorization
- Citizen transaction submission
- Employee/manager transaction processing
- Attachment upload support
- Arabic-friendly UI
- Responsive dashboard experience

## Tech Stack

- Backend: Laravel 12
- Frontend: React + Inertia.js
- Styling: Tailwind CSS
- Database: SQLite (default)
- Testing: Pest

## Requirements

Before running the project, make sure you have installed:

- PHP 8.2+
- Composer
- Node.js 18+
- npm

## Installation

1. Clone the repository
   ```bash
   git clone <your-repo-url>
   cd obadaahmedproject
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install JavaScript dependencies
   ```bash
   npm install
   ```

4. Copy the environment file
   ```bash
   copy .env.example .env
   ```

5. Generate the application key
   ```bash
   php artisan key:generate
   ```

6. Run database migrations
   ```bash
   php artisan migrate
   ```

## Running the Application

Start the development servers:

```bash
composer run dev
```

This will launch:

- Laravel development server
- Vite frontend build pipeline
- queue worker

Then open your browser at:

```text
http://localhost:8000
```

## Testing

Run the test suite with:

```bash
php artisan test
```

## Project Structure

- app/ - Laravel application logic
- resources/ - React/Inertia frontend and Blade views
- routes/ - Web and API routes
- database/ - Migrations and seeders
- tests/ - Pest test cases

## License

This project is open-source and available under the MIT License.
