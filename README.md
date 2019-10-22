# PHP MicroServices Examples
This is a repo of example MicroServices using PHP. Areas of topics will include:
- Socket Programming
- RabbitMQ Example
- RESTFUL Example
- Authentication and Authorization Example
- Functional Programming Example

Many of the examples use [ProdigyView Toolkit](https://github.com/ProdigyView-Toolkit/prodigyview "ProdigyView Toolkit") for development.

#### Requirements To Run Test
1. Composer
2. PHP7
3. PHP Sockets Extensions Installed

## E-Mail and Socket Programming
#### Overview
The mail microservice uses basic socket communication between a socket server and service. For explanation, please read: [PHP Microservices — Send Emails Over Sockets](https://medium.com/@BlackMage1987/php-microservices-send-emails-over-sockets-977e9f8f3c3d "PHP Microservices — Send Emails Over Sockets")
#### How To Run
1. Go to the `email` folder
2. Run `composer install` to install required packages
3. Open up two tabs in your console
4. In one tab, run `php server.php`
5. In the other tab, run `php client.php`


## Video Processing and RabbitMQ
#### Overview
The services shows a basic example of how to create a service for processing videos with RabbitMQ. For detailed explanation of the service, please visit: [PHP Microservices — Video Processing With RabbitMQ](https://medium.com/@BlackMage1987/php-microservices-video-processing-with-rabbitmq-76deba359768 "PHP Microservices — Video Processing With RabbitMQ")

#### How To Run
1. Ensure RabbitMQ is installed and running locally
2. Go to the `video` folder
3. Run `composer install` to install required packages
4. Open up two tabs in your console
5. In one tab, run `php server.php`
6. In the other tab, run `php client.php`

## Restful Crud API
#### Overview
This tutorial will demonstrate how to create a basic REST api for processing CRUD operation at an endpoint. For detailed information, please visit: [PHP Microservices — Creating A Basic Restful Crud API](https://medium.com/@BlackMage1987/php-microservices-creating-a-basic-restful-crud-api-dabb1a1941a5 "PHP Microservices — Creating A Basic Restful Crud API")

#### How To Run
1. Go to the `rest` folder
2. Run `composer install` to install required packages
3. Open up two tabs in your console
4. In one tab, we need to start a php server with `php -S 127.0.0.1:8080`
5. In the other tab, run `php client.php`


## Organizing Access To Microservices
#### Overview
This section will show how to organize and manage multiple microservices. The past 3 examples have been combined into one, with the addition of sending pushing notifications and image processing. The goal is to give each service their own resources, and organize calling them via REST API.

For detailed work through please read  [Organizing Access To Multiple Services](https://medium.com/helium-mvc/php-microservices-organizing-access-to-multiple-services-a841a4d639e1 "Organizing Access To Multiple Services").

#### How To Run
We will need **four** tabs to effectively run this example.

1. Start your RabbitMQ Server
2. Go the the `multiple` folder
3. Run `composer install` to install required packages
4. Have your four tabs open to this folder
5. Start the webserver with `php -S 127.0.0.1:8090` in one tab
6. Start the notification server with `php servers/notification_server.php` in the 2nd tab
7. Start the media server with `php servers/media_server.php` in the 3rd tab
8. Execute the tests by running `php client.php` in the last tab

## Authentication, Authorization, Functional Programming and Unit Tests

#### Overview
This part of the tutorials covers how to perform Authentication and Authorization between microservices. It also includes an additional information on how to do function programming and unit test. Accompanying tutorial are as followings:
* [Authentication And Authorization](https://medium.com/helium-mvc/php-microservices-authentication-and-authorization-fff02b231803 "Authentication And Authorization")
* [Functional Programming and Unit Testing](https://medium.com/helium-mvc/php-microservices-functional-programming-and-unit-testing-2cdc09a86198 "Functional Programming and Unit Testing")

#### How To Run The Microservice
Running this example requires 4 tabs on your console.

1. Go to the `security` folder.
2. Run `composer install` to install required packages
3. Make sure your 4 tabs are open in this directory
4. Start the web server with `php -S 127.0.0.1:8000`
5. Start the authentications server with `php authentication_service/server.php`
6. Start the purchase server with `php payment_server/server.php`
7. Run the client with `php client.php` in the final tab

#### How To Run Tests
1. Go to the `security` folder.
2. Run `composer install` to install required packages
3. Type `./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/AuthenticationServerTest.php` for Authentication Tests.

## Socket vs HTTP Performance
#### Overview
This tutorial and test will bring you through comparing the performance of a RESTFUL API vs Sockets. You may read along about the tests here: [REST vs Socket Performance Benchmarks](https://medium.com/helium-mvc/php-microservices-rest-vs-socket-performance-benchmarks-64d271900ca5 "REST vs Socket Performance Benchmarks")

#### How To Run
This test will require that 3 tabs open.
1. Go to the `socket_vs_http` folder.
2. Run `composer install` to install required packages
3. Have your 3 tabs open
4. In your first tab, start the web server with `php -S 127.0.0.1:8000 -t http_server/`
5. In the second tab, start the socket with `php socket_server/server.php`
6. In the final tab, run the client with `php client.php`

