## Mashgin Developer Task
![Screen Shot 2022-01-24 at 2 50 08 AM](https://user-images.githubusercontent.com/2152949/150742465-b0d12fb5-921b-4867-a6bf-fd690501bf6e.png)

This a test project to solve a developer task.

## Backend
For the backend, i created (according to Laravel Framework standards):
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
For the frontend i am using Vue3 with composition Api, and Tailwindcss 
for styling. 
- Just one route needed
- Just one component created
- Two composables to import
- Axios library for API calls
- Responsive design is fully functional

## Installation
- Clone this repo into a local folder
- Copy file `.env.example` to `.env`  
- cd into the folder
- Install composer dependencies, using `composer install` 
or if you dont have composer installed, you can use this command to use 
a simple container to run the command.
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Docker compose is used to create containers for mysql and for the web app.
Make sure you have no other containers running using ports `80` and `3306` and run:
```
docker-compose build
docker-compose up
```

To create the initial data in the database, once the containers are running,
you can run this command replacing `mashgin_laravel_1` with the correct container 
name from your machine.
```
docker exec mashgin_laravel_1 php artisan migrate:fresh --seed
```
Or, you can login into the container and run
```
php artisan migrate:fresh --seed
```

Then browse to `http://localhost`

### Commands
Inside the container you could use the following commands, 
from the root of the project

To reset the DB and create initial data:  
`php artisan migrate:fresh --seed`

To compile frontend assets:  
`npm run dev` or `npm run watch` or `npm run prod`


