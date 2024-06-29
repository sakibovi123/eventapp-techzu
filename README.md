# Event Reminder App

This is a Laravel application for managing event reminders with various notification types and CSV data import functionality.

## Features

- CRUD operations for event management: create, read, update, delete events.
- Three types of event reminders:
  1. Notification when an event is posted, sent to all users via email.
  2. Notification when an event is about to start, sent as "Event is starting soon" email.
  3. Notification when an event is ending soon, sent 10 minutes before the event ends.

## Installation

To run the project locally, follow these steps:

1. Clone the repository from GitHub:
   ```
   git clone https://github.com/sakibovi123/eventapp-techzu.git
   ```

2. Rename `.envexample` file to `.env`.

3. Install PHP dependencies using Composer:
   ```
   composer install
   ```

4. Generate application key:
   ```
   php artisan key:generate
   ```

5. Run database migrations to create necessary tables:
   ```
   php artisan migrate
   ```

6. Serve the application:
   ```
   php artisan serve
   ```
   If you want to specify a port (e.g., port 8000), run:
   ```
   php artisan serve --port=8000
   ```

7. Start the queue listener for handling queued jobs (for email notifications):
   ```
   php artisan queue:listen
   ```

## Usage

- Access the application in your web browser at `http://localhost:8000` (or the port you specified).
- Use the application to create, view, update, and delete events.
- Events are automatically notified to users based on their type (posted, starting soon, ending soon).
- Import event data from CSV files using the integrated functionality with `maatwebsite/excel` library.

---


## Docker Setup
To run the project using Docker, follow these steps:

Clone the repository from GitHub:

bash
Copy code
git clone https://github.com/sakibovi123/eventapp-techzu.git
cd eventapp-techzu
Rename .envexample file to .env.

Start Docker containers:

## bash
Copy code
vendor\bin\sail up -d
Install PHP dependencies:

## bash
Copy code
vendor\bin\sail composer install
Generate application key:

## bash
Copy code
vendor\bin\sail artisan key:generate
Run database migrations:

## bash
Copy code
vendor\bin\sail artisan migrate
Access the application in your web browser at http://localhost:8000 (or the appropriate port if configured differently).
