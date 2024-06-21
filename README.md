# 
<h1 align="center" style="margin-top: -10px"> Simple stupid inventory system for home or small business </h1>
<p align="center" style="width: 100%;">
   <a href="https://inventory.daneke.ge/app">Demo</a>
   |
   <a href="https://t.me/+z2i6YBfa2vA2OWYy">Telegram group</a>
</p>


## How to run with Docker

**Command list**

In order to run the project with Docker you need to have Docker installed on your machine. If you don't have Docker installed you can follow the instructions on the official Docker website: https://docs.docker.com/get-docker/

The following commands will clone the repository

    git clone https://github.com/flatroy/stupid-inventory-laravel.git

Go to the project directory

    cd stupid-inventory-laravel

Copy the .env.example file to .env file with the following command or manually copy the file and rename it to .env

    cp .env.example .env

Run the following command to install the dependencies for PHP
 
    docker run --rm -it -v $PWD:/app composer:latest install --ignore-platform-req=ext-intl

Run the following command to install the dependencies for Node.js (only to build the frontend, you can skip this step if you don't want to build the frontend with Docker)

    docker run --rm -it -v $PWD:/app node:latest /bin/sh -c "cd /app && npm install -g bun && bun install && bun run build"

Run the following command to build the Docker image or if you want to use docker compose you can skip this steps

    docker build -t stupid-inventory .
    docker run -v $PWD:/app -p 4431:443 -it --rm --name my-stupid-inventory stupid-inventory 

If you want to use docker compose you can run the following command
    
    docker-compose up -d


Still some part are in WIP status: I need to add queue worker to docker-compose.yml as well as building the frontend within docker

## How to run locally (if you have PHP 8.3 and composer installed)


**Command list**

    git clone https://github.com/flatroy/stupid-inventory-laravel.git
    cd stupid-inventory-laravel
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    npm run build
    php artisan serve


## TODO list
- [x] Items - add/edit/delete/import/export
- [x] Locations - add/edit/delete
- [x] Users/Teams/Invite to team/Registration/Login - via Laravel Jetstream
- [ ] Add Dockerfile and docker-compose.yml - https://serversideup.net/open-source/docker-php/ or dunglas/frankenphp
  - [x] Add Dockerfile
  - [ ] Add docker-compose.yml
  - [ ] Add queue worker to docker-compose.yml
  - [ ] Add building frontend with docker
  - [ ] Add docker-compose.yml for production
  - [ ] Add docker-compose.yml for development
  - [ ] Add docker-compose.yml for testing
  - [ ] Add docker-compose.yml for CI/CD
  - [ ] Add mounting volumes for sqlite database file and storage
- [ ] Add more features
  - [x] Add tags to items
  - [ ] Add attachments to items - https://filamentphp.com/plugins/filament-spatie-media-library
  - [ ] Show related items in Location view - https://filamentphp.com/docs/3.x/panels/resources/relation-managers#creating-a-relation-manager
  - [ ] Add QR code to items
  - [x] Add multi-tenancy support - https://filamentphp.com/docs/3.x/panels/tenancy
    - [ ] Fix ItemImporter to support multi-tenancy with queue. Team ID is not set up correctly for now on async driver  
  - [ ] Add better import/export of items with relation to locations
    - [x] Add import of locations. if location by name not found it will create new one
    - [ ] Support labels/tags during import
    - [ ] Support attachments during import
    - [ ] Support nested path exports (e.g. `Home / Office / Desk`)
    - [ ] Support custom fields during import
  - [x] Add Laravel Octane
  - [ ] Add Laravel Pulse
  - [x] Add nice Dashboard for home-screen
  - [x] Add custom fields to items 
    - [x] Paragraph field
    - [x] Text field
    - [x] File(s) field
    - [x] Image field
  - [x] Add spotlight. Click: CTRL + K or CMD + K or CTRL + / or CMD + /


## Contributing

Thank you for choosing to contribute to the project! Any contribution is welcome.



#https://github.com/benjaminjonard/koillection/blob/1f9eb74309777e292118db899671db49ebacb395/Dockerfile.frankenphp
#https://github.com/andrewdwallo/filament-companies
# add https://github.com/awcodes/filament-table-repeater?tab=readme-ov-file for custom fileds
