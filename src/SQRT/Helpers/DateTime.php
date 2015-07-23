<?php

namespace SQRT\Helpers;

use DateTimeZone;

class DateTime extends \DateTime
{
  protected $default_format = 'd.m.Y H:i';

  public function __construct($time = 'now', DateTimeZone $timezone = null, $default_format = null)
  {
    if (!is_null($default_format)) {
      $this->default_format = $default_format;
    }

    parent::__construct($time, $timezone);
  }

  function __toString()
  {
    return $this->formatDefault();
  }

  /**
   * Добавить к дате дни
   * @return static
   */
  public function addDays($number)
  {
    return $this->addInterval($number, 'D');
  }

  /** Добавить к дате месяцы */
  public function addMonths($number)
  {
    return $this->addInterval($number, 'M');
  }

  /** Добавить к дате годы */
  public function addYears($number)
  {
    return $this->addInterval($number, 'Y');
  }

  /**
   * Прибавить или вычесть из даты $number единиц $period
   * $period - формат разрядности интервала DateInterval
   */
  public function addInterval($number, $period)
  {
    $int = new \DateInterval(sprintf('P%d%s', abs($number), $period));

    if ($number > 0) {
      $this->add($int);
    } elseif ( $number < 0) {
      $this->sub($int);
    }

    return $this;
  }

  /** Отображение даты с полным русским месяцем */
  public function formatRussian($with_time = false)
  {
    return Russian::Date($this->getTimestamp(), $with_time);
  }

  /** Отображение даты с кратким русским месяцем */
  public function formatRussianShort($with_time = false)
  {
    return Russian::DateShort($this->getTimestamp(), $with_time);
  }

  /** Форматирование строки в формат по-умолчанию */
  public function formatDefault()
  {
    return $this->format($this->default_format);
  }

  /** Формат для отображения даты по-умолчанию */
  public function getDefaultFormat()
  {
    return $this->default_format;
  }

  /** Установить формат отображения даты по-умолчанию */
  public function setDefaultFormat($default_format)
  {
    $this->default_format = $default_format;
  }
}