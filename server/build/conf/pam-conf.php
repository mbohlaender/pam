<?php
// This file generated by Propel 1.6.7 convert-conf target
// from XML runtime conf file D:\www\pam\server\runtime-conf.xml
$conf = array (
  'datasources' => 
  array (
    'pam' => 
    array (
      'adapter' => 'mysql',
      'connection' => 
      array (
        'dsn' => 'mysql:host=localhost;dbname=pam',
        'user' => 'pam',
        'password' => 'test',
      ),
    ),
    'default' => 'pam',
  ),
  'generator_version' => '1.6.7',
);
$conf['classmap'] = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classmap-pam-conf.php');
return $conf;