# 2WEB
Supermarket - SUPINFO - Lemaire Quentin - 214520

- Front-office : [http://supmarket.lemairepro.fr](http://supmarket.lemairepro.fr)
- Back-office : [http://supmarket.lemairepro.fr/backend/dashboard](http://supmarket.lemairepro.fr/backend/dashboard)
    * (Login 'admin'; password 'admin')

## To install this project

```
composer install
php bin/console doctrine:schema:update -- force
php bin/console asset:install
php bin/console cache:clear --env=prod
php bin/console assetic:dump --env=prod
```
