<?php

namespace helionogueir\languagepack;

use helionogueir\typeBoxing\type\String;
use helionogueir\foldercreator\tool\Path;
use helionogueir\typeBoxing\type\json\Decode;

/**
 * Lang pattern:
 * - Control language packages;
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class Lang {

  const SMARTY_MODIFIER_PATH = __DIR__ . DIRECTORY_SEPARATOR . 'modifier';

  private static $locale = 'en-US';
  private static $root = __DIR__;

  public function __construct() {
    return false;
  }

  public static final function configuration(String $locale, String $root = null) {
    if (!$locale->isEmpty()) {
      Lang::$locale = "{$locale}";
    }
    if (!$root->isEmpty()) {
      Lang::$root = "{$root}";
    }
    return null;
  }

  /**
   * Get language:
   * - Identify lang and package and return text;
   * 
   * @param helionogueir\typeBoxing\type\String $identify Identify of language
   * @param helionogueir\typeBoxing\type\String $package Package of language
   * @param Array $data Data repalce of language
   * @return helionogueir\typeBoxing\type\String Return text langauge
   */
  public static final function get(String $identify, String $package, Array $data = null) {
    $text = $identify;
    if (!$identify->isEmpty()) {
      if ($language = self::loadPackage($package)) {
        if (isset($language->{$identify})) {
          $text = self::replace(new String($language->{$identify}), $data);
        }
      }
    }
    return $text;
  }

  /**
   * Load package:
   * - Identify and load package language;
   * 
   * @param helionogueir\typeBoxing\type\String $package Package of language
   * @return stdClass Return package of language
   */
  private static function loadPackage(String $package) {
    $language = null;
    if (!$package->isEmpty()) {
      $filename = Lang::$root
          . DIRECTORY_SEPARATOR . Path::replaceOSSeparator($package)
          . DIRECTORY_SEPARATOR . 'lang'
          . DIRECTORY_SEPARATOR . Lang::$locale . ".json";
      if (file_exists($filename)) {
        $decode = new Decode(file_get_contents($filename));
        $language = $decode->getObject();
      }
    }
    return $language;
  }

  /**
   * Relace data:
   * - Replace data in language;
   * 
   * @param helionogueir\typeBoxing\type\String $text Text language
   * @param helionogueir\typeBoxing\type\String $package Package of language
   * @param Array $data Data repalce of language
   * @return helionogueir\typeBoxing\type\String Return text langauge
   */
  private static function replace(String $text, Array $data = null) {
    if (!$text->isEmpty() && count($data)) {
      $metaText = $text;
      foreach ($data as $key => $value) {
        $metaText = preg_replace("#(\{data\:{$key}\})#si", $value, $metaText);
      }
      $text = new String($metaText);
    }
    return $text;
  }

}
