---
trigger: always_on
---

# Development Instructions for SISCAP Web App

## Overview
- The App's name is SISCAP and its meant to be used in spanish
- The App is developed as a Laravel 13 web app.
- The App is meant to be used only by authorized end users whose roles are, from lowest to highest: Analista, Coordinador, Gerente

## Stack
- Frontend: Blade + Livewire + Bootstrap (4.6.1)
- Backend: PHP (version 8.3.30)
- Database: PostgresSQL (version 18) with Eloquent ORM.
- Packages: "maatwebsite/excel" version "^3.1" for exporting datasheets

## Code
- File names: kebab-case
- Method names: camelCase, in spanish
- Variable names: snake_case, in spanish
- Constant names: MACRO_CASE, in spanish
- Types and interfaces: PascalCase, in spanish
- Indentation: 5 spaces

## Arquitecture
app/Exports/  → Excel export files, namespace "App\Exports"
app/Http/Controllers/ → Manage HTTP requests
app/Livewire/ → Livewire component backend
app/Models/   → Entities, relations and validations
app/Traits/   → Shared and reused methods across classes
config/       → Global variables and application configuration
database/     → Migrations and seeders
resources/views/livewire/ → Livewire component frontend
resources/views/partials/ → Light, reusable components without livewire logic
resources/views/partials/styles.blade.php → App global styles
resources/views/partials/scripts.blade.php → App global js logic
routes/web.php → Redirects requests to controller methods

## Rules
- Follow user requests strictly and don't deviate from request 
- Code comments and documentation must be written in spanish
- Always use styles from and don't add new styles to styles.blade.php
- Use Font Awesome web application icons for all icon styling
- All HTML tags should use bootstrap classes and styles from styles.blade.php
- Don't make commits and don't push to main