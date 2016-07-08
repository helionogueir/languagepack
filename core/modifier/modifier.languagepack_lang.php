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
  $root = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
  require_once $root
      . DIRECTORY_SEPARATOR . 'core'
      . DIRECTORY_SEPARATOR . 'environment'
      . DIRECTORY_SEPARATOR . 'Autoload.class.php';
  core\environment\Autoload::make($root);
  return \helionogueir\languagepack\Lang::get(new helionogueir\typeBoxing\type\String($identify), new helionogueir\typeBoxing\type\String($package), $data);
}
