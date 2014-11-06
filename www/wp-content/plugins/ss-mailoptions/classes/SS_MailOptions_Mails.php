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

	public function dropTableIfExists () {
		$sql = 'DROP TABLE IF EXISTS `'.$this->tableName().'`';
		if (!$this->getDB()->query($sql)) {
			throw new SS_MailerException('Не удалось удалить таблицу `'.$this->tableName().'` при удалении плагина');
		}
	}
}
