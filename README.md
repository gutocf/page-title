# PageTitleComponent

[![Build Status](https://img.shields.io/github/actions/workflow/status/gutocf/page-title/ci.yml?branch=master)](https://github.com/gutocf/page-title/actions?query=workflow%3ACI+branch%3Amaster)
[![Coverage Status](https://img.shields.io/codecov/c/github/gutocf/page-title.svg?style=flat-square)](https://codecov.io/github/gutocf/page-title)
[![Latest Stable Version](https://poser.pugx.org/gutocf/page-title/v/stable.svg)](https://packagist.org/packages/gutocf/page-title)
[![Total Downloads](https://img.shields.io/packagist/dt/gutocf/page-title.svg?style=flat-square)](https://packagist.org/packages/gutocf/page-title)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://packagist.org/packages/gutocf/page-title)
[![PHPStan](https://img.shields.io/badge/PHPStan-Level%207-brightgreen.svg?style=flat-square&logo=php)](https://shields.io/#/)
[![Packagist Version](https://img.shields.io/packagist/v/gutocf/page-title?style=flat-square)](https://packagist.org/packages/gutocf/page-title)


## Requirements
 - PHP 8.1+
 - CakePHP 5.0+

Note: For using with PHP 8.0 and CakePHP 4.3+ check out version 1.1.1

## Installation

Install the plugin with composer

    composer require gutocf/page-title

### Plugin load

    bin/cake plugin load PageTitle

### Component load

Load the component in *App\Controller\AppController*:

```php
$this->loadComponent('Gutocf/PageTitle.PageTitle', [
   'default' => 'MyApp Name', //Default page title - optional, default = null
   'var' => 'var_name_for_views', //Var name to set at view - optional, default = title
   'separator' => ' :: ', //Titles separator - optional, default = ' / '
   'reverseOrder' => true, //Display titles in reverse order of inclusion - optional, default = true
]);
```
You need to load the component in controllers or application's AppController (recomended).

## Usage

To add titles to your page, simply call PageTitle::add method with one or more parameters:
```php
$this->PageTitle->add('Articles', 'Add');
```

In *Controller.beforeRender* event, the component will set a variable with *$config['var']* name for use in the views and templates, in this example **Add :: Articles :: MyApp Name** (Or **MyApp Name :: Articles :: Add** if *reverseOrder* option is false). You can set the page title by including this code in the template file *src/templates/default.php*

```php
<head>
   <title><?= $this->get('var_name_for_views') ?></title>
</head>
```
