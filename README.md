# SQRT\Helpers

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