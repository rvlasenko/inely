# Inely [![Build Status](https://scrutinizer-ci.com/g/Exoticness/madeasy/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/madeasy/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hirootkit/inely/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/hirootkit/inely/?branch=master) [![Codacy Badge](https://img.shields.io/badge/codacy-B-brightgreen.svg)](https://www.codacy.com/app/roof1rst/list)

##### [Inely](http://www.inely.ru) – свободный облачный сервис для управления персональными задачами, позволяющий составить расписание дел, либо работать над общими планами и целями, делегировать задачи между родными и коллегами и многое другое...

# Установка

## Содержание
- [Перед тем, как Вы начнёте](#)
- [Руководство по настройке](#)
    - [Требования](#)
    - [Установка приложения](#)
    - [Настройка веб-сервера](#)
- [Установка Docker](#)
- [Установка Vagrant](#)

## Перед тем, как Вы начнёте
1. Если Вы ещё не обзавелись таким инструментом, как [Composer](http://getcomposer.org/), Вы можете установить его следуя инструкциям
на [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

2. Установите composer-asset-plugin для управления ассетами в Yii
```bash
composer global require "fxp/composer-asset-plugin"
```

### Исходный код
#### Скачайте исходники
https://github.com/hirootkit/inely/archive/master.zip

#### Или клонируйте репозиторий вручную
```
git clone https://github.com/hirootkit/inely.git
```
#### Установите менеджер зависимостей
```
composer install
```

## Руководство по настройке
### Требования
Минимальное требование, которое налагается на Inely – поддержка веб-сервером PHP 5.4.0.
Обязательные PHP расширения:
- intl
- mcrypt

### Установка приложения
1. В корневой директории переименуйте `.env.example` в `.env` (``.env.docker.dist`` если Вы используете Docker)
2. Настройте параметры в файле `.env`
    - Установите режим отладки и Ваше текущее окружение
    ```
    YII_DEBUG  = true
    YII_ENV    = dev
    ```
    - Установите конфигурацию базы данных
    ```
    DB_DSN       = mysql:host=127.0.0.1;port=3306;dbname=inely
    DB_USERNAME  = user
    DB_PASSWORD  = password
    ```

    - Установите канонические URL-адреса
    ```
    FRONTEND_URL = http://inely.dev
    BACKEND_URL  = http://app.inely.dev
    ```

3. Запустите команду
```
php console/yii app/setup
```

### Настройка веб-сервера
Внесите в конфигурационный файл Вашего веб-сервера две новые корневые директории:
- inely.dev     => /path/to/inely/frontend/web
- app.inely.dev => /path/to/inely/backend/web

## Установка Docker
### Перед установкой
 - Прочтите, что такое [Docker](https://www.docker.com)
 - Установите его

### Установка
1. В корневой директории переименуйте ``.env.docker.dist`` в `.env`
2. Запустите команды ``docker-compose build``
3. ``docker-compose up -d``
4. Настройте приложение командой ``docker-compose run cli app/setup``
5. На этом всё – приложение доступно на http://inely.dev:8000

### Docker FAQ
- Как я могу выполнять консольные команды yii?

``docker-compose run cli help``

``docker-compose run cli migrate``

``docker-compose run cli rbac-migrate``

- Как мне подключиться к базе данных приложения с помощью инструментов, например, MySQLWorkbench?
MySQL доступен по локальному адресу ``127.0.0.1``, порт ``33060``. Пользователь - `root`, Пароль - `root`

## Установка Vagrant
1. Сперва установите [Vagrant](https://www.vagrantup.com/)
2. Откройте терминал и перейдите в директорию inely.
3. Установите хостменеджер, поднимите виртуальную машину и сделайте перерыв. :coffee:

``vagrant plugin install vagrant-hostmanager``

``vagrant up``

- Инициализируйте окружение ```php console/yii app/setup```.

На этом всё. После этих действий приложение будет доступно по адресу http://inely.dev:8000 на базе сервера Apache 2.4. Управление базой данных происходит через /adminer или MySQLWorkbench.

p.s. Если возникла необходимость проброса портов к MySQL через Vagrant и вы не смогли подключиться к базе, то зайдите через ```vagrant ssh``` выполните команду ```sudo nano /etc/mysql/my.cnf``` и закомментируйте строки:
```bash
bind-address: 127.0.0.1
skip-external-locking
```
