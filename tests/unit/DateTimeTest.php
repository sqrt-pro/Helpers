<?php

use SQRT\Helpers\DateTime;
use SQRT\Helpers\Russian;

class DateTimeTest extends PHPUnit_Framework_TestCase
{
  public function testDefaultFormat()
  {
    $d = new DateTime('2015-06-01 12:45');

    $this->assertEquals('01.06.2015 12:45', $d->formatDefault(), 'Форматирование по-умолчанию');
    $this->assertEquals('01.06.2015 12:45', (string) $d, 'Объект приведенный к строке');

    $d->setDefaultFormat('Y-m-d');

    $this->assertEquals('2015-06-01', $d->formatDefault(), 'Изменение формата по-умолчанию');
  }

  public function testRussianDate()
  {
    $str = '2015-06-01 12:45';
    $d = new DateTime($str);

    $this->assertEquals(Russian::DateShort($str), $d->formatRussianShort(), 'Краткая дата');
    $this->assertEquals(Russian::DateShort($str, true), $d->formatRussianShort(true), 'Краткая дата с временем');

    $this->assertEquals(Russian::Date($str), $d->formatRussian(), 'Полная дата');
    $this->assertEquals(Russian::Date($str, true), $d->formatRussian(true), 'Полная дата с временем');
  }

  public function testAddDays()
  {
    $d = new DateTime('01.01.2015');

    $d->addDays(3);
    $this->assertEquals('04.01.2015', $d->format('d.m.Y'), '+3 дня');

    $d->addDays(-7);
    $this->assertEquals('28.12.2014', $d->format('d.m.Y'), '-7 дней');
  }

  public function testAddMonths()
  {
    $d = new DateTime('31.01.2015', null, 'd.m.Y');

    $d->addMonths(1);
    $this->assertEquals('03.03.2015', $d->formatDefault(), '+1 месяц к концу января');

    $d->addMonths(-3);
    $this->assertEquals('03.12.2014', $d->formatDefault(), '-3 месяца');

    $d->setDate(2015, 1, 1);

    $d->addMonths(2);
    $this->assertEquals('01.03.2015', $d->formatDefault(), '+2 месяца от первого дня');
  }

  public function testAddYears()
  {
    $d = new DateTime('29.02.2012', null, 'd.m.Y');

    $d->addYears(1);
    $this->assertEquals('01.03.2013', $d->formatDefault(), '+1 год 29 февраля');

    $d->addYears(-7);
    $this->assertEquals('01.03.2006', $d->formatDefault(), '-7 лет');
  }

  public static function setUpBeforeClass()
  {
    date_default_timezone_set('Europe/Moscow');
    Russian::SetLocale();
  }
}