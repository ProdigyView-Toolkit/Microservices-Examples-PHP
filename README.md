# PHP MicroServices Examples
This is a repo of example MicroServices using PHP. Areas of topics will include:
- Socket Programming
- RabbitMQ Example
- RESTFUL Example

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




