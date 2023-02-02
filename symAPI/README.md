# Symfony API Project Documentation

#### This documentation provides a step-by-step guide to setting up a Symfony project that retrieves data from an external API (JSON Placeholder, https://jsonplaceholder.typicode.com/) and manages it through a back office using EasyAdmin.

### Prerequisites
- PHP installed on your computer
- Composer installed on your computer

### Project Setup
1. Create a new Symfony project:
> composer create-project --prefer-dist symfony/skeleton symAPI
2. Install the required packages:
> composer require api\
> composer require symfony/maker-bundle --dev\
> composer require symfony/http-client\
> composer require symfony/serializer-pack\
> composer require orm-fixtures --dev\
> composer require jwt-auth\
> composer require lexik/jwt-authentication-bundle\
> composer require form\
> composer require easycorp/easyadmin-bundle

### Entities
Generate entities based on the API data (posts, comments, albums, photos, todos):
> php bin/console make:entity

### Database
Create the database:
> php bin/console doctrine:database:create\
> php bin/console make:migration\
> php bin/console doctrine:migrations:migrate

### Import API Data
1. Import API data using custom command
> php bin/console app:fetch-api
2. Create a command to import API data:
> php bin/console make:command

### Registration and Authentication
Generate a registration form and set up JWT authentication:
> php bin/console make:auth\
> php bin/console make:registration-form\
> php bin/console lexik:jwt:generate-keypair

### Fixtures
Create fixtures for only users:
> php bin/console doctrine:fixtures:load

Note: The fixtures will create 1 super admin and 10 users.

### Back Office (EasyAdmin) CRUD
Set up EasyAdmin for a back office:
> php bin/console make:admin:crud\
> php bin/console make:admin:dashboard

### Run the application
> symfony serve

## Conclusion
By following these steps, you should have a working Symfony project that retrieves data from an external API and manages it through a back office using EasyAdmin.

_Note: I didn't mention all steps, only the essentials many of them are from the course's support (like how and to authenticate and generate a token key… etc), Symfony website documentation, API Platform documentation._\
_By **Adil EL MOBACHI** (adil.el_mobachi@edu.devinci.fr) M4 - iWM - Groupe B_



