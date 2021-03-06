<?php
/*
Plugin Name: Плагин для изменения настроек почты
Description: Плагин для изменения настроек почты. Позволяет редактировать параметры почты для WP писем и для WooCommerce писем.
Version: 0.1
Author: shurup
*/

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}


define('SS_MAILER_PATH', __FILE__);

spl_autoload_register(function($classname) {
	if(!strpos($classname, 'SS_MailOptions')>0) {
		return;
	}
	$classname = explode('\\', $classname);
	$classname = array_pop($classname);
	$classfile = dirname(SS_MAILER_PATH).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$classname.'.php';
	if(file_exists($classfile)) {
		require_once($classfile);
	}
	return;
});

try {
	$plugin = new SS_Mailoptions\SS_MailOptionsInit();
	$plugin->registerInstallHooks();
	if($plugin->isActiveted()){
		$plugin->registerPages();
		$plugin->registerMailHooks();
	}
} catch(SS_Mailoptions\SS_MailerException $e) {
	throw new Exception($e->getMessage());
}


