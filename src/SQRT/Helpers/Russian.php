<?php

namespace SQRT\Helpers;

class Russian
{
  /**
   * Формирование строки на основании числа.
   * Каждая из форм является sprintf шаблоном, с подстановкой первого параметра - числа
   */
  public static function Plural($number, $one, $two, $five)
  {
    $form = $number % 10 == 1 && $number % 100 != 11
      ? $one
      : ($number % 10 >= 2 && $number % 10 <= 4 && ($number % 100 < 10 || $number % 100 >= 20)
        ? $two
        : $five);

    return sprintf($form, $number);
  }

  /**
   * Форматирование даты с помощью strfttime
   * $date может быть unix-timestamp или произвольной строкой
   */
  public static function DateFormat($format, $date = null)
  {
    if (!empty($date) && !is_int($date)) {
      $date = strtotime($date);
    }

    return strftime($format, $date ?: time());
  }

  /** Дата с сокращенным названием месяца */
  public static function DateShort($date = null, $with_time = false)
  {
    return static::DateFormat('%d %b %Y' . ($with_time ? ' %k:%M' : ''), $date);
  }

  /** Дата с полным названием месяца */
  public static function Date($date, $with_time = false)
  {
    return static::DateFormat('%d %B %Y' . ($with_time ? ' %k:%M' : ''), $date);
  }

  /** День недели для указанной даты */
  public static function DayOfWeek($date = null, $short = false)
  {
    return static::DateFormat($short ? '%a' : '%A', $date);
  }

  /** Склонение месяца для указанной даты */
  public static function Month($date = null, $short = false)
  {
    return static::DateFormat($short ? '%b' : '%OB', $date);
  }

  /** Глобальная установка русской локали */
  public static function SetLocale()
  {
    return setlocale(LC_ALL, 'ru_RU.UTF-8');
  }
}