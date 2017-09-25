# Bxcontent

[![Latest Stable Version](https://poser.pugx.org/marvin255/bxcontent/v/stable.png)](https://packagist.org/packages/marvin255/bxcontent)
[![Total Downloads](https://poser.pugx.org/marvin255/bxcontent/downloads.png)](https://packagist.org/packages/marvin255/bxcontent)
[![License](https://poser.pugx.org/marvin255/bxcontent/license.svg)](https://packagist.org/packages/marvin255/bxcontent)
[![Build Status](https://travis-ci.org/marvin255/bxcontent.svg?branch=master)](https://travis-ci.org/marvin255/bxcontent)



## Установка

**С помощью [Composer](https://getcomposer.org/doc/00-intro.md)**

1. Добавьте в ваш composer.json в раздел `require`:

    ```javascript
    "require": {
        "marvin255/bxcontent": "*"
    }
    ```

2. Если требуется автоматическое обновление библиотеки через composer, то добавьте в раздел `scripts`:

    ```javascript
    "scripts": [
        {
            "post-install-cmd": "\\marvin255\\bxcontent\\installer\\Composer::injectModule",
            "post-update-cmd": "\\marvin255\\bxcontent\\installer\\Composer::injectModule",
        }
    ]
    ```

3. Выполните в консоли внутри вашего проекта:

    ```
    composer update
    ```

4. Если пункт 2 не выполнен, то скопируйте папку `vendors/marvin255/bxcontent/marvin255.bxcontent` в папку `local/modules` вашего проекта.

5. Установите модуль в административном разделе 1С-Битрикс "Управление сайтом".

**Обычная**

1. Скачайте архив с репозиторием.
2. Скопируйте папку `marvin255.bxcontent` из архива репозитория в папку `local/modules` вашего проекта.
3. Установите модуль в административном разделе 1С-Битрикс "Управление сайтом".
