# webSocketApp

## Presentation

A simple Chat application


Currently, the project  contains a Websockets server.

This server allows you to send the "hello word" message to connected clients

## Development environment

 - PHP 7.4 
 - composer 
 - web server (Apache, Nginx, ...)

are required to install this application

The web server must be configured to set up a redirection to `path/to/project_floder/public/index.php`

###Problem to be solved: 
the first message sent from a mozilla browser is not received

## Commands to install the application

```
composer install
php bin/console


```
### Bibliographic references :
http://socketo.me/docs/hello-world