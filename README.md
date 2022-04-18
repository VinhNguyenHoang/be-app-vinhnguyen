# be-app-vinhnguyen
An API gateway for user to register their personal information to join 2 events. Authenticated Admins can also view API statistic and modify user's register information.

# Project information
- Docker's containers:
  - PHP 7.3-fpm
  - MySQL 8.0
  - Nginx latest
- Laravel 8.0

# How to setup locally
- Clone this project
- In folder `api`, copy `.env.example` to `.env`
  - Copy these DB configurate values to your `.env` file as they are MySQL setup in `docker\docker-compose.yml`
    ```
    DB_CONNECTION=mysql
    DB_HOST=be-mysql
    DB_PORT=3306
    DB_DATABASE=be-app
    DB_USERNAME=root
    DB_PASSWORD=mysql
    ```
- Using CMD nagivate to folder `docker` and run these commands
  - Run `docker-compose up -d`
  - Run `docker exec be-php composer update`
  - Run `docker exec be-php composer install`
  - Run `docker exec be-php composer dump-autoload`
  - Run `docker exec be-php php artisan key:generate`
  - Run `docker exec be-php php artisan migrate`
  - Run `docker exec be-php php artisan db:seed`
  - Run `docker exec be-php php artisan jwt:secret`
- The project is good to go on your local machine
  - Local API url: `127.0.0.1`
  - Admin account
    - email: admin@gm.test
    - password: 123456

# How to use
By default, the API address will be `127.0.0.1`
## Public API
### Register user information
- API endpoint: method POST `api/register`
- Parameters:
  | name | rules
  | --- | ---
  | email | required, must have email format
  | first_name | required, max 255 characters
  | last_name | required, max 255 characters
  | hobbies | required, max 255 characters
  | event_id | required, value must be exist in database (1, 2)
- Example with curl:
  ```
  curl -X POST -d "email=testwithcurl@gmail.com" -d "first_name=vinh nguyen" -d "last_name=hoang" -d "hobbies=eat rice" -d "event_id=2" "127.0.0.1/api/register"
  ```
  Above POST request will register a new user with `testwithcurl@gmail.com` to `users` table (if user not exist) and insert `first_name, last_name, hobbies, event_id` to `register_forms` table

### Get list of registered user
- API endpoint: method GET `api/user/event/{event_id}`
- Example with curl:
  ```
  curl -X GET '127.0.0.1/api/user/event/1'
  ```
  Above GET request will fetch all registered form from event A (id = 1) and result will include pagination with next, prev url links
  
### Unsubscribing user
- API endpoint: method DELETE `api/user`
- Parameters:
  | name | rules
  | --- | ---
  | id | required, must be an exist user with role 'user'
- Example with curl:
  ```
  curl -X DELETE -d "id=2" "127.0.0.1/api/user"
  ```
  Above DELETE request will delete user with id = 2 and all their registrations from table `register_forms`
  
## Authenticated API
### Admin login
- API endpoint: method POST `api/auth/login`
- Parameters:
  | name | rules
  | --- | ---
  | email | required, must be an exist email in database
  | password | required
- Example with curl:
  ```
  curl -X POST -d "email=admin@gm.test" -d "password=123456" "127.0.0.1/api/auth/login"
  ```
  Above POST request will be authorize with JWT and return result with bearer token and role for user
 
### Admin update user's register information
- API endpoint: method PUT `api/user`
- Parameters:
  | name | rules
  | --- | ---
  | form_id | required, must be an exist register form in database
  | event_id | required, must be an exist event in database
  | first_name| required, max 255 characters
  | last_name | required, max 255 characters
  | hobbies | required, max 255 characters
- Example with curl:
  ```
  curl -X PUT -d "form_id=3" -d "event_id=1" -d "first_name=mr " -d "last_name=A" -d "hobbies=read book" "127.0.0.1/api/user"
  ```
  Above PUT request will update register form with id = 3 with new values event_id, first_name, last_name, hobbies
  
### Admin get user's statistic
- API endpoint: method GET `api/user/statistic?email=<user_email>`
- Example with curl:
  ```
  curl -X GET "127.0.0.1/api/user/statistic?email=testwithcurl@gmail.com"
  ```
  Above GET request will fetch statistic data of user with email `testwithcurl@gmail.com`
