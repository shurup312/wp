<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 06.11.14
 * Time: 20:45
 */
namespace SS_Mailoptions;

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
		$this->pages->addMenuItem();
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
				'SS_Mailoptions\SS_MailOptionsInstaller',
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

		return SS_MailOptions_Options::i()->getAllActiveNotEmpty();
	}

	/**
	 * Регистрация хуков из полученного списка
	 * @param array $hooks
	 */
	private function registerMailHooksFromList ($hooks) {
		$callback = new SS_MailOptionsCallback();
		foreach($hooks as $item) {
			add_filter($item['alias'], array($callback, $item['alias']), 11);
		}
		$callback->setParams($hooks);
	}

	/**
	 *
	 */
	public function isActiveted () {

		return SS_MailOptions_Options::i()->existsTable();
	}
}



/**
 * Class MailerException
 */
class SS_MailerException extends \Exception {

}
