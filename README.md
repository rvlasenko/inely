[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Exoticness/list/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/list/?branch=master) [![Codacy Badge](https://www.codacy.com/project/badge/207cb7efb78445e2b063c10c049a3824)](https://www.codacy.com/app/roof1rst/list) [![Build Status](https://scrutinizer-ci.com/g/Exoticness/list/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Exoticness/list/build-status/master) [![Requirements Status](https://requires.io/github/Exoticness/list/requirements.svg?branch=master)](https://requires.io/github/Exoticness/list/requirements/?branch=master) [![Code Climate](https://img.shields.io/codeclimate/github/kabisaict/flow.svg)]() 

Здесь будет описание проекта
 

Особенности проекта
--------
### BACKEND
- Прекрасная open source тема для админки AdminLTE 2
- I18N + 3 трансляции: Английский, Русский, Украинский
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
- Imperavi Reactor (http://imperavi.com/redactor, https://github.com/asofter/yii2-imperavi-redactor), 
- Elfinder (http://elfinder.org, https://github.com/MihailDev/yii2-elfinder)
- Nginx конфигурация

### FRONTEND
- Адаптивный дизайн
- Bootstrap 3.1
- 8 цветовых схем
- HTML5/CSS3 разметка
- Форма контакной связи
- Видео на заднем фоне
- Parallax
- Динамические кнопки

Демонстрация
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

Требования
------------

Минимальные требования подразумевают, что веб-сервер поддерживает PHP 5.4

Установка и развёртывание
------------

### Перед установкой
Если на вашем ПК нет [Composer](http://getcomposer.org/), установите его следуя инструкциям на [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

После завершения добавьте плагин для управления ассетами composer-asset-plugin
```bash
composer global require "fxp/composer-asset-plugin"
```


### GitHub

Клонируйте репозиторий
```bash
git clone https://github.com/Exoticness/list.git
```

После завершения запустите команду в консоли
```
cd /path/to/list/
composer install
```

Процесс конфигурации приложения включает в себя:

1. Инициализация приложения
2. Подготовка веб-сервера
3. Конфигурирование среды разработки
4. Применение миграций
5. Инициализация RBAC

#### 1. Инициализация приложения
```php
cd /path/to/list/
php init
```

#### 2. Веб-сервер

Сперва необходимо настроить виртуальные хосты на своем веб-сервере:

`example.dev` => `/path/to/list/frontend/web`

`backend.example.dev` => `/path/to/list/backend/web`

`storage.examplet.dev` => `/path/to/list/storage`

**NOTE:** Также можно использовать файл `nginx.conf` расположенный в корне проекта.

#### 3. Настройка среды
Настройка параметров в файле `.env`

##### 3.1 База данных
Внесите собственные данные в `.env`:
```php
DB_DSN           = mysql:host=127.0.0.1;port=3306;dbname=list
DB_USERNAME      = user
DB_PASSWORD      = password
```
**NOTE:** Yii не будет создавать базу данных, это должно быть сделано вручную, прежде чем вы можете получить доступ к ней.

##### 3.2 URL-адреса приложения
Установите адреса приложения в файле `.env` идентичные виртуальным хостам

```php
FRONTEND_URL    = http://example.dev
BACKEND_URL     = http://backend.example.dev
STORAGE_URL     = http://storage.example.dev
```
#### 4. Применение миграций

```php
php console/yii migrate
```

#### 5. Инициализирование RBAC конфигурации

```php
php console/yii rbac/init
```
**IMPORTANT: не применив эту команду вы НЕ сможете авторизироваться в админке**
