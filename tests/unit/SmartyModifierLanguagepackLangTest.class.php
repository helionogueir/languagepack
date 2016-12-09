<?php

use PHPUnit\Framework\TestCase;

class SmartyModifierLanguagepackLangTest extends TestCase {

  public function testModifier() {
    require_once dirname(dirname(dirname(__FILE__)))
        . DIRECTORY_SEPARATOR . "core"
        . DIRECTORY_SEPARATOR . "modifier"
        . DIRECTORY_SEPARATOR . "modifier.languagepack_lang.php";
    $text = "Language Pack Test GET";
    $this->assertEquals($text, smarty_modifier_languagepack_lang("languagepack:test:get", "helionogueir/languagepack", Array("method" => "GET")));
  }

  public function testModifierFail() {
    require_once dirname(dirname(dirname(__FILE__)))
        . DIRECTORY_SEPARATOR . "core"
        . DIRECTORY_SEPARATOR . "modifier"
        . DIRECTORY_SEPARATOR . "modifier.languagepack_lang.php";
    $tag = "languagepack:test:get:fail";
    $this->assertEquals($tag, smarty_modifier_languagepack_lang($tag, "helionogueir/languagepack"));
  }

}
