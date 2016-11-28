<?php

namespace helionogueir\languagepack;

use SplFileObject;
use helionogueir\foldercreator\tool\Path;

/**
 * Lang control:
 * - Control language packages;
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class Lang {

  const STANDARD_LOCALE = 'en-US';

  private static $locale = Lang::STANDARD_LOCALE;
  private static $root = Array();

  /**
   * Block construct the class, because this class is static
   * @return false
   */
  public function __construct() {
    return false;
  }

  /**
   * Configuration lang:
   * - Set locate
   * 
   * @param string $locale Define locate of language
   * @return null
   */
  public static final function configuration(string $locale) {
    if (!empty($locale)) {
      Lang::$locale = "{$locale}";
    } else {
      Lang::$locale = Lang::STANDARD_LOCALE;
    }
    if (!empty($root)) {
      Lang::$root = "{$root}";
    }
    return null;
  }

  /**
   * Add root finder:
   * - Define root of find of packages
   * 
   * @param string $package Define root package of language
   * @param string $path Define path of root package of langauge
   * @return null
   */
  public static final function addRoot(string $package, string $path) {
    if (!empty($package) && !empty($path)) {
      $dirname = realpath($path);
      if (is_dir($dirname)) {
        Lang::$root["{$package}"] = "{$dirname}";
      }
    }
    return null;
  }

  /**
   * Get language:
   * - Identify lang and package and return text;
   * 
   * @param string $identify Identify of language
   * @param string $package Package of language
   * @param Array $data Data repalce of language
   * @return string Return text langauge
   */
  public static final function get(string $identify, string $package, Array $data = null) {
    $text = $identify;
    if (!empty($identify)) {
      if ($language = Lang::loadPackage($package)) {
        if (isset($language->{$identify})) {
          $text = Lang::replace($language->{$identify}, $data);
        }
      }
    }
    return $text;
  }

  /**
   * Load package:
   * - Identify and load package language;
   * 
   * @param string $package Package of language
   * @return stdClass Return package of language
   */
  private static function loadPackage(string $package) {
    $language = null;
    if (!empty($package)) {
      $filename = null;
      if ($packageData = explode(":", $package)) {
        if (!empty($packageData[0])) {
          $filename .= Lang::$root[$packageData[0]];
        }
        if (!empty($packageData[1])) {
          $filename .= DIRECTORY_SEPARATOR . $packageData[1];
        }
        $pathaname = Lang::selectPackage($filename);
        if (file_exists($pathaname)) {
          $pathaname = Path::replaceOSSeparator($pathaname);
          $decode = json_decode(file_get_contents((new SplFileObject($pathaname, "r"))->getPathname()));
          $language = (JSON_ERROR_NONE == json_last_error()) ? $decode : null;
        }
      }
    }
    return $language;
  }

  private static function selectPackage(string $filename) {
    $pathname = $filename . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . Lang::$locale . ".json";
    if (file_exists($pathname)) {
      $filename = $pathname;
    } else {
      $filename = $filename . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . Lang::STANDARD_LOCALE . ".json";
    }
    return $filename;
  }

  /**
   * Relace data:
   * - Replace data in language;
   * 
   * @param string $text Text language
   * @param string $package Package of language
   * @param Array $data Data repalce of language
   * @return string Return text langauge
   */
  private static function replace(string $text, Array $data = null) {
    if (!empty($text) && count($data)) {
      $metaText = $text;
      foreach ($data as $key => $value) {
        $metaText = preg_replace("#(\{data\:{$key}\})#si", $value, $metaText);
      }
      $text = $metaText;
    }
    return $text;
  }

}
