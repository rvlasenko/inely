# Inely [![Build Status](https://scrutinizer-ci.com/g/Exoticness/madeasy/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/madeasy/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hirootkit/inely/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/hirootkit/inely/?branch=master) [![Project License](https://img.shields.io/badge/license-GPL--3.0-blue.svg)](https://github.com/hirootkit/inely/blob/master/LICENSE.md) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/bf3c5df4-1df1-4e0f-8c0a-9f24ca690685/small.png)](https://insight.sensiolabs.com/projects/bf3c5df4-1df1-4e0f-8c0a-9f24ca690685)

[Inely](http://aurathemes.ru/inely/) это простой в использовании инструмент управления задачами. Создавайте задачи, которые покроют всю вашу повседневную жизнь, и организуют их в виде проектов. Вы также можете поделиться проектами с друзьями или коллегами. Inely можно использовать как инструмент совместной работы, чтобы помочь друг другу достичь поставленных целей. Удобное и интуитивно понятное управление позволяет легко и быстро справляться даже с большим количеством дел.

# Скриншоты

### Основное рабочее пространство
Задачи могут быть объединены в проекты и могут включать в себя файлы любого типа, которые прикрепляются к заметкам. После выполнения задача перемещается в архив. На боковой панели навигации приложения отображается количество дел на сегодня и на следующие 7 дней, а также список проектов. Правый клик по задаче вызывает контекстное меню.

![](http://aurathemes.ru/inely/7.png)

![](http://aurathemes.ru/inely/2.png)

### Совместная работа и делегирование
При помощи делегирования прав можно назначить до двух ответственных на каждую задачу и следить за процессом её выполнения. Внутри такой задачи существует возможность оставлять комментарии, вносить заметки, изменять срок выполнения или ограничивать права отдельных пользователей.

![](http://aurathemes.ru/inely/3.png)

![](http://aurathemes.ru/inely/4.png)

### Справка и API документация
Для использования конечными пользователями составлено краткое руководство, а также API документация.

![](http://aurathemes.ru/inely/6.png)

# Установка

## Содержание
- [Перед тем, как Вы начнёте](#Перед-тем-как-Вы-начнёте)
- [Руководство по настройке](#Руководство-по-настройке)
    - [Требования](#Требования)
    - [Установка приложения](#Установка-приложения)
    - [Настройка веб-сервера](#Настройка-веб-сервера)
- [Установка Vagrant](#Установка-vagrant)

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
Веб-сервер должен предоставлять поддержку PHP >= 5.4 и включать в себя обязательные расширения:
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
