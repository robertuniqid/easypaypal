<?php

namespace EasyPayPal;

/**
 * Class Lang
 * @package EasyPayPal
 * @author Andrei-Robert Rusu
 */
class Lang {

  CONST DEFAULT_LANGUAGE = 'en';

  private static $_languages = array(
    'en' => array(
      'item_name'         => 'Name',
      'item_quantity'     => 'Quantity',
      'item_price'        => 'Price per item',
      'item_price_total'  => 'Price',
      'checkout'          => 'Pay Now via PayPal'
    ),
  );

  public static function getInterfaceStrings($language = self::DEFAULT_LANGUAGE){
    return self::$_languages[$language];
  }

  public static function getInterfaceString($string_name, $language = self::DEFAULT_LANGUAGE){
    return isset(self::$_languages[$language][$string_name])
        ? self::$_languages[$language][$string_name] : $string_name;
  }

}