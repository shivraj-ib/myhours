=====Installation=============
1. Composer should be installed.
2. First, download the Laravel installer using Composer:
   Command: composer global require "laravel/installer"

3. Create new laravel project using below command.
   Command: laravel new blog(name of you project)

4. Update composer.json file to install only required libraries.

5. Run command: composer install.

6. Rename .env.example file in root dir to .env.

7. If .env file is missing. first check it this file is hidden if not then add a new .env file with below code
    https://raw.githubusercontent.com/laravel/laravel/master/.env.example
8. Run command: php artisan key:generate

9. Start laravel run command: php artisan serev

10. Ready to roll!!!!!!!


