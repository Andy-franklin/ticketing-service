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

Create the database using

```bash
php bin/console do:da:cr
```

Run the migrations to create the schema

```bash
php bin/console do:mig:mig
```

Install the Symfony local server using https://symfony.com/doc/current/setup/symfony_server.html. Follow the instructions to enable TLS support (This is required for access to the device camera).

Run the server using 
```bash
Symfony serve -d
```

Visit https://127.0.0.1:8000 to view the front page.

Visit https://127.0.0.1:8000/api to view the API documentation.

# Usage

Firstly create a ticket using the API endpoint. This can be done easily using the API documentation page and choosing to "try" the endpoint.

A QR code is generated with the ticket. The public path is returned in the response to the create ticket request. This can also be retrieved using the `GET` method.

On the frontpage the operator can scan the QR code. Once the QR code is found the data can be displayed and the check in process can be completed.

# Extending this project

You *will* want to extend this project to have the proper functionality that you require. 

Upon checking in a ticket; the `ticket.checked_in` event is dispatched. You can create an event subscriber to handle any actions you wish to complete on check in (eg Updating your CRM). 

### Some ideas 
* User ID is not tied to anything and accepts any integer. Set this as an external user ID of the customer.
* The ticket_type accepts any string but might be better to tie it to specific types or an external id.
* Additional data might be required. Perhaps a metadata field on the ticket that accepts a JSON structure.
* The api is not secured. An API token could be implemented to secure this.
