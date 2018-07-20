<p align="center">
    <a href="https://github.com/cjtterabytesoft/toolbar" target="_blank">
        <img src="https://farm1.staticflickr.com/887/27875183957_69a3645a56_q.jpg" height="100px;">
    </a>
    <h1 align="center">Widget ToolBar Gridview. [Yii 3.0/Bootstrap4]</h1>
    <br>
</p>

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
[![Build Status](https://scrutinizer-ci.com/g/cjtterabytesoft/toolbar/badges/build.png?b=master)](https://scrutinizer-ci.com/g/cjtterabytesoft/toolbar/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cjtterabytesoft/toolbar/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cjtterabytesoft/toolbar/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/cjtterabytesoft/toolbar/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![Maintainability](https://api.codeclimate.com/v1/badges/074b60f90f8594dc1bb8/maintainability)](https://codeclimate.com/github/cjtterabytesoft/toolbar/maintainability)
[![Total Downloads](https://poser.pugx.org/cjtterabytesoft/toolbar/downloads)](https://packagist.org/packages/cjtterabytesoft/toolbar)



DIRECTORY STRUCTURE
-------------------

```
src/                contains widgets custom application
tests/              contains test widgets
```

REQUIREMENTS
------------

The minimum requirement by this extension that your Web server supports PHP 7.1.

INSTALLATION
------------

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

[Installation Instructions.](docs/getting-started.md) 

CONFIGURATION
-------------

### WEB SERVER SUPPORT:

- Apache.
- Nginx.
- OpenLiteSpeed.

DOCUMENTATION STYLE GUIDE
-------------------------

This extension follows the documentation described in [Yii Documentation Style Guide](https://github.com/yiisoft/yii2/blob/master/docs/documentation_style_guide.md).


### HOW TO USE RULES CODING STANDARD WITH VSCODE:

- Install squizlabs/php_codesniffer, friendsofphp/php-cs-fixer global:

```
composer global require "squizlabs/php_codesniffer >=2.3.1 <3.0"
composer global require friendsofphp/php-cs-fixer
```

- Copy directory /vendor/yiisoft/yii2-conding-standards/Yii2 to directory path composer global example windows C:\Users\user\AppData\Roaming\Composer\vendor\squizlabs\php_codesniffer\CodeSniffer\Standards

- Add config Vscode:

```
{
    "editor.detectIndentation": false,
    "files.eol": "\n",
    "phpcs.standard": "Yii2",
    "php-cs-fixer.executablePath": "php-cs-fixer",
    "php-cs-fixer.executablePathWindows": "php-cs-fixer.bat",
    "php-cs-fixer.config": ".php_cs;.php_cs.dist",
    "php-cs-fixer.allowRisky": true,
}
```

**LICENSE:**

[![License](https://poser.pugx.org/cjtterabytesoft/toolbar/license)](https://github.com/cjtterabytesoft/toolbar/blob/master/LICENSE.md) 