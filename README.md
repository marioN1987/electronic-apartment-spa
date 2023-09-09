Update composer dependencies run: composer update

Install packages: npm install

<!-- required, populate db tables -->
php artisan migrate

<!-- optional, fill all tables with dummy data -->
php artisan migrate --seed

<!-- required, fill states with house states, in design, under construction -->
php artisan db:seed --class=StateSeeder

## Validation
In create house, apartments no and entrances no should be between 1 - 4
Front end and back end validation is applied

## Database
I have created 3 tables STATES, HOUSES, Floors

States has different states: in design, planning  etc.

State id is FK in houses tbl.

Floors table has houses id (FK) and 2 columns apartments and entrance no.

### Controller
HouseController contains CRUD actions

### Model
House, Floor, State

### FE validation

#### UPDATE House
fillFloorsObjArr() fills object array with house floors data from database

isValid() checks if house state selected and the 2 first floors input fields have been filled (required)

checkApartmentsNoInRange() checks input to be between 1-4 apartments per floor 

