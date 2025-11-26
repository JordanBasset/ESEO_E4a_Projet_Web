# TP Mihoyo

## Project requirements

- PHP >= 8.4
- MySQL >= 8.x

## Project setup

### Database configuration

Copy the file `Config/dev_sample.ini` to `Config/prod.ini` (or `Config/dev.ini` if you're
running within a development environment).

The configuration file should look like this:

```ini
;This section is used to configure the application database
[DB]
dsn = 'mysql:host=%HOSTNAME%;dbname=%DB_NAME%;charset=utf8mb4';
user = '%USERNAME%';
pass = '%PASSWORD%';
```

Now modify the `%HOSTNAME%`, `%DB_NAME%`, `%USERNAME%` and `%PASSWORD%` placeholders to your own values.

### Import database schema

Import the SQL script located in the file `db.sql` in the root folder of the project into your database.
