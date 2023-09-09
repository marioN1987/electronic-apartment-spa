#### update composer packages
composer update

#### required install packages
npm install

#### required, populate db tables
php artisan migrate

#### optional, fill all tables with dummy data
php artisan migrate --seed

#### required, fill states with house states: in design, under construction
php artisan db:seed --class=StateSeeder

## Validation
When creating new house, apartments no and entrances no should be between 1 - 4.
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

checkApartmentsNoInRange() checks input to be between 1-4 apartments per floor 

