# PHP test

## Dependencies
- PHP 8.0+
- Composer

## 1. Installation
- `git clone https://github.com/paulolorenzobasilio/optimy-php-test.git`
- install the dependencies `composer install`
- create an empty database named "phptest" on your MySQL server
- import the dbdump.sql in the "phptest" database
- copy env file: ```cp .env.example .env```
- update your Mysql Credentials
  ```
  DB_HOST="mysql:dbname=phptest;host=127.0.0.1"
  DB_USER=root
  DB_PASSWORD=root
  ```
- you can test the demo script in your shell: `php index.php`

## 2. Expectations

This simple application works, but with very old-style monolithic codebase, so do anything you want with it, to make it:

- easier to work with
- more maintainable
