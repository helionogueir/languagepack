<?php

/**
 * Smarty modifier plugin
 * Type:     modifier
 * Name:     languagepack_lang
 * Purpose:  Translate the information
 * 
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @param string $identify Identify of language
 * @param string $package Package of language
 * @param array $data Data repalce of language
 *
 * @return string
 */
function smarty_modifier_languagepack_lang($identify, $package, Array $data = array()) {
  require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . "autoload.php";
  return \helionogueir\languagepack\Lang::get($identify, $package, $data);
}
