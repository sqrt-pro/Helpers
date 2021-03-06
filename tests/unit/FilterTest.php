<?php

use SQRT\Helpers\Filter;

class FilterTest extends PHPUnit_Framework_TestCase
{
  /**
   * @dataProvider dataFilter
   */
  function testFilter($val, $filter, $result = null, $default = false)
  {
    if (is_null($result)) {
      $result = $val;
    }

    $this->assertEquals($result, Filter::Value($val, $filter, $default));
  }

  function dataFilter()
  {
    $f = function (&$var) {
      $var .= '!!!';

      return true;
    };

    return array(
      // RegExp
      array(123, '!^[a-z]+$!', false),
      array('ololo', '!^[a-z]+$!'),

      // Callable
      array(123, 'is_numeric'),
      array('ololo', 'is_numeric', false),
      array('ololo', $f, 'ololo!!!'),

      // Список опций
      array(123, array(123, 12, 1)),
      array(123, array('one', 'two'), false),

      // Значения по-умолчанию
      array('ololo', 'is_numeric', 123, 123),
      array('', null, ''),
      array(0, null, 0, 123)
    );
  }

  function testFilterArray()
  {
    $arr = array('ololo', 'wow', 123);
    $this->assertEquals(array(2 => 123), Filter::Arr($arr, 'is_numeric'), 'Ключи массива сохраняются');

    $f = function(&$var) {
      if ($var > 1) {
        return false;
      }

      if ($var > 0) {
        $var = 'ololo';
      }

      return true;
    };

    $arr = array(0, false, 1, 2, 3);
    $exp = array(0, false, 'ololo');

    $this->assertEquals($exp, $res = Filter::Arr($arr, $f), 'Нулевые значения корректно обрабатываются');
    $this->assertFalse($res[1], 'Типы не изменились');
  }
}