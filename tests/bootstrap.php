<?php
declare(strict_types=1);

use Cake\Core\Configure;

require dirname(__DIR__) . '/vendor/autoload.php';

session_id('cli');

Configure::write('App.encoding', 'utf-8');
