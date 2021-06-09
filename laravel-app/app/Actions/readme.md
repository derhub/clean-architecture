## Actions
Here is where the generated actions located.

## How to
 - generate actions ony for specific module `php artisan derhub:module:actions moduleIdHere`
 - generate actions and ignore existing `php artisan derhub:module:actions`
 - generate actions and overwrite if existing `php artisan derhub:module:actions --force`


## Notes:
 - Never modify generated because they can be overwritten, They are located at **/Generated/ dir
 - you can modify class that extends the generated action
 - class that extends the generated action will only be generated if not exist

