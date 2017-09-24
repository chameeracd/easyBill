Yii 2 Table Management System
===============================

Restaurant table management system, build with Yii 2 Advanced Template

INSTALLATION
-------------------
```
composer clear-cache
composer self-update
composer global require "fxp/composer-asset-plugin:~1.3"
composer update

php init

php yii migrate

php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations

php yii migrate --migrationPath=@bedezign/yii2/audit/migrations

php yii user/create admin@central.com admin 111111

source sql;
--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `key`, `value`) VALUES
(1, 'tables', '24'),
(2, 'happy_hour_day', '12:00-15:00'),
(3, 'happy_hour_night', '00:00-01:00'),
(4, 'happy_hour_discount', '10'),
(5, 'service_charge', '0'),
(6, 'inhouse_discount', '10'),
(7, 'happy_hour_category', '1');
```

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```
