
First copy this directory inside local server directory of LAMP/WAMP/XAMPP.
Open Command prompt go to inside project directory folder run  for project create.

"composer create-project --prefer-dist laravel/laravel project_name"

go to project folder in command line then hit 
"composer install"

Create new database in mysql by name currency_management.
open file /project_name/.env file in editor configure
databse credentials like below. DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=DB_DATABASE=currency_management DB_USERNAME=root DB_PASSWORD=root


Now hit command in /project_name/ 
"php artisan migrate"


Add new user by hit commond  

php artisan add:user

Enter this details
1) What is your name?
2) What is your email id?
3) What is the password?

Daily currency record add into database run this commond

php artisan add:currency

at last run a project in command line then hit 
"php artisan serve" 



