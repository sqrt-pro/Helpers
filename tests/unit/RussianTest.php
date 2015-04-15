<?php

use SQRT\Helpers\Russian;

class RussianTest extends PHPUnit_Framework_TestCase
{
  /**
   * https://developer.mozilla.org/en-US/docs/Mozilla/Localization/Localization_and_Plurals#List_of_Plural_Rules
   * Plural rule #7 (3 forms)
   * Families: Slavic (Belarusian, Bosnian, Croatian, Serbian, Russian, Ukrainian)
   * ends in 1, excluding 11: 1, 21, 31, 41, 51, 61, 71, 81, 91, 101, 121, ...
   * ends in 2-4, excluding 12-14: 2, 3, 4, 22, 23, 24, 32, 33, 34, 42, 43, ...
   * everything else: 0, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, ...
   *
   * @dataProvider dataPlural
   */
  function testPlural($num, $exp)
  {
    $this->assertEquals($exp, Russian::Plural($num, 'лошадь', 'лошади', 'лошадей'));
  }

  function dataPlural()
  {
    return array(
      array(1, 'лошадь'),
      array(21, 'лошадь'),
      array(4, 'лошади'),
      array(22, 'лошади'),
      array(0, 'лошадей'),
      array(5, 'лошадей'),
    );
  }

  /**
   * @dataProvider dataPluralSprintf
   */
  function testPluralSprintf($num, $exp)
  {
    $this->assertEquals($exp, Russian::Plural($num, '%s лошадь', '%03d лошади', '%01.2f лошадей'));
  }

  function dataPluralSprintf()
  {
    return array(
      array(1, '1 лошадь'),
      array(2, '002 лошади'),
      array(5, '5,00 лошадей'),
    );
  }

  /**
   * @dataProvider dataDate
   */
  function testDateFormat($format, $timestamp, $date = null)
  {
    $exp = strftime($format, $timestamp);

    $this->assertEquals($exp, Russian::DateFormat($format, $date));
  }

  function dataDate()
  {
    return array(
      array('%e %B %Y - %A', strtotime('2014-01-01'), strtotime('2014-01-01')),
      array('%d %b, %a.', strtotime('2015-12-05'), '5.12.2015'),
      array('%d.%m.%Y', time()),
    );
  }

  function testDateShort()
  {
    $d = '12.04.2015 12:45';
    $t = strtotime($d);

    $this->assertEquals(strftime('%d %b %Y', $t), Russian::DateShort($d));
    $this->assertEquals(strftime('%d %b %Y %k:%M', $t), Russian::DateShort($d, true));
  }

  function testDate()
  {
    $d = '12.04.2015 12:45';
    $t = strtotime($d);

    $this->assertEquals(strftime('%d %B %Y', $t), Russian::Date($d));
    $this->assertEquals(strftime('%d %B %Y %k:%M', $t), Russian::Date($d, true));
  }

  function testDayOfWeek()
  {
    $d = '12.04.2015 12:45';
    $t = strtotime($d);

    $this->assertEquals(strftime('%A', $t), Russian::DayOfWeek($d));
    $this->assertEquals(strftime('%a', $t), Russian::DayOfWeek($d, true));
  }

  function testMonth()
  {
    $d = '12.04.2015 12:45';
    $t = strtotime($d);

    $this->assertEquals(strftime('%OB', $t), Russian::Month($d));
    $this->assertEquals(strftime('%b', $t), Russian::Month($d, true));
  }

  public static function setUpBeforeClass()
  {
    date_default_timezone_set('Europe/Moscow');
    Russian::SetLocale();
  }
}