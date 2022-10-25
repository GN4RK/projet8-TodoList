ToDoList
========

# Project informations
This project is the eighth project of the online course on OpenClassrooms : [Développeur d'application - PHP / Symfony](https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony)

## Description of needs
Improve an existing app.

List of the needs :
- implementation of new functionalities
- correction of some anomalies
- implementation of automated tests

## Installation

### Cloning the project
```
git clone https://github.com/GN4RK/projet8-TodoList
```

### Installing dependencies 
```
composer install
```

### Configurations

#### Database
Change database connection in .env file : 
```
DATABASE_URL="mysql://root:@localhost/database_name?serverVersion=your_server&charset=utf8"
```

### Database migration
Run database migration on the new environnement
```
php bin/console doctrine:migrations:migrate
```

### Load data fixture
This command will load fresh data into your database
```
php bin/console doctrine:fixtures:load
```

### Running server
```
symfony server:start
```

## Badge Codacy
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/d512aba9226d468aaf3f2a330d57cf22)](https://www.codacy.com/gh/GN4RK/projet8-TodoList/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=GN4RK/projet8-TodoList&amp;utm_campaign=Badge_Grade)