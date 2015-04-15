# SQRT\Helpers

[![Build Status](https://travis-ci.org/sqrt-pro/Helpers.svg?branch=master)](https://travis-ci.org/sqrt-pro/Helpers)
[![Coverage Status](https://coveralls.io/repos/sqrt-pro/Helpers/badge.svg?branch=master)](https://coveralls.io/r/sqrt-pro/Helpers?branch=master)
[![Latest Stable Version](https://poser.pugx.org/sqrt-pro/helpers/version.svg)](https://packagist.org/packages/sqrt-pro/helpers)
[![License](https://poser.pugx.org/sqrt-pro/helpers/license.svg)](https://packagist.org/packages/sqrt-pro/helpers)

Набор хелперов, используемых в фреймворке.

## Filter

Для фильтрации входных данных от пользователя необходимо проверять их допустимость и корректность.
Для фильтрации используются два метода:

    Filter::Value(&$val, $filter = null, $default = false)
    Filter::Arr($array, $filter = null, $default = array())

Параметр `$filter` может быть callable, regexp (регулярное выражение) или массив с допустимыми значениями.
Если значения не проходит по фильтру возвращается $default.

Для массивов фильтр работает несколько иначе, если часть значений массива не проходит фильтр, в выходном массиве эти 
значения убираются. Если после "чистки" значений не осталось - возвращается $default.

В фильтр значение передается по ссылке, т.е. при необходимости внутри фильтра-callable можно изменять значение.

## Container

Базовый класс Container реализует набор стандартных методов для работы с переменными внутри объекта, а также 
реализует интерфейс ArrayAccess:

* `get($name, $default = false)`
* `set($name, $value)`
* `has($name)`
* `append($name, $value)` - добавить значение в конец строки или массива 
* `prepend($name, $value)` - добавить значение в начало строки или массива
* `toArray()` - выгрузить значения в массив
* `fromArray(array $array, $clear = false)` - загрузить значения из массива
 
## Russian

Набор хелперов для работы с русским языком.

### Russian::Plural($number, $one, $two, $five)

Позволяет склонять строку, в зависимости от количества. 

~~~ php
Russian::Plural($num, 'лошадь', 'лошади', 'лошадей');
// $num = 1: лошадь
// $num = 3: лошади
// $num = 5: лошадей
~~~

В качестве строки для количества можно указывать шаблон sprintf для подстановки значения непосредственно в строку:

~~~ php
Russian::Plural($num, '%s лошадь', '%03d лошади', '%01.2f лошадей')
// $num = 1: 1 лошадь
// $num = 3: 003 лошади
// $num = 5: 5.00 лошадей
~~~

### Даты 

Набор методов, использующих функцию `strftime` для форматирования даты с учетом текущей локали.
Для установки глобальной локали можно использовать метод `Russian::SetLocale()`.

~~~ php
Russian::DateFormat('%e %B %Y - %A', '01.01.2014'); // 1 января 2014 - среда
Russian::Date('12.01.2015'); // 12 января 2015
Russian::Date('12.01.2015 12:45', true); // 12 января 2015 12:45
Russian::DateShort('12.04.2015'); // 12 апр 2015
Russian::DateShort('12.04.2015 12:45', true); // 12 апр 2015 12:45
Russian::Month('12.04.2015'); // апрель
Russian::Month('12.04.2015', true); // апр
Russian::DayOfWeek('12.04.2015'); // воскресенье
Russian::DayOfWeek('12.04.2015', true); // вс
~~~