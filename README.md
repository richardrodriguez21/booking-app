# Welcome to the Booking-App by Richard Rodriguez!

## About

**Booking App** is a small hotel room booking application developed in Symfony 7 (PHP 8).

## How to Run and Test It 
Just execute `"make start".` 
To test the endpoints, use Postman. A Postman collection is included in the `_postman` folder located at the root of the project. Simply import it into Postman to begin testing.

## Requirements to run the app 
- Docker
- Make 
- Port 8080 available. 

## Architecture 
This app uses **Hexagonal Architecture** and **Domain-Driven Design (DDD)**. It is implemented as a monolith.
Each endpoint has its own controller class.  
Each use case has its own service class (located in the `Application` folder).  
To decouple the application from the persistence layer, the **repository pattern** is used.

## Folder structure

    booking-app/
    ├── .git/
    ├── src/
    │   ├── Hotels/
    │   ├── Controller/
    │   ├── Bookings/
    │   ├── Shared/
    │   └── Kernel.php
    ├── _postman/
    ├── .phpunit.cache/
    ├── bin/
    ├── tests/
    ├── vendor/
    ├── var/
    ├──----- data/ 
    ├── config/
    ├── public/
    └── docker/

-   **Controllers**: Contains the API controller classes.
-   **Hotels, Bookings, Shared**: Domain modules.
-   **_postman**: Contains a Postman collection export. Import it to test the API.
-   **docker/**: Contains Docker-related files.
-   **var/data**: Contains `bookings.json` file used as a simple persistence layer

## Entities

Only two entities were implemented: **Booking** and **Hotel**.  
A separate User entity was not needed for the test.  
All user-related data, including the unique identifier (email), is on the Booking entity.

## Which improvements can be done ?
-   Add validations to the endpoints and the use cases, using, for example, Symfony's custom value resolver with the Validator component.
    
-   To improve the performance of some endpoints, such as the one for unique users per hotel, a projection can be used, with an entity named "HotelUniqueUsers" that has a property for the number of unique users. This counter will be updated each time a booking is created. This can be done by publishing an event like "BookingCreated" and subscribing a service to this event to update the counter. To further improve performance and user experience, a queue can be used to make it asynchronous. Using this projection will allow having the statistics available immediately without fetching all bookings or performing a heavy SQL query.
    
-   Booking creation can be handled through a microservice to manage a high volume of requests.


