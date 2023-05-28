# PassUp

A simple password manager to control your passwords and share with your team, perfect to users or small teams.

## Features

- Password generator
- Sharing passwords with users or groups of user
- Filter by Favorites, My passwords and Shared with me
- Organization and filtering by Folders
- Organization and filtering by Type of passwords
- Permissions for users

Execute next step for see all the features...

## Quick setup

1. Install docker and docker-compose
    - [Docker Install documentation](https://docs.docker.com/install/)
    - [Docker-Compose Install documentation](https://docs.docker.com/compose/install/)
2. Run command `docker-compose up -d` for create the containers
3. Run command `docker exec -i passup_app composer install` for install composer dependencies
4. Run command `docker exec -i passup_app php artisan migrate --database=mysql_root` for create tables in database
5. Run command `npm install` for install node dependencies
6. Run command `gulp build` for create the assets folder with the js, css and files (See the gulpfile.js for details)

Optionally you can run

- `docker ps -a` for see the containers running
- `docker exec passup_app php artisan queue:work --tries=3` for run the queue and send emails

After these steps you can access the project on [localhost:8082](http://localhost:8082)

## Screens from project

Some images from project. For see all the screens, checkout and run it locally.

### Dashboard

<kbd>
<img src="https://github.com/andersonalvesme/passup-password-manager/blob/master/_readme_images/dashboard.png" alt="Dashboard">
</kbd>

### Dashboard creating information

<kbd>
<img src="https://github.com/andersonalvesme/passup-password-manager/blob/master/_readme_images/dashboard_create.png" alt="Dashboard creating information">
</kbd>

### Dashboard viewing information

<kbd>
<img src="https://github.com/andersonalvesme/passup-password-manager/blob/master/_readme_images/dashboard_view.png" alt="Dashboard viewing information">
</kbd>

### Frontend validation

<kbd>
<img src="https://github.com/andersonalvesme/passup-password-manager/blob/master/_readme_images/frontend_input_validation.png" alt="Frontend validation">
</kbd>

### Backend validation

<kbd>
<img src="https://github.com/andersonalvesme/passup-password-manager/blob/master/_readme_images/backend_input_validation.png" alt="Backend validation">
</kbd>

### Group add

<kbd>
<img src="https://github.com/andersonalvesme/passup-password-manager/blob/master/_readme_images/group_add.png" alt="Group add">
</kbd>

### Group add user

<kbd>
<img src="https://github.com/andersonalvesme/passup-password-manager/blob/master/_readme_images/group_add_users.png" alt="Group add user">
</kbd>

### Group list

<kbd>
<img src="https://github.com/andersonalvesme/passup-password-manager/blob/master/_readme_images/group_list.png" alt="Group list">
</kbd>
