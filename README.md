# projet4_LeMauvaisCoin

LeMauvaisCoin is a project created by GRILLON Steven, as part of Wild Code School's formation.

This is an application that look like "le bon coin" to exchange Pokemons, and you can also find a pokedex and do some researches with some fields like the type of the pokemon, his name or his pokedex number, you can filter these Pokemons with buttons for all Pokemons, Pokemons you have and that you don't have.

System requirements
-------------------

* PHP 7.1;

* Git https://git-scm.com/book/fr/v1/D%C3%A9marrage-rapide-Installation-de-Git

* Database (MySQL/MariaDB or PostgreSQL);

* Composer https://getcomposer.org/doc/00-intro.md

* Npm https://www.npmjs.com/get-npm


How To Use
----------

To clone and run this project, you'll need Git, Composer and NPM. From your command line:

**Clone this repository**  
$ git clone https://github.com/StevenGrl/projet4_LeMauvaisCoin.git

**Go into the repository**  
$ cd projet4_LeMauvaisCoin

**Install dependencies**  
$ composer install  
$ npm install  

**Initiate Project**
$ php bin/console doctrine:database:create
$ php bin/console doctrine:schema:update --force

**Load fixtures to add Pokemons and some users in database**
$ php bin/console doctrine:fixtures:load

**Compile Webpack for CSS and JS**
$ npm run dev (for dev environment)
$ npm run build (for prod environment)

**Launch PHP  Server**
$ php bin/console server:run (DEV Only)
$ for prod env, configure a web server (apache, nginx, ...)

*Fixtures add Pokemons with help of API : [PokéAPI](https://pokeapi.co/)*

*If you want to log in with user created by fixtures you can use user0 to user4 with "azerty" as password*
