<?php
// This file generated by Propel 1.7.0 convert-conf target
// from XML runtime conf file F:\Development\opt\xampp\htdocs\accountmanager.t.com\module\Propel\runtime-conf.xml
$conf = array (
  'datasources' => 
  array (
    'account_manager' => 
    array (
      'adapter' => 'mysql',
      'connection' => 
      array (
        'dsn' => 'mysql:host=localhost;dbname=account_manager',
        'user' => 'demo',
        'password' => '123456',
        'settings' => 
        array (
          'charset' => 
          array (
            'value' => 'utf8',
          ),
        ),
      ),
      'slaves' => 
      array (
        'connection' => 
        array (
          0 => 
          array (
            'dsn' => 'mysql:host=localhost;dbname=account_manager',
            'user' => 'demo',
            'password' => '123456',
            'settings' => 
            array (
              'charset' => 
              array (
                'value' => 'utf8',
              ),
            ),
          ),
          1 => 
          array (
            'dsn' => 'mysql:host=localhost;dbname=account_manager',
            'user' => 'demo',
            'password' => '123456',
            'settings' => 
            array (
              'charset' => 
              array (
                'value' => 'utf8',
              ),
            ),
          ),
        ),
      ),
    ),
    'default' => 'account_manager',
  ),
  'generator_version' => '1.7.0',
);
$conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classmap-zf2-domain-model-conf.php');
return $conf;