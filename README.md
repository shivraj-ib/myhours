=====Installation=============
1. Clone Files on local/server by command.
   git clone https://github.com/shivraj-ib/myhours.git

2. Set database configuration in .env file.

3. Run command : composer install.

4. Install application by running the below command.
   Got to root director where application is cloned from git.
   Run command php artisan migrate:refresh --seed

5. Start server by command : php artisan serve

6. Ready to roll!!!!

==========Database Configuration==========================
1. Set database details in .env file
2. Run command hp artisan migrate to create initial schema.
==========Database Schema============================
 1. users
 2. teams 
 3. roles 
 4. permissions 
 5. hours 
 6. user_team 
 7. role_permission 
 8. user_role
=====================================================

