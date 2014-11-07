<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 06.11.14
 * Time: 20:45
 */
namespace SS_Mailoptions;
/**
 * Class SS_MailsOptions_DB
 */
abstract class SS_MailOptions_DB {
	/**
	 * @return \wpdb
	 */
	protected function getDB () {
		global $wpdb;
		return $wpdb;
	}

	/**
	 * Получеине имени таблицы
	 * @return string
	 */
	abstract public function tableName ();
}
