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
	 * Получение всех записей
	 * @return array|null
	 */
	public function getAllActiveNotEmpty () {
		$sql = 'SELECT * FROM '.$this->tableName().' WHERE is_active = 1 AND value!=""';
		return $this->getDB()->get_results($sql, ARRAY_A);
	}

	/**
	 * Получеине имени таблицы
	 * @return string
	 */
	abstract public function tableName ();
}
