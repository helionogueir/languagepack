<?php

namespace helionogueir\languagepack\tests\unit;

use PHPUnit\Framework\TestCase;
use helionogueir\languagepack\Lang;

class LangText extends TestCase {

  public function testConfiguration() {
    $this->assertNull(Lang::configuration("en-US"));
  }

  public function testAddRoot() {
    $this->assertNull(Lang::addRoot("helionogueir/languagepack", dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "core"));
  }

  public function testGet() {
    Lang::configuration("en-US");
    Lang::addRoot("helionogueir/languagepack", dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "core");
    $text = "Language Pack Test GET";
    $this->assertEquals($text, Lang::get("languagepack:test:get", "helionogueir/languagepack", Array("method" => "GET")));
  }

  public function testGetFail() {
    Lang::configuration("en-US");
    Lang::addRoot("helionogueir/languagepack", dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "core");
    $tag = "languagepack:test:get:fail";
    $this->assertEquals($tag, Lang::get($tag, "helionogueir/languagepack"));
  }

}
