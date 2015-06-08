[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Exoticness/madeasy/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/madeasy/?branch=master) [![Codacy Badge](https://img.shields.io/badge/codacy-B-brightgreen.svg)](https://www.codacy.com/app/roof1rst/list) [![Build Status](https://scrutinizer-ci.com/g/Exoticness/madeasy/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/madeasy/build-status/master) [![Requirements Status](https://requires.io/github/Exoticness/list/requirements.svg?branch=master)](https://requires.io/github/Exoticness/list/requirements/?branch=master) [![Code Climate](https://img.shields.io/codeclimate/github/kabisaict/flow.svg)]()

Здесь будет описание


Особенности
--------
### BACKEND
- Прекрасная open source тема для админки AdminLTE 2
- I18N + 2 трансляции: Английский, Русский
- Смена текущей локали + поведение, позволяющее автоматически менять локаль основываясь на языке системы
- Авторизация, регистрация, профиль пользователя
- Авторизация по протоколу OAuth2
- Управление пользователями CRUD
- Управление доступом, с предопределенными ролями: `guest`, `user`, `manager` и `administrator` 
- Компоненты для управления содержимым, таким как: статьи, категории, статические страницы
- Полная поддержка модуля RESTful API
- Файловое хранилище + виджет загрузки файлов
- Библиотека для управления изображениями Glide
- Веб-интерфейс логгирования событий
- Графическое представление активности (Timeline)
- Веб-контроллер кэширования
- Отображение системной информации
- Поддержка dotenv
- Nginx конфигурация

### FRONTEND
- Адаптивный дизайн (ПК, планшеты, мобильные устройства)
- Quickview sidebar (заметки, настройки)
- Фиксированный / плавающий sidebar
- Разнообразные виджеты
- Bootstrap 3.3 Framework
- 8 цветовых схем
- HTML5 / CSS3
- Parallax
- Динамические кнопки

Рабочий сервер
----
Frontend:
http://domain.net

Backend:
http://backend.domain.net

Демо аккаунт пользователя:
```
Login: user
Password: user
```

Установка и развёртывание
------------

Минимальные требования подразумевают, что веб-сервер поддерживает PHP 5.4

### Перед началом
Если у вас нет [Composer](http://getcomposer.org/), установите его следуя инструкциям на [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

После завершения добавьте плагин:
```bash
composer global require "fxp/composer-asset-plugin"
```

Клонируйте этот репозиторий и обновите зависимости:
```
cd /path/to/schedule
composer update
```

### Инициализация
1. Настройка параметров в `.env`
	- Укажите режим отладки и ваше текущее окружение
	
	```
	YII_DEBUG   = true
	YII_ENV     = dev
	```
	- Укажите конфигурацию базы данных
	```
	DB_DSN           = mysql:host=127.0.0.1;port=3306;dbname=schedule
	DB_USERNAME      = user
	DB_PASSWORD      = password
	```

	- Укажите URL-адреса для отдельных доменов
	```
	FRONTEND_URL    = http://schedule.dev
	BACKEND_URL     = http://backend.schedule.dev
	STORAGE_URL     = http://storage.schedule.dev
	```

2. Запуск миграций, установка окружения и RBAC
```
php console/yii app/setup
```

### Конфигурация сервера
`vhost.conf`, предназначен для Apache серверов и имеет оптимальные настройки.
Для любого другого сервера вы можете настроить конфигурацию самостоятельно:
- schedule.dev => /path/to/yii2-starter-kit/frontend/web
- backend.schedule.dev => /path/to/yii2-starter-kit/backend/web
- storage.schedule.dev => /path/to/yii2-starter-kit/storage/web

### Vagrant
Если вы хотите осуществить быструю развёртку, можете использовать Vagrant вместо ручной конфигурации приложения на локальном компьютере.

1. Установите [Vagrant](https://www.vagrantup.com/).
2. Откройте терминал и перейдите в папку madeasy.
3. Установите плагин ```vagrant plugin install vagrant-hostmanager```
4. Поднимите виртуальную машину ```vagrant up``` и сделайте перерыв.

На этом всё. После этих действий приложение будет доступно по адресу http://schedule.dev на базе сервера Apache. Для создания собственной конфигурации воспользуйтесь [PuPHPet](https://www.puphpet.com/)
