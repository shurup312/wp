<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 06.11.14
 * Time: 20:45
 */
namespace SS_Mailoptions;
/**
 * Class SS_MailOptions_Mails
 */
class SS_MailOptions_Mails extends SS_MailOptions_DB {

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

	/**
	 * Дроп таблицы, если она существует.
	 * @throws SS_MailerException
	 */
	public function dropTableIfExists () {
		$sql = 'DROP TABLE IF EXISTS `'.$this->tableName().'`';
		if (!$this->getDB()->query($sql)) {
			throw new SS_MailerException('Не удалось удалить таблицу `'.$this->tableName().'` при удалении плагина');
		}
	}

	/**
	 * Получение всех записей
	 * @return array|null
	 */
	public function getAllWithOptions () {
		$result = array();
		$mailID = array();
		$optionClass = new SS_MailOptions_Options();
		$sql = 'SELECT *
				FROM '.$this->tableName();
		$mails = $this->getDB()->get_results($sql, ARRAY_A);
		if(!$mails) {
			return array();
		}
		foreach($mails as $item) {
			$mailID[] = $item['id'];
			$result[$item['id']] = $item;
		}
		$sql = 'SELECT *
				FROM '.$optionClass->tableName().'
				WHERE mail_id IN ('.implode(',', $mailID).') AND is_active=1';
		$options = $this->getDB()->get_results($sql, ARRAY_A);
		foreach($options as $item) {
			$result[$item['mail_id']]['options'][$item['type']][] = $item;
		}
		foreach($result as $key=>$item) {
			if(empty($item['options'])) {
				unset($result[$key]);
			}
		}
		return $result;
	}
}
