<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 06.11.14
 * Time: 20:45
 */
namespace SS_Mailoptions;

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
