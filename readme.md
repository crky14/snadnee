# Laravel application transactions

## Instalation

1. Copy the git repository
2. Open command line in project directory and run composer install
3. Open ``` .env ``` file in project directory and set DB variables

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=payments
DB_USERNAME=root
DB_PASSWORD=root
```

4. In project directory run ```php artisan migrate```.

5. In project folder open file ```/config/imap.php``` and set these variables according your email provider:

```
'snadnee' => [ // account identifier
    'host' => 'your-email-host',
    'port' => 993,
    'protocol'  => 'novalidate-cert',
    'encryption' => 'ssl',
    'validate_cert' => true,
    'username' => 'snadnyweb.mailtask@gmail.com',
    'password' => 'heslo12345',
 ],
    
```


6. Add cron job which runs laravel scheluder every minute:

Command should look like this ->
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

You can run command from command line using:
```
php artisan checkMails
```


7. To run application on debug server run ``` php artisan serve ```
   
Now you can acces application on https://127.0.0.1:8000


