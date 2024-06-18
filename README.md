# 
<h1 align="center" style="margin-top: -10px"> Simple stupid inventory system for home or small business </h1>
<p align="center" style="width: 100%;">
   <a href="https://inventory.daneke.ge/app">Demo</a>
   |
   <a href="https://t.me/+z2i6YBfa2vA2OWYy">Telegram group</a>
</p>


## How to run locally if you have PHP 8.3 and composer installed


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

## How to run with Docker

WIP

## TODO list
- [x] Items - add/edit/delete/import/export
- [x] Locations - add/edit/delete
- [x] Users/Teams/Invite to team/Registration/Login - via Laravel Jetstream
- [ ] Add Dockerfile and docker-compose.yml - https://serversideup.net/open-source/docker-php/
- [ ] Add more features
  - [ ] Add tags to items - https://filamentphp.com/plugins/filament-spatie-tags
  - [ ] Add attachments to items - https://filamentphp.com/plugins/filament-spatie-media-library
  - [ ] Show related items in Location view - https://filamentphp.com/docs/3.x/panels/resources/relation-managers#creating-a-relation-manager
  - [ ] Add QR code to items
  - [x] Add multi-tenancy support - https://filamentphp.com/docs/3.x/panels/tenancy
  - [ ] Add better import/export of items with relation to locations
  - [ ] Add Laravel Octane
  - [ ] Add Laravel Pulse


## Contributing

Thank you for choosing to contribute to the project! Any contribution is welcome.
