# Simple task based on decision tables
Author: Paulius Leveris

## About the project

According to given flight data, script should determine if the flight is claimable or not based on specified conditions.

## Created with the following stack:

- OS: Ubuntu 20.04;
- PHP v8;
- Laravel v10.

## How to build and/or run?
First, ensure the following Dependencies are available on your system:
- Docker;
- Docker Compose;
- PHP 8.2;
- Composer.

Clone the project from GitHub:
```bash
git clone --recursive https://github.com/pleveris/decision-table-implementation.git
```
Install Composer Dependencies:
```bash
composer install
```
Change .env.example to .env, edit all the credentials that suits your needs:
```bash
cp .env.example .env
```
To build a Docker container, run:
```bash
./vendor/bin/sail build --no-cache
```
Set the application key:
```bash
./vendor/bin/sail artisan key:generate
```
Start the container:
```bash
./vendor/bin/sail up
```
The application should be available at localhost:80.

## How to run the flight claim script?
It's defined as a CLI command, and can be run by typing in the console:
```bash
./vendor/bin/sail artisan process:flights <path_to_project>/flights.csv
```
Here, <path_to_project> means the original path to the project, e.g. ```/home/<user>/development/decision-table-implementation/```.


## Running locally
If you do not have Docker installed and/or configured, you can run the script locally:
Set the application key:
```bash
php artisan key:generate
```
Start the development server:
```bash
php artisan serve
```
To launch the flight claim script, run:
```bash
php artisan process:flights flights.csv
```
