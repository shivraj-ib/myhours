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
===================================================================
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
===================================================================

8. Run command: php artisan key:generate

9. Start laravel run command: php artisan serev

10. Ready to roll!!!!!!!


