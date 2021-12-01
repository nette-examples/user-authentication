User Authentication (Nette example)
===================================

Example of user management.

- User login, registration and logout (`SignPresenter`)
- Command line registration (`bin/create-user.php`)
- Authentication using database table (`UserFacade`)
- Password hashing
- Presenter requiring authentication (`DashboardPresenter`) using the `RequireLoggedUser` trait
- Rendering forms using Bootstrap CSS framework
- Automatic CSRF protection using a token when the user is logged in (`FormFactory`)
- Separation of form factories into independent classes (`SignInFormFactory`, `SignUpFormFactory`)
- Return to previous page after login (`SignPresenter::$backlink`)


Installation
------------

```shell
git clone https://github.com/nette-examples/user-authentication
cd user-authentication
composer install
```

Set the database access data in the `config/local.neon` file:

```neon
database:
	dsn: 'mysql:host=127.0.0.1;dbname=***'
	user: ***
	password: ***
```

And create a users table in the database by importing the `users.mysql.sql` file

The simplest way to get started is to start the built-in PHP server in the root directory of your project:

```shell
php -S localhost:8000 www/index.php
```

Then visit `http://localhost:8000` in your browser to see the welcome page.

It requires PHP version 7.4 or newer.
