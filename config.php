<?php
define("APP_PATH",  dirname(__FILE__));

$_APPC = array(
	'APP_NAME'			=> 'huodong',
	'APP_VER'			=> '1.0',
	'CHECK_HOST'		=> true,
);

$_C = array(

'dev' => array(
	'DEPLOY'			=> false,
	'COOKIE_PATH'		=> '/',
	'COOKIE_DOMAIN'		=> '',
	'LOG_PATH'			=> '',
	'DB'				=> array(
			'DSN'		=> '',
			'USR'		=> 'user',
			'PWD'		=> 'user'
	),
	'CHECK_HOST'		=> false,
),

'test' => array(
	'DEPLOY'			=> false,
	'COOKIE_PATH'		=> '/',
	'COOKIE_DOMAIN'		=> '',
	'LOG_PATH'			=> '',
	'DB'				=> array(
			'DSN'		=> 'mysql:host=localhost;dbname=test',
			'USR'		=> 'user',
			'PWD'		=> 'user'
	),
	'CHECK_HOST'		=> false,
),

'prod' => array(
	'DEPLOY'			=> true,
	'COOKIE_PATH'		=> '/',
	'COOKIE_DOMAIN'		=> '',
	'LOG_PATH'			=> '',
	'DB'				=> array(
			'DSN'		=> 'mysql:host=localhost;dbname=test',
			'USR'		=> 'user',
			'PWD'		=> 'user'
	),
	'CHECK_HOST'		=> true,
)

);


$_ENV = include  APP_PATH . '/env.php';
$current_env = $_ENV['current'];
$config = $_C[$current_env];
$config = array_merge($_APPC, $config, $_ENV);
