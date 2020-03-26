
## Bus Booking System

This is a Laravel project for Bus Booking

## Before Run
- Make sure to create .env file with the appropriate database configuration.
- Install composer packages `composer install`
- Run the migrations `php artisan migrate`
- Run the seeder StationTableSeeder `php artisan db:seed --class=StationTableSeeder` to add the stations (cities) in the database.

## Access Dashboard
The dashboard is served on the route `/`

####Note: 
In trip creation page, a third party library is used for selecting stations (multi select); called [JQuery Multi Select](http://loudev.com/)

The library has feature called *Keep Order* to preserve the order of the selected options (so the trip stations are selected in order). This feature is *BUGGY*; it only show the selected options in order of selection, but doesn't preserve this order on sending the request. *There was no time to search for alternative*


## APIs 

- List available trips passing through given stations: `api/trips/{from}/{to}` where `{from}` and `{to}` are the stations names (cities) as defined in `/public/egypt_cities.json`
- Reserve a trip (Create Ticket): `[POST] /tickets`, where the request parameters are: 
    * `name`: User name
    * `phone`: User phone
    * `from`: Departure station (city) name.
    * `to`: Arrival stations (city) name.
    * `trip_id`: Trip ID; returned from the list trips API.
    

## EER Diagram
https://drive.google.com/file/d/1-lLMW4SYru4EecBqOmMHnCR3bAB6R4CU/view?usp=sharing


