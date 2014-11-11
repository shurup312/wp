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
		global $wpdb;
		$sites = wp_get_sites(array(
			'network_id' => 1,
			'public'     => null,
			'archived'   => null,
			'mature'     => null,
			'spam'       => null,
			'deleted'    => 0,
			'limit'      => 100,
			'offset'     => 0,
		));
		if (!empty($sites)) {
			foreach ($sites as $site) {
				SS_MailOptions_Mails::i()->setPrefix($wpdb->get_blog_prefix($site['blog_id']));
				SS_MailOptions_Options::i()->setPrefix($wpdb->get_blog_prefix($site['blog_id']));
				$this->createMailsTable();
				$this->createOptionsTable();
			}
		}
		SS_MailOptions_Mails::i()->setPrefix(null);
		SS_MailOptions_Options::i()->setPrefix(null);
	}

	/**
	 * Действие при деактивации плагина
	 */
	public function deactivation () {
		global $wpdb;
		$sites = wp_get_sites(array(
			'network_id' => 1,
			'public'     => null,
			'archived'   => null,
			'mature'     => null,
			'spam'       => null,
			'deleted'    => 0,
			'limit'      => 100,
			'offset'     => 0,
		));
		if (!empty($sites)) {
			foreach ($sites as $site) {
				SS_MailOptions_Mails::i()->setPrefix($wpdb->get_blog_prefix($site['blog_id']));
				SS_MailOptions_Options::i()->setPrefix($wpdb->get_blog_prefix($site['blog_id']));
				$this->dropMailsTable();
				$this->dropOptionsTable();
			}
		}
	}

	/**
	 * Действие при удалении плагина
	 */
	public static function uninstall () {

	}

	private function createMailsTable () {
		SS_MailOptions_Mails::i()->createTableIfNotExists();
		SS_MailOptions_Mails::i()->insertDataForActivate();
	}

	private function createOptionsTable () {

		SS_MailOptions_Options::i()->createTableIfNotExists();
		SS_MailOptions_Options::i()->insertDataForActivate();
	}

	private function dropMailsTable () {
		SS_MailOptions_Mails::i()->dropTableIfExists();
	}

	private function dropOptionsTable () {
		SS_MailOptions_Options::i()->dropTableIfExists();
	}
}
