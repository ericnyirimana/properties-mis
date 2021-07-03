# Property Infromation Management System

Property MIS is a simple APP that does manipulate properties information and sync property information from an external API.

### Getting Started
* Clone the repo - ```git@github.com:ericnyirimana/properties-mis.git```.
* Access the project directory.
* Install the dependencies - run ```composer install```.
* Create a database in your local environment.
* Check - ```.env.example``` file and set your environment variables in ```.env``` file.

## Run the application with the below command

    php artisan serve

* Browse - ```http://127.0.0.1:8000```.

## Laravel command to sync properies from the external API

    php artisan pushProperties

### Endpoints

| Enpoint | Methods  | Description  |
| ------- | --- | --- |
| / | GET | The index |
| /properties | GET | Get all properties |
| /properties | DELETE | Delete a property |
| /properties/filter | GET | Filter properties by ``` property type, number of bedrooms, price, or for sale / for rent ``` |

### Given more time, I could have done the follwing:
* Finish the CRUD by adding the create and edit functionality.
* Work more on the UI/UX.Add a lazy loader or pagination on the list view properties.
* Create edit and create viewsAdd a javascript library like JQuery which would make easy requests to the back-end without reloading pages.
* Request an API that would return the total properties record, so when syncing properties we won't use anymore a static number.
* Add unit test with the use of PHP unit.

## Contributors

- [NYIRIMANA Eric](https://github.com/ericnyirimana)
