# [Language Pack](https://github.com/helionogueir/languagepack)

A libraty to manipulate language package.

## Installation

Composer (https://getcomposer.org/) and (https://packagist.org/)
```sh
composer require helionogueir/languagepack
```
------
## Usage

### helionogueir\languagepack\Lang

Define how to language package to be work
```php
use helionogueir\languagepack\Lang;
Lang::configuration("en-US");
Lang::addRoot("helionogueir/languagepack", "./languagepack/core");
echo Lang::get("languagepack:test:get", "helionogueir/languagepack", Array("method" => "Usage"));
```
------
### smarty_modifier_languagepack_lang
#### Smarty Modifiers (http://www.smarty.net/docs/en/plugins.modifiers.tpl) and (http://www.smarty.net/)

Define how to smarty_modifier_languagepack_lang to be work
```php
/* Configuration Smarty */
use Smarty;
$smarty = new Smarty();
$smarty->addPluginsDir("./languagepack/core/modifier");
```
```php
/* Template (.tpl) smarty_modifier_languagepack_lang Called  */
<p>{"languagepack:test:get"|languagepack_lang:"helionogueir/languagepack":["method" => "Usage"]}</p>
```
------
## TDD (Test Driven Development)

PHPUnit (https://phpunit.de/)
```sh
phpunit -c ./languagepack/tests/unit.xml
```
