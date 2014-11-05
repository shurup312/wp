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

define('SS_MAILER_PATH', __FILE__);

/**
 * Класс инициализации плагина
 * @property string path
 * @property SS_MailOptionsInstaller installer
 * @property SS_MailOptionsPages pages
 */
class SS_MailOptionsInit {

	private $path;
	private $pages;
	private $installer;

	/**
	 * Конструктор
	 */
	public function __construct () {
		$this->setParams();
	}

	/**
	 * первоначальное задание значений параметрам экземпляра класса.
	 */
	private function setParams () {
		$this->installer = new SS_MailOptionsInstaller();
		$this->pages = new SS_MailOptionsPages();
	}

	/**
	 * Регистрация хуков для активации/деактивации плагинов.
	 */
	public function registerInstallHooks () {
		$this->setInstaller();
		$this->setUninstaller();
	}

	/**
	 * Регистрация пунктов меню.
	 */
	public function registerPages () {
		$this->pages->addMenuItems();
	}

	/**
	 * Регистрация хука для активации плагина
	 */
	public function setInstaller () {
		register_activation_hook( $this->path, array( $this->installer, 'install' ));
	}

	/**
	 * Регистрация хука для деактивации плагина
	 */
	public function setUninstaller () {
		register_deactivation_hook($this->path, array($this->installer, 'uninstall'));
	}

	/**
	 * Регистрация хуков для переопределения данных в отправляемых письмах.
	 */
	public function registerMailHooks () {
		add_filter('wp_mail', array($this, 'mailHook'));
	}

	public function mailHook ($attrs) {
		echo "<pre>";
		print_r($attrs);
		echo "</pre>";
		die();
	}
}

/**
 * Класс для выполнения методов при активации/деактивации плагина.
 * Class SS_MailOptionsInstaller
 */
class SS_MailOptionsInstaller {

	/**
	 * Действие при активации плагина
	 */
	public function install () {
	}

	/**
	 * Действие при деактивации плагина
	 */
	public function uninstall (){
	}
}

/**
 * Класс для работа со страницами
 * Class SS_MailOptionsPages
 * @property string $menuID;
 * @property string $templateFolder;
 */
class SS_MailOptionsPages {
	private $menuID = 'mailer_menu';
	private $templateFolder;

	/**
	 * Конструктор класса
	 */
	function __construct () {
		$this->templateFolder = dirname(SS_MAILER_PATH).DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR;;
	}

	/**
	 * Добавление пунков меню для страниц плагина
	 * @return bool
	 */
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

	/**
	 * Страница плагина со списком сообщений
	 */
	public function actionIndex () {
		$this->renderPage('index');
	}

	/**
	 * Функция рендеринга страниц
	 * @param       $name
	 * @param array $params
	 * @param bool  $return
	 * @return string
	 */
	public function renderPage ($name, $params = array(), $return = false){
		$templateAddress = $this->getTemplateFilename($name);

		ob_start();
		extract($params);
		require($templateAddress);
		$content = ob_get_contents();
		ob_end_clean();
		if($return) {
			return $content;
		};
		echo $content;
	}

	/**
	 * Функция получения имени файла шаблона
	 * @param $name
	 * @throws MailerException
	 * @return string
	 */
	private function getTemplateFilename ($name) {
		$templateAddress = $this->templateFolder.$name.'.php';
		if(!file_exists($templateAddress)) {
			throw new MailerException('Не удалось найти файл шаблона.'.$templateAddress);
		}
		return $templateAddress;
	}
}

/**
 * Class MailerException
 */
class MailerException extends Exception {

}

try {
	$plugin = new SS_MailOptionsInit();
	$plugin->registerInstallHooks();
	$plugin->registerPages();
	$plugin->registerMailHooks();
} catch (MailerException $e){
	throw new Exception("");
}


