# Bennedo

### Prerequisites

Ce qui est nécessaire pour installer l'application et comment les installer

What things you need to install the software and how to install them

```
PHP 7.2
Composer
Posgres SQL 12.1
stackbuilder
Postgis
```

### Installing

Les étapes pas à pas d'installation d'une version de devellopement fonctionnelle

A step by step series of examples that tell you how to get a development env running

Installation de postgres avec stackbuilder
```
https://www.postgresql.org/download/
```

Installation de postgis / Install postgis
```
Installer postgis avec une spatial database / Install postgis with a spatial database
```

Cloner le Git / Clone Git repository
```
https://github.com/Jonathan-Renault/Bennedo.git
```

Créer le fichier .env à la racine / Create .env file in root

Installation / Install
```
composer update
```

Création de la base de données / Create Database
```
php bin/console doctrine:database:create
```

Cliques droit sur pgadmin/Database/Nom_BDD/extension, create> postgis

Création de la migration / Make migration
```
php bin/console make:migration
```

## Built With

* [Symfony](https://www.symfony.com) - PHP Framework

## Authors

* **Arthur Brunet** - *Développeur* - [Lien Git](https://github.com/ArthurBrunet)

* **Armand Deshais** - *Développeur* - [Lien Git](https://github.com/Myrendir)

* **Dorian Legros** - *Responsable de Projet* - [Lien Git](https://github.com/DorianLegros)

* **Jonathan Renault** - *Développeur* - [Lien Git](https://github.com/Jonathan-Renault)
