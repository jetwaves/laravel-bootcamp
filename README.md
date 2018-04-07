# laravel-bootcamp
A boot camp who initialize a series of tools for starter of laravel 5.5

0. Installation:
    * Run command:
    ```php
    composer require jetwaves/laravel-bootcamp
    ```
    * Edit config/app.php, add following line into 'providers' array
    ```php 
    Jetwaves\LaravelBootcamp\Providers\LaravelBootcampServiceProvider::class,
    ```
    * ***Edit '.env', set your database options (database name, username, password)***

1. Jwt (Json Web Token ) Integration.
    1. Initialisation
    
        Run command in console:
            ```php
                php artisan bootcamp:init
            ```
    2. Test it's working:
        * Run ``` php artisan serve ``` in cli. 
        * Import "Tests/postman/Laravel_Jwt_integration_Test.postman_collection.json" into [Postman](https://www.getpostman.com/)
        * Run the tests 1-9. You should see following results:
            1. test1: 
                ```php
                it works !!! 
                ```
            1. test2:
                ```php
                "error": "Token is required"
                ```
            1. test3:
                ```php
                The name field is required.,The email field is required.,The password field is required.
                ```
            1. test4:
                ```php
                {
                    "status": true,
                    "message": "JwtUser created successfully",
                    "data": {
                        "name": "test1",
                        "email": "test@test.com1",
                        "updated_at": "2018-02-17 12:12:36",
                        "created_at": "2018-02-17 12:12:36",
                        "id": 2
                    }
                }
                ```
            1. test5:
                ```php
                The email field is required.,The password field is required.
                ```
            1. test6:
                ```php
                "invalid_email_or_password"
                ```
            1. test7:
                ```php
                "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.***********************"
                ```
            1. test8: (change the 'Authorization' field of the header with 'Bearer '.$tokenReturnedInTest7 )
                ```php
                it works !!! 
                ```
            1. test9: (change the 'Authorization' field of the header with 'Bearer '.$tokenReturnedInTest7 )
                ```php
                "result": {
                        "id": 1,
                        "name": "test1",
                        "email": "test@test.com1",
                        "created_at": "2018-02-17 11:57:01",
                        "updated_at": "2018-02-17 11:57:01"
                    }
                ```
    2. Usage:
        
        A simple implicit router protected with jwt is declared in routes/api.php
        
        Routes without jwt protection:
           
            GET http://localhost:8000/api/noauth/ControllerName/snake-form-function-name is served by ControllerNameController->getSnakeFormFunctionName()
            POST http://localhost:8000/api/noauth/ControllerName/snake-form-function-name is served by ControllerNameController->postSnakeFormFunctionName()
        
        Routes with jwt protection:
        
            GET http://localhost:8000/api/withauth/ControllerName/snake-form-function-name is served by ControllerNameController->getSnakeFormFunctionName()
            POST http://localhost:8000/api/withauth/ControllerName/snake-form-function-name is served by ControllerNameController->postSnakeFormFunctionName()                
            
        Cf. [Jetwaves/ Laravel Implicit Router](https://github.com/jetwaves/laravel-implicit-router) to know more about implicit router for laravel 5.2+
        
    3. Errors and eventual problems:
        
        1. To be completed later.
    
    
    