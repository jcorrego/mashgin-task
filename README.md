## Mashgin Developer Task

This a test project to solve a developer task.

## Backend
For the backend, we created (according to Laravel Framework standards):
- migrations, to create database tables.
- seeders and factories, to load initial data.
- models
- controllers
- routes
- requests, or validations
- api resources, for additional data transformation layer.  

Some sample routes that can be tested at any time, without any security.
- `/api/categories`
- `/api/items`
- `/api/menu`

## Frontend
For the frontend we are using Vue3 with composition Api, and Tailwindcss 
for styling. 
- Just one route needed
- Just one component created
- Two composables to import
- Axios library for API calls
- Responsive design is fully functional

## Installation
Docker compose is used to create containers for mysql and for the web app.

Make sure you have no other containers running using ports `80` and `3306`
```
docker-compose build
docker-compose up
```
Then browse to `http://localhost`

### Commands
Inside the container you could use the following commands, 
from the root of the project

To reset the DB and create initial data:  
`php artisan migrate:fresh --seed`

To compile frontend assets:  
`npm run dev` or `npm run watch` or `npm run prod`


