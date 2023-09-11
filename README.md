### Update composer packages
composer update

### Required, install packages
npm install

### Required, populate db tables
php artisan migrate:refresh

### IF have issues, delete all created tables

php artisan migrate:rollback

### Optional, fill all tables with dummy data
php artisan migrate:refresh --seed

### Required, fill states with house states: in design, under construction
php artisan db:seed --class=StateSeeder

## Validation
When creating new house, apartments no and entrances no should be between 0 - 4. 
If user doesn't fill floor apaprtments or entrances 0 value is saved in table.
Front and Back end validation is applied

## Database
I have created 3 tables STATES, HOUSES, Floors

Houses table: has state_id (FK) 

States table: name column has different states: in design, planning  etc.

Floors table: houses id (FK) and 2 columns apartments and entrance no.

### Controller
HouseController contains CRUD actions

### Request forms for back end validation
I have created CreateHouseRequest and UpdateHouseRequest for BE validation.

### Model
House, Floor, State

### FE validation

#### UPDATE House
fillFloorsObjArr() fills object array with house floors data from database

isValid() checks if house state selected and the 2 first floors input fields have been filled (required)

### MIGRATION
Populate tables in database and their relationships

### SEEDER 
Fills tables with dummy data for testing purposes

### FACTORIES
Define random data for tables columns


### Run application
Fill .env file with database credentials

run **npm run build** to build files

run **php artisan serve**

### Download the project

git clone git@github.com:marioN1987/electronic-apartment-spa.git

or visit https://github.com/marioN1987/electronic-apartment-spa and download it


