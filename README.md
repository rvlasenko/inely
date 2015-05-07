[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Exoticness/list/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/list/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/Exoticness/list/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/list/build-status/master)<br>

Здесь будет описание проекта


Особенности проекта
--------
### BACKEND
- Прекрасная open source тема для админки AdminLTE 2
- I18N + 3 трансляции: Английский, Русский, Украинский
- Смена текущей локали + поведение, позволяющее автоматически менять локаль основываясь на языке в браузере
- Авторизация, регистрация, профиль пользователя
- Авторизация по протоколу OAuth
- Управление пользователями CRUD
- Управление доступом на основе ролей, с предопределенными ролями: `guest`, `user`, `manager` и `administrator` 
- Компоненты для управления содержимым, таким как: статьи, категории, статические страницы
- Полная поддержка модуля RESTful API
- Файловое хранилище + виджет загрузки файлов
- Библиотека для управления изображениями Glide
- Веб-интерфейс логгирования событий
- Графическое представление активности (Timeline)
- Веб-контроллер кэширования
- Maintenance mode component ([more](#maintenance-mode))
- Отображение системной информации
- Поддержка dotenv

- Imperavi Reactor Widget (http://imperavi.com/redactor, https://github.com/asofter/yii2-imperavi-redactor), 
- Elfinder Extension (http://elfinder.org, https://github.com/MihailDev/yii2-elfinder)
- Nginx конфигурация
- Поддержка Vagrant

### FRONTEND
- первое
- второе

Демонстрация
----
Frontend:
http://yii2-starter-kit.terentev.net

Backend:
http://backend.yii2-starter-kit.terentev.net

Аккаунт обычного пользователя:
```
Login: user
Password: user
```

Требования
------------

Минимальные требования подразумевают, что ваш веб-сервер поддерживает PHP 5.4

Установка и развёртывание
------------

### Перед установкой
Если на вашем ПК нет [Composer](http://getcomposer.org/), установите его следуя инструкциям на [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

Установите необходимый плагин для управления ассетами composer-asset-plugin
```bash
composer global require "fxp/composer-asset-plugin"
```


### Клон репозитория c GitHub

Извлеките файл архива c GitHub или клонируйте этот репозиторий
```bash
git clone https://github.com/Exoticness/list.git
```

После завершения запустите команду в консоли
```
cd /path/to/list/
composer install
```

Процесс конфигурации приложения включает в себя:

1. Initialise application
2. Prepare web server
3. Configure environment local settings
4. Apply migrations
5. Initialise RBAC

### Vagrant
If you want, you can use bundled Vagrant instead of installing app to your local machine.
Install [Vagrant](https://www.vagrantup.com/)
Rename `vagrant.dist.yaml` to `vagrant.yaml`
Create GitHub [personal API token](https://github.com/blog/1509-personal-api-tokens) and paste in into `vagrant.yml`
Run:
```
vagrant plugin install vagrant-hostmanager
vagrant up
```

#### 1. Initialization
Initialise application
```
./init // init.bat for windows
```

#### 2. Web Server

You should configure web server with three different web roots:

`yii2-starter-kit.dev` => `/path/to/yii2-starter-kit/frontend/web`

`backend.yii2-starter-kit.dev` => `/path/to/yii2-starter-kit/backend/web`

`storage.yii2-starter-kit.dev` => `/path/to/yii2-starter-kit/storage`

**NOTE:** You can use `nginx.conf` file that is located in the project root.

#### 3. Setup environment
Adjust settings in `.env` file

##### 3.1 Database
Edit the file `.env` with your data:
```
DB_DSN           = mysql:host=127.0.0.1;port=3306;dbname=yii2-starter-kit
DB_USERNAME      = user
DB_PASSWORD      = password
```
**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.


##### 3.2 Application urls
Set your current application urls in `.env`

```php
FRONTEND_URL    = http://yii2-starter-kit.dev
BACKEND_URL     = http://backend.yii2-starter-kit.dev
STORAGE_URL     = http://storage.yii2-starter-kit.dev
```
#### 4. Apply migrations

```php
php console/yii migrate
```

#### 5. Initialise RBAC config

```php
php console/yii rbac/init
```
**IMPORTANT: without rbac/init you CAN'T LOG IN into backend**

COMPONENTS
----------
### I18N
If you want to store application messages in DB and to have ability to edit them from backend, run:
```php
php console/yii message/migrate @common/config/messages/php.php @common/config/messages/db.php
```
it will copy all existing messages to database

Then uncomment config for `DbMessageSource` in
```php
common/config/base.php
```

### KeyStorage
Key storage is a key-value storage to store different information. Application params for example.
Values can be stored both via api or by backend CRUD component.
```
Yii::$app->keyStorage->set('key', 'value');
Yii::$app->keyStorage->get('articles-per-page');
```

### ExtendedMessageController
This controller extends default MessageController to provide some useful actions

Migrate messages between different message sources:
``yii message/migrate @common/config/messages/php.php @common/config/messages/db.php``

Replace source code language:
``yii message/replace-source-language @path language-LOCALE``

Remove Yii::t from code
``yii message/replace-source-language @path``

### Maintenance mode
Starter kit has built-in component to provide a maintenance functionality. All you have to do is to configure ``maintenance``
component in your config
```php
'bootstrap' => ['maintenance'],
...
'components' => [
    ...
    'maintenance' => [
        'class' => 'common\components\maintenance\Maintenance',
        'enabled' => Astronomy::isAFullMoonToday()
    ]
    ...
]
```
This component will catch all incoming requests, set proper response HTTP headers (503, "Retry After") and show a maintenance message.
Additional configuration options can be found in a corresponding class.

Starter kit configured to turn on maintenance mode if ``frontend.maintenance`` key in KeyStorage is set to ``true``

OTHER
-----
### Updates
Add remote repository `upstream`.
```
git remote add upstream https://github.com/trntv/yii2-starter-kit.git
```
Fetch latest changes from it
```
git fetch upstream
```
Merge these changes into your repository
```
git merge upstream/master
```
**IMPORTANT: there might be a conflicts between `upstream` and your code. You should resolve conflicts on your own**

### Have any questions?
mail to `eugene@terentev.net`

#### NOTE
This template was created mostly for developers NOT for end users.
This is a point where you can begin your application, rather than creating it from scratch.
Good luck!
