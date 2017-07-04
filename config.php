<?php
	/*
	okokokokokokokokokokokokokokokokokokokok
	*/
	date_default_timezone_set('America/Lima');
	
	define('ENVIRONMENT', 'development');

	if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev') {
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
	}
	define('THEME_NAME', 'admin');
	
	define('URI', __DIR__ . DIRECTORY_SEPARATOR );
	define('URI_MOD', URI . 'modulo' . DIRECTORY_SEPARATOR);
	define('URI_THEME', URI . 'template' . DIRECTORY_SEPARATOR . THEME_NAME . DIRECTORY_SEPARATOR);
	define('URL_PROTOCOL', 'http://'); // Protocolo
	define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
	define('URL_SUB_FOLDER', str_replace(URI_MOD, '', dirname($_SERVER['SCRIPT_NAME'])) . DIRECTORY_SEPARATOR);
	define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);
	define('URL_THEME', URL . 'template' . DIRECTORY_SEPARATOR . THEME_NAME . DIRECTORY_SEPARATOR);

	define('TITLE', 'Inicio | SAE');

	/*
		Configuracion de Bas de Datos
	*/
	define('DB_TYPE', 'mysql');
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'diana');
	//define('DB_NAME', 'SIARHDP');
	define('DB_USER', 'root');
	define('DB_PASS', '1234');
	define('DB_CHARSET', 'utf8');
	define('DB_TIME_ZONE', '-05:00');
	
	// API SMS
	define('SMS_SID', 'ACaac518685884fce00bfa346fd5be785e');
	define('SMS_TOKEN', '32e4c5d57537cdc6dab9304995b4f416');
	
	// Me
	//define('SMS_SID', 'AC044cd452979ffc1ba99f953148fdce3e');
	//define('SMS_TOKEN', '3372dd8325a25ef668fc10397135d9ad');
	
	// API MAIL
	define('MAIL_HOST', 'localhost');
	define('MAIL_USER', 'admin');
	define('MAIL_PASW', 'admin');
	define('MAIL_PORT', '25');
