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
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
define('SS_MAILER_PATH', __FILE__);

/**
 * Класс инициализации плагина
 * @property SS_MailOptionsInstaller installer
 * @property SS_MailOptionsPages     pages
 */
class SS_MailOptionsInit {

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
		$this->pages     = new SS_MailOptionsPages();
	}

	/**
	 * Регистрация хуков для активации/деактивации плагинов.
	 */
	public function registerInstallHooks () {
		$this->setActivationHook();
		$this->setDeactivationHook();
		$this->setRemoveHook();
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
	private function setActivationHook () {
		register_activation_hook(
			SS_MAILER_PATH,
			array (
				$this->installer,
				'activation'
			)
		);
	}

	/**
	 * Регистрация хука для деактивации плагина
	 */
	private function setDeactivationHook () {
		register_deactivation_hook(
			SS_MAILER_PATH,
			array (
				$this->installer,
				'deactivation'
			)
		);
	}

	/**
	 *
	 */
	private function setRemoveHook () {
		register_uninstall_hook(
			SS_MAILER_PATH,
			array (
				$this->installer,
				'uninstall'
			)
		);
	}

	/**
	 * Регистрация хуков для переопределения данных в отправляемых письмах.
	 */
	public function registerMailHooks () {
		$hooks = $this->getMailHooks();
		$this->registerMailHooksFromList($hooks);
	}

	/**
	 * Получить список всех хуков по почтам.
	 * @return array|null
	 */
	private function getMailHooks () {
		$mails = new SS_MailOptions_Options();
		return $mails->getAllActive();
	}

	/**
	 * Регистрация хуков из полученного списка
	 * @param array $hooks
	 */
	private function registerMailHooksFromList ($hooks) {
		$callback = new SS_MailOptions_Callback();
		foreach($hooks as $item) {
			add_filter($item['alias'], array($callback, $item['alias']));
		}
		$callback->setParams($hooks);
	}
}

/**
 * Класс для методов-коллбэков, которые будут срабатывать по хукам.
 * Class SS_MailOptions_Callback
 */
class SS_MailOptions_Callback {
	private $params;

	/**
	 * @param array $params
	 */
	public function setParams ($params) {
		$this->params = $params;
		$this->prepareParams();
	}

	private function prepareParams () {
		$result = array();
		foreach($this->params as $item) {
			$result[$item['alias']] = $item['value'];
		}
		$this->params = $result;

	}

	/**
	 * @return string
	 */
	public function comment_moderation_headers () {
		return $this->params['comment_moderation_headers'];
	}
	/**
	 * @return string
	 */
	public function comment_moderation_subject () {
		return $this->params['comment_moderation_subject'];
	}
	/**
	 * @return string
	 */
	public function comment_moderation_text () {
		return $this->params['comment_moderation_text'];
	}
	/**
	 * @return string
	 */
	public function retrieve_password_message () {
		return $this->params['retrieve_password_message'];
	}
	/**
	 * @return string
	 */
	public function retrieve_password_title () {
		return $this->params['retrieve_password_title'];
	}


}

/**
 * Класс для выполнения методов при активации/деактивации плагина.
 * Class SS_MailOptionsInstaller
 */
class SS_MailOptionsInstaller{

	/**
	 * Действие при активации плагина
	 */
	public function activation () {
		$this->createMailsTable();
		$this->createOptionsTable();
	}

	/**
	 * Действие при деактивации плагина
	 */
	public function deactivation () {
		$this->dropMailsTable();
		$this->dropOptionsTable();
	}

	/**
	 * Действие при удалении плагина
	 */
	public function uninstall () {

	}

	private function createMailsTable () {
		$mails = new SS_MailOptions_Mails();
		$mails->createTableIfNotExists();
	}

	private function createOptionsTable () {
		$options = new SS_MailOptions_Options();
		$options->createTableIfNotExists();
	}

	private function dropMailsTable () {
		$mails = new SS_MailOptions_Mails();
		$mails->dropTableIfExists();
	}

	private function dropOptionsTable () {
		$options = new SS_MailOptions_Options();
		$options->dropTableIfExists();
	}
}

/**
 * Класс для работа со страницами
 * Class SS_MailOptionsPages
 * @property string $menuID
 * @property string $templateFolder
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
	public function renderPage ($name, $params = array (), $return = false) {
		$templateAddress = $this->getTemplateFilename($name);
		ob_start();
		extract($params);
		require($templateAddress);
		$content = ob_get_contents();
		ob_end_clean();
		if ($return) {
			return $content;
		};
		echo $content;
	}

	/**
	 * Функция получения имени файла шаблона
	 * @param $name
	 * @throws SS_MailerException
	 * @return string
	 */
	private function getTemplateFilename ($name) {
		$templateAddress = $this->templateFolder.$name.'.php';
		if (!file_exists($templateAddress)) {
			throw new SS_MailerException('Не удалось найти файл шаблона.'.$templateAddress);
		}
		return $templateAddress;
	}
}

/**
 * Class MailerException
 */
class SS_MailerException extends Exception {

}

/**
 * Class SS_MailOptions_Mails
 */
class SS_MailOptions_Mails extends SS_MailsOptions_DB {

	const SENDER_WORDPRESS   = 1;
	const SENDER_WOOCOMMERCE = 2;

	/**
	 * Получеине имени таблицы
	 * @return string
	 */
	public function tableName () {
		return $this->getDB()->prefix.'mailoptions_mails';
	}

	public function createTableIfNotExists () {
		$sql = 'CREATE TABLE IF NOT EXISTS `'.$this->tableName().'` (
					`id` INT(11) NOT NULL AUTO_INCREMENT,
					`name` VARCHAR(64) NULL DEFAULT NULL,
					`sender_id` INT(11) NOT NULL DEFAULT "0",
					PRIMARY KEY (`id`)
				)
				COLLATE="utf8_general_ci"
				ENGINE=InnoDB';
		if (!$this->getDB()->query($sql)) {
			throw new SS_MailerException('Не удалось создать таблицу `'.$this->tableName().'` при активации плагина');
		}
	}

	public function dropTableIfExists () {
		$sql = 'DROP TABLE IF EXISTS `'.$this->tableName().'`';
		if (!$this->getDB()->query($sql)) {
			throw new SS_MailerException('Не удалось удалить таблицу `'.$this->tableName().'` при удалении плагина');
		}
	}
}

/**
 * Class SS_MailOptions_Options
 */
class SS_MailOptions_Options extends SS_MailsOptions_DB {
	/**
	 * Получеине имени таблицы
	 * @return string
	 */
	public function tableName () {
		return $this->getDB()->prefix.'mailoptions_options';
	}

	public function createTableIfNotExists () {
		$sql = 'CREATE TABLE IF NOT EXISTS `'.$this->tableName().'` (
					`mail_id` INT(11) NOT NULL DEFAULT "0",
					`alias` VARCHAR(64) NOT NULL DEFAULT "",
					`name` VARCHAR(64) NOT NULL DEFAULT "",
					`value` VARCHAR(64) NOT NULL DEFAULT "",
					`is_active` TINYINT(4) NOT NULL DEFAULT "1",
					PRIMARY KEY (`mail_id`, `alias`)
				)
				COLLATE="utf8_general_ci"
				ENGINE=InnoDB';

		if (!$this->getDB()->query($sql)) {
			throw new SS_MailerException('Не удалось создать таблицу `'.$this->tableName().'` при активации плагина');
		}
	}

	public function dropTableIfExists () {
		$sql = 'DROP TABLE IF EXISTS `'.$this->tableName().'`';
		if (!$this->getDB()->query($sql)) {
			throw new SS_MailerException('Не удалось удалить таблицу `'.$this->tableName().'` при удалении плагина');
		}
	}
}

/**
 * Class SS_MailsOptions_DB
 */
abstract class SS_MailsOptions_DB {
	/**
	 * @return wpdb
	 */
	protected function getDB () {
		global $wpdb;
		return $wpdb;
	}
	/**
	 * Получение всех записей
	 * @return array|null
	 */
	public function getAllActive () {
		$sql = 'SELECT * FROM '.$this->tableName().' WHERE is_active = 1';
		return $this->getDB()->get_results($sql, ARRAY_A);
	}

	/**
	 * Получеине имени таблицы
	 * @return string
	 */
	abstract public function tableName ();
}
try {
	$plugin = new SS_MailOptionsInit();
	$plugin->registerInstallHooks();
	$plugin->registerPages();
	$plugin->registerMailHooks();
} catch(SS_MailerException $e) {
	throw new Exception($e->getMessage());
}


