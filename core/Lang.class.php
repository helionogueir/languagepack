<?php

namespace helionogueir\languagepack;

use stdClass;
use SplFileObject;
use helionogueir\foldercreator\tool\Path;
use helionogueir\filecreator\data\ReplaceText;

/**
 * - Manipulate language package
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.1.0
 */
abstract class Lang {

  /**
   * - Define standard locate
   */
  const STANDARD_LOCALE = 'en-US';

  private static $locale = Lang::STANDARD_LOCALE;
  private static $root = Array();

  /**
   * - Define configuration locate of language
   * @param string $locale Locate name of language
   * @return null
   */
  public static final function configuration(string $locale) {
    if (!empty($locale)) {
      Lang::$locale = $locale;
    } else {
      Lang::$locale = Lang::STANDARD_LOCALE;
    }
    return null;
  }

  /**
   * - Define root of find of packages
   * @param string $package Root name of package language
   * @param string $path Pathname of package language
   * @return null
   */
  public static final function addRoot(string $package, string $path) {
    if (!empty($package) && !empty($path)) {
      $dirname = realpath(Path::replaceOSSeparator($path));
      if (is_dir($dirname)) {
        Lang::$root[$package] = $dirname;
      }
    }
    return null;
  }

  /**
   * - Identify TAG and package, and return text
   * @param string $identify TAG identify language
   * @param string $package Package language
   * @param Array $data Data repalce language
   * @return null
   */
  public static final function get(string $identify, string $package, Array $data = null): string {
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
   * - Identify package and load package language
   * @param string $package Path name package language 
   * @return stdClass Object with language translate
   */
  private static function loadPackage(string $package): stdClass {
    $language = new stdClass();
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
          $language = (JSON_ERROR_NONE == json_last_error()) ? $decode : $language;
        }
      }
    }
    return $language;
  }

  /**
   * - Select package defined in configuration, case not exist package select standard package
   * @param string $pathname Pathname of package language
   * @return sting Pathname of package language
   */
  private static function selectPackage(string $pathname): string {
    $filename = $pathname . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . Lang::$locale . ".json";
    if (file_exists($filename)) {
      $pathname = $filename;
    } else {
      $pathname .= DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . Lang::STANDARD_LOCALE . ".json";
    }
    return $pathname;
  }

  /**
   * - Replace TAGs in text
   * @param string $text Text with TAG(s)
   * @param string $data TAG(s) value(s)
   * @return sting Text TAG(s) replaced
   */
  private static function replace(string $text, Array $data = null): string {
    if (!empty($text) && count($data)) {
      if ($metaText = (new ReplaceText())->replace($text, $data)) {
        $text = $metaText;
      }
    }
    return $text;
  }

}
