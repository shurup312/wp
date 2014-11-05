<?php
/*
Plugin Name: Тестовый плагин
Plugin URI: http://wp
Description: Текст описания плагина, епте, практикуемся.
Version: 0.1
Author: shurup
Author URI: http://wp
License: EPL
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * @property string path
 * @property SS_MailOptionsInstaller installer
 * @property SS_MailOptionsPages pages
 */
class SS_MailOptionsInit {

	private $path;
	private $pages;
	private $installer;


	public function __construct () {
		$this->setParams();
		spl_autoload_register($this->autoload());
	}

	private function setParams () {
		$this->path = __FILE__;
		$this->installer = new SS_MailOptionsInstaller();
		$this->pages = new SS_MailOptionsPages();
	}

	public function registerInstallHooks () {
		$this->setInstaller();
		$this->setUninstaller();
	}
	public function registerPages () {
		$this->pages->addMenuItems();
	}
	public function setInstaller () {
		register_activation_hook( $this->path, array( $this->installer, 'install' ));
	}
	public function setUninstaller () {
		register_deactivation_hook($this->path, array($this->installer, 'uninstall'));
	}

	public function registerMailHooks () {

	}

	private function autoload ($className) {
		echo "<pre>";
		print_r($className);
		echo "</pre>";
		die();
	}
}

class SS_MailOptionsInstaller {

	public function install () {
	}

	public function uninstall (){
	}
}


class SS_MailOptionsPages {
	private $menuID = 'mailer_menu';
	public function addMenuItems () {
		if (!is_admin()) {
			return true;
		}
		add_action(
			'admin_menu',
			function () {
				add_menu_page(
					'Почтовик',
					'Почтовик',
					$this->menuID,
					'mailer/index',
					array (
						$this,
						'actionIndex'
					)
				);
			}
		);
	}

	public function actionIndex () {

	}

	public function actionList () {
	}


}



$plugin = new SS_MailOptionsInit();
$plugin->registerInstallHooks();
$plugin->registerPages();
$plugin->registerMailHooks();

