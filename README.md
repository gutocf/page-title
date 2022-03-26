# PageTitleComponent

[![Build Status](https://img.shields.io/github/workflow/status/gutocf/page-title/CI/master?style=flat-square)](https://github.com/gutocf/page-title/actions?query=workflow%3ACI+branch%3Amaster)
[![Coverage Status](https://img.shields.io/codecov/c/github/gutocf/page-title.svg?style=flat-square)](https://codecov.io/github/gutocf/page-title)
[![Latest Stable Version](https://poser.pugx.org/gutocf/page-title/v/stable.svg)](https://packagist.org/packages/gutocf/page-title)
[![Total Downloads](https://img.shields.io/packagist/dt/gutocf/page-title.svg?style=flat-square)](https://packagist.org/packages/gutocf/page-title)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](https://packagist.org/packages/gutocf/page-title)

## Requirements
 - PHP 8.0
 - CakePHP 4.3.+

## Installation

Install the plugin with composer
    
    composer require gutocf/page-title
    
Load the plugin

    bin/cake plugin load PageTitle
    
Load the component

Load the component from App\Controller\AppController:

```php
$this->loadComponent('Gutocf/PageTitle.PageTitle', [
   'default' => 'Default Title', //optional, default = null
   'var' => 'var_name_for_views', //optional, default = title
   'separator' => ' | ', //optional, default = ' / '
]); 
```
 
## Usage

You will need to load the component in controllers or application AppController

On your controller methods simply call 
```php
$this->PageTitle->add('Articles', 'Add');
```

The component will set a variable with $config['var'] name for use in the views and templates. You can set the page title by include this code in your template file *src/templates/default.php*

```php
<head>
   <title><?= $this->get('title') ?></title>
</head>
```
