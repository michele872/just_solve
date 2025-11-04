# 💼 JustSolve - Debt Action Management App

A full-stack technical challenge project for managing **debt recovery actions**.
Built with **Laravel (backend)** and **Angular (frontend)**, fully containerized using **Docker Compose**.

---

## ⚙️ Requirements

Before starting, make sure you have:

- 🐳 **Docker** ≥ 24.x
- 🧩 **Docker Compose** ≥ 2.x
- 🟢 **Node.js** ≥ 18 (optional, only for local Angular dev)

---

## 🏗️ Project Structure

just_solve/
├── backend/ → Laravel 11 application
├── frontend/ → Angular 16 application
├── docker-compose.yml → Docker Compose configuration
└── README.md → This file

just_solve/
├── backend/ → Laravel 11 application
├── frontend/ → Angular 16 application
├── docker-compose.yml → Docker Compose configuration
└── README.md → This file

This will:

Build all required Docker images

Start the following containers:

justsolve_backend → Laravel API (port 8000)

justsolve_frontend → Angular app (port 4200)

justsolve_db → MySQL database

justsolve_phpmyadmin → phpMyAdmin UI (port 8080)

🌍 Access Points
Service	URL	Description
🖥️ Angular Frontend	http://localhost:4200
	Web UI to manage debts and actions
⚙️ Laravel API	http://localhost:8000/api
	REST API for debt management
🗄️ phpMyAdmin	http://localhost:8080
	Database admin panel
🧩 Functional Overview

Dashboard (Angular)
Displays a list of all registered debts.

Debt Detail View
Clicking on a debt shows its details and related actions.

Add New Action
You can select an action type and (optionally) provide a reason.

Data Persistence
All actions are stored via the backend API in the MySQL database.

🧱 Database Schema
debts table

Stores the main debt records (debtor, amount, due date, status).

debt_actions table

Logs all actions related to a specific debt.
Supported action types:

SEND_REMINDER

CALL_DEBTOR

ESCALATE_LEGAL

RESOLVE_DEBT

MARK_AS_IRRECOVERABLE

Each record also supports an optional reason and timestamps.

⚡ Common Docker Commands
🟢 Start containers
docker compose up --build

🟠 Stop containers
docker compose down

🔴 Remove everything (including DB data)
docker compose down -v

🧰 Access Laravel container shell
docker exec -it justsolve_backend bash

🧰 Access MySQL shell
docker exec -it justsolve_db mysql -u root -p

🧪 API Testing (Postman / cURL)
🔹 Get all debts
curl http://localhost:8000/api/debts

🔹 Get a specific debt
curl http://localhost:8000/api/debts/1

🔹 Create a new debt action
curl -X POST http://localhost:8000/api/debts/1/actions \
     -H "Content-Type: application/json" \
     -d '{
       "action": "CALL_DEBTOR",
       "reason": "Reminder call scheduled for next week."
     }'


Example response:

{
  "id": 12,
  "debt_id": 1,
  "action": "CALL_DEBTOR",
  "reason": "Reminder call scheduled for next week.",
  "created_at": "2025-11-04T20:12:00Z"
}

🧭 How to Use the App

Run docker compose up --build

Open the browser and go to:

Frontend → http://localhost:4200

Backend API → http://localhost:8000/api/debts

phpMyAdmin → http://localhost:8080

Explore the debts list

Click a debt to view and manage its actions

Add a new action (with or without a reason)

🧰 Troubleshooting
❌ Backend not responding

Check Laravel logs:

docker exec -it justsolve_backend tail -f storage/logs/laravel.log

❌ Angular not loading

View Angular logs:

docker logs -f justsolve_frontend

❌ Database connection issues

Ensure .env file in /backend matches:

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=justsolve
DB_USERNAME=root
DB_PASSWORD=root


Then run migrations manually:

docker exec -it justsolve_backend php artisan migrate --force

🧹 Full Environment Reset

To completely reset and rebuild the app from scratch:

docker compose down -v
docker compose up --build

🧑‍💻 Tech Stack
Layer	Technology
Frontend	Angular 16 + TypeScript + Material UI
Backend	Laravel 11 (PHP 8.2)
Database	MySQL 8
Containerization	Docker Compose
Admin Tool	phpMyAdmin
📂 Folder Breakdown
backend/
 ├── app/Http/Controllers/      → API controllers (Debts, Actions)
 ├── app/Models/                → Eloquent models
 ├── database/migrations/       → DB schema (debts, debt_actions)
 ├── routes/api.php             → REST API routes
 └── .env                       → Environment configuration

frontend/
 ├── src/app/components/        → Angular components
 ├── src/app/services/          → API services
 ├── src/app/models/            → Interfaces for debts/actions
 └── angular.json               → Angular CLI config

🧭 Example Flow

The Angular app loads debts via GET /api/debts

The user selects one to view details

The app sends a POST /api/debts/{id}/actions

Laravel validates and stores the action

Angular updates the list instantly

✅ Quick Start Recap
# Clone repository
git clone https://github.com/michele872/just_solve.git
cd just_solve

# Start environment
docker compose up --build

# Access the app
Frontend → http://localhost:4200
Backend → http://localhost:8000/api
phpMyAdmin → http://localhost:8080

📧 Author

Michele Magurno
📅 Last Update: November 2025
🏗️ Challenge: JustSolve Technical Interview Project
🔗 Purpose: Demonstrate a complete CRUD + workflow management app with Dockerized Laravel & Angular stack.
