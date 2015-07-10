[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Exoticness/madeasy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/madeasy/?branch=master) [![Codacy Badge](https://img.shields.io/badge/codacy-B-brightgreen.svg)](https://www.codacy.com/app/roof1rst/list) [![Build Status](https://scrutinizer-ci.com/g/Exoticness/madeasy/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/madeasy/build-status/master) [![Requirements Status](https://requires.io/github/Exoticness/madeasy/requirements.svg?branch=master)](https://requires.io/github/Exoticness/madeasy/requirements/?branch=master) [![Code Climate](https://img.shields.io/codeclimate/github/kabisaict/flow.svg)]() [![License](https://img.shields.io/badge/licence-GPLv3-brightgreen.svg?style=flat)]()

Если ты ещё не понял, здесь будет описание


Особенности
--------
### BACKEND
- Админка AdminLTE 2
- I18N + Английский, Русский
- Авторизация, регистрация, профиль пользователя
- Авторизация по протоколу OAuth2
- Управление юзверями CRUD
- Управление доступом, с предопределенными ролями: `guest`, `user` и `administrator` 
- Полная поддержка модуля RESTful API
- Веб-интерфейс логгирования событий
- Графическое представление активности (Timeline)
- Веб-контроллер кэширования
- Отображение системной информации
- Поддержка dotenv

### FRONTEND
- Адаптивный дизайн (ПК, мобильные устройства, прочие гаджеты)
- Bootstrap 3.3
- HTML5 / CSS 3
- Quickview sidebar (заметки, настройки)
- Фиксированный / плавающий sidebar
- Разнообразные виджеты
- Динамические кнопки

Рабочий сервер
----
Frontend:
http://domain.net

Backend:
http://backend.domain.net

Аккаунт пользователя:
```
Login: user
Password: user
```

Установка и развёртывание
------------

Минимальные требования подразумевают, что веб-сервер поддерживает PHP 5.5

### Перед началом
Если у вас нет [Composer](http://getcomposer.org/), установите его следуя инструкциям на [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

После завершения добавьте плагин:
```bash
composer global require "fxp/composer-asset-plugin"
```

Клонируйте этот репозиторий и обновите зависимости:
```
cd /path/to/madeasy
composer update
```

### Инициализация

Настройте параметры в `.env` файле
	- Укажите режим отладки и ваше текущее окружение
	
	```
	YII_DEBUG   = true
	YII_ENV     = dev
	```
	- Укажите конфигурацию базы данных
	```
	DB_DSN           = mysql:host=127.0.0.1;port=3306;dbname=madeasy
	DB_USERNAME      = user
	DB_PASSWORD      = password
	```
	
	- Укажите URL-адреса для отдельных доменов
	```
	FRONTEND_URL    = http://madeasy.local
	BACKEND_URL     = http://backend.madeasy.local
	```

Запустите миграции, окружение и RBAC
```
php console/yii app/setup
```

И в завершение сконфигурируйте виртуальные хосты:
- madeasy.local => /path/to/madeasy/frontend/web
- backend.madeasy.local => /path/to/madeasy/backend/web

### Инициализация c Vagrant
Если вам дорого потраченное время, можете использовать Vagrant вместо ручной конфигурации приложения на локальном компьютере.

1. Установите [Vagrant](https://www.vagrantup.com/).
2. Откройте терминал и перейдите в папку madeasy.
3. Поднимите виртуальную машину ```vagrant up``` и сделайте перерыв. :coffee:
4. Инициализируйте окружение ```php console/yii app/setup```.

На этом всё. После этих действий приложение будет доступно по адресу http://madeasy.local на базе сервера Apache 2.4. Подключиться к базе можно через //adminer или MySQLWorkbench.

p.s. Если возникла необходимость проброса портов на MySQL и вы не смогли подключиться к базе, то зайдите через ```vagrant ssh``` выполните команду ```sudo nano /etc/mysql/my.cnf``` и закомментируйте строки:
```bash
bind-address: 127.0.0.1
skip-external-locking
```
