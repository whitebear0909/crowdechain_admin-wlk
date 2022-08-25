# workflow-crm



#JWT for PHP7.2 and laravel 

Make sure that you're using the last version of Tymon/JWTAuth, if you not just run:
composer require tymon/jwt-auth:1.0.* --prefer-source

Then go to config/app.php and change "JWTAuthServiceProvider" line (below)

'providers' => [
...
'Tymon\JWTAuth\Providers\JWTAuthServiceProvider' ,
...
]
to

'providers' => [
...
'Tymon\JWTAuth\Providers\LaravelServiceProvider' ,
...
]
Then run:
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"# crowdechain_admin-wlk
# crowdechain_admin-wlk
# crowdechain_admin-wlk
