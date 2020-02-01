# Ticketing Check in Service

By Andy Franklin

## Setup

Install dependencies

```bash
composer install

yarn install

yarn run encore dev
```

Create .env.local file with your database connection settings

```.dotenv
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
```

Install the Symfony local server using https://symfony.com/doc/current/setup/symfony_server.html. Follow the instructions to enable TLS support (This is required for access to the device camera).

Run the server using 
```bash
Symfony serve -d
```

Visit https://127.0.0.1:8000 to view the front page.

Visit https://127.0.0.1:8000/api to view the API documentation.
