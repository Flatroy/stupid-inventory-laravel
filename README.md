# 
<h1 align="center" style="margin-top: -10px"> Simple stupid inventory system for home or small business </h1>
<p align="center" style="width: 100%;">
   <a href="https://inventory.daneke.ge/app">Demo</a>
   |
   <a href="https://t.me/+z2i6YBfa2vA2OWYy">Telegram group</a>
</p>


## How to run with Docker (pre-built image)

A pre-built Docker image is published to GitHub Container Registry on every push to `main` and on version tags. This is the fastest way to run the app.

**Prerequisites:** [Docker](https://docs.docker.com/get-docker/) installed on your machine.

### Quick start

Pull and run the latest image:

    docker run -d \
      --name stupid-inventory \
      -p 801:80 \
      -v stupid-inventory-storage:/app/storage \
      -v stupid-inventory-db:/app/database \
      ghcr.io/flatroy/stupid-inventory-laravel:latest

Then open http://localhost:801 in your browser.

### Creating your first user

After starting the container, create an admin user with the built-in command:

    docker exec -it stupid-inventory php artisan app:create-user

This prompts you for a name, email, and password interactively. The command also creates a personal team for the user automatically.

You can also pass all values non-interactively (useful for scripts and CI):

    docker exec stupid-inventory php artisan app:create-user \
      --name="Admin User" \
      --email="admin@example.com" \
      --password="secure-password" \
      --team="My Home" \
      --no-interaction

Then log in at http://localhost:801/app/login with the credentials you set.

### What the image does on startup

The entrypoint script automatically:
- Generates the application key
- Runs database migrations
- Caches config, routes, and views
- Publishes Filament assets

### Persistent data

The example above uses two named volumes to persist data across container restarts:
- `stupid-inventory-storage` — uploaded files, logs, framework cache
- `stupid-inventory-db` — SQLite database file

### Using an external database (MySQL)

To use MySQL instead of the default SQLite, pass the database environment variables:

    docker run -d \
      --name stupid-inventory \
      -p 801:80 \
      -v stupid-inventory-storage:/app/storage \
      -e DB_CONNECTION=mysql \
      -e DB_HOST=your-mysql-host \
      -e DB_PORT=3306 \
      -e DB_DATABASE=inventory \
      -e DB_USERNAME=root \
      -e DB_PASSWORD=secret \
      ghcr.io/flatroy/stupid-inventory-laravel:latest

### Available image tags

| Tag | Description |
|-----|-------------|
| `latest` | Latest build from `main` branch |
| `v1.0.0` | Specific version (Git tag) |
| `1.0` | Major.minor version |
| `1` | Major version |

### Using docker-compose with the pre-built image

Create a `docker-compose.yml`:

    services:
      app:
        image: ghcr.io/flatroy/stupid-inventory-laravel:latest
        ports:
          - "801:80"
        volumes:
          - stupid-inventory-storage:/app/storage
          - stupid-inventory-db:/app/database
        restart: unless-stopped

    volumes:
      stupid-inventory-storage:
      stupid-inventory-db:

Then run:

    docker compose up -d


## How to build and run with Docker (from source)

If you want to build the image yourself from the source code:

    git clone https://github.com/flatroy/stupid-inventory-laravel.git
    cd stupid-inventory-laravel

    docker build -t stupid-inventory .

    docker run -d \
      --name stupid-inventory \
      -p 801:80 \
      -v stupid-inventory-storage:/app/storage \
      -v stupid-inventory-db:/app/database \
      stupid-inventory

Or use the included `docker-compose.yml` for local development with volume mounting:

    docker compose up -d

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

Then create your first user:

    php artisan app:create-user

Or non-interactively:

    php artisan app:create-user --name="Admin" --email="admin@example.com" --password="password" --no-interaction


## TODO list
- [x] Items - add/edit/delete/import/export
- [x] Locations - add/edit/delete
- [x] Users/Teams/Invite to team/Registration/Login - via Laravel Jetstream
- [x] Add Dockerfile and docker-compose.yml - https://serversideup.net/open-source/docker-php/ or dunglas/frankenphp
  - [x] Add Dockerfile (multi-stage build with frontend assets)
  - [x] Add docker-compose.yml
  - [x] Add ability to build frontend with docker
  - [x] Add CI/CD pipeline to build and publish Docker image to ghcr.io
  - [ ] Add queue worker to docker-compose.yml
  - [ ] Add docker-compose.yml for production, development, testing
  - [x] Add mounting volumes for sqlite database file/or mysql connection and storage
  - [x] Add tags to items
  - [ ] Add attachments to items - https://filamentphp.com/plugins/filament-spatie-media-library (for now we have custom field for files and images)
  - [x] Show related items in Location and Tag pages
  - [x] Add QR code to items
  - [x] Add multi-tenancy support - https://filamentphp.com/docs/3.x/panels/tenancy
    - [ ] Fix ItemImporter to support multi-tenancy with queue. Team ID is not set up correctly for now on async driver  
  - [x] Add better import/export of items with relation to locations
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
  - [x] Add Label Generator
  - [ ] Add REST API
  - [ ] Add backup  [via spatie package](https://github.com/shuvroroy/filament-spatie-laravel-backu)
  - [ ] add https://github.com/CodeWithDennis/filament-select-tree
 

## Contributing

Thank you for choosing to contribute to the project! Any contribution is welcome.


