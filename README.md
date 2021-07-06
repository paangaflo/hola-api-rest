# API RestFul for Users with Symfony

API REST application to manage user data model. It is a API that exposes the methods CRUD RESTful for the user entity.

Users and password created by default when ``fixture`` command is executed:

* admin / adminpassword 
* page1 / page1password
* page2 / page2password

Interaction with the users of the data model is possible through the following links:

```bash
http://localhost:8080/login
http://localhost:8080/page/1
http://localhost:8080/page/2
```
![alt text](https://github.com/paangaflo/hola-api-rest/blob/master/images/login.png?raw=true)
![alt text](https://github.com/paangaflo/hola-api-rest/blob/master/images/page-1.png?raw=true)
![alt text](https://github.com/paangaflo/hola-api-rest/blob/master/images/page-2.png?raw=true)

## Prerequisites

Before start you need to have installed:

* [Composer](https://getcomposer.org/) globally installed.
* [Docker Desktop](https://www.docker.com/products/docker-desktop)
* [Symfony CLI tool](https://symfony.com/doc/current/cloud/getting-started.html#installing-the-cli-tool)

## Getting Started

Clone repository to local environment.

```bash
git clone https://github.com/paangaflo/hola-api-rest.git
```

## Installation

Inside root folder of your project run the following command:

```bash
docker-compose up -d --build
```

When the containers are built, you will see something similar to the screenshot below in your terminal.

![alt text](https://github.com/paangaflo/hola-api-rest/blob/master/images/docker-images-up.png?raw=true)

If you open Docker Desktop, you should see your newly created container as shown in the screenshot below.

![alt text](https://github.com/paangaflo/hola-api-rest/blob/master/images/docker-desktop.png?raw=true)

Run the docker exec command and opens a terminal for you to interact with the container.

```bash
docker-compose exec php /bin/bash
```

Ensure that your setup meets the requirements for a Symfony application by running the following command.

```bash
symfony check:requirements
```

If it meets the requirements, you will see the following output in the terminal.

```bash
[OK]                                             
Your system is ready to run Symfony projects
```

Run your migrations using the following command. And answer with "yes" when prompted.

```bash
symfony console doctrine:migrations:migrate
```

You will see the following output in the terminal.

![alt text](https://github.com/paangaflo/hola-api-rest/blob/master/images/migration.png?raw=true)

To load the fixtures in our database, run the following command in the PHP container. And answer with "yes" when prompted.

```bash
symfony console doctrine:fixtures:load
```

You will see the following output in the terminal.

![alt text](https://github.com/paangaflo/hola-api-rest/blob/master/images/fixtures.png?raw=true)

## Use local environment

You can consume the endpoint using the tool that you prefer or you can use any of the following [postman, insomnia, etc ..].

## Create User #1

```bash
POST localhost:8080/api/user
```

```json
{
  "name": "Pablo Galvis",
  "username": "pablo.galvis",
  "password": "password1234",
  "roles": [
    "ROLE_PAGE1"
  ]
}
```

## Edit User #2

```bash
PUT localhost:8080/api/user/{id}
```

```json
{
  "name": "Pablo Galvis",
  "username": "pablo.galvis",
  "password": "password1234",
  "roles": [
    "ROLE_PAGE1" // possible options: ROLE_ADMIN, ROLE_PAGE1, ROLE_PAGE2
  ]
}
```

## Select User #3

```bash
GET localhost:8080/api/user/{id}
```

## List Users #4

```bash
GET localhost:8080/api/users
```

## DELETE User #5

```bash
DELETE localhost:8080/api/user/{id}
```

## Unit test

Run unit tests with the following command:

```bash
./vendor/bin/phpunit
```

## Coverage unit test

To see percentage of code coverage on unit tests use the following command:

```bash
./vendor/bin/phpunit --coverage-html html .
```

## PHP_CodeSniffer

You will then be able to run PHP_CodeSniffer from the vendor bin directory. And use the following command:

```bash
./vendor/bin/phpcs --standard=PSR2 ./app --ignore=*/vendor/*,*/var*
```

## Built With

* [Symfony](https://symfony.com/download)
* [MySQL](https://www.mysql.com/downloads/)
* [PHP](https://www.php.net/downloads.php)
* [NGINX](https://www.nginx.com/)

## Authors

* **Pablo Galvis** - [paangaflo](https://github.com/paangaflo)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
