<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 06.11.14
 * Time: 20:45
 */
namespace SS_Mailoptions;
/**
 * Class SS_MailOptions_Options
 */
class SS_MailOptions_Options extends SS_MailOptions_DB {
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
					`type` INT(11) NOT NULL DEFAULT "0",
					`name` VARCHAR(64) NOT NULL DEFAULT "",
					`value` VARCHAR(64) NOT NULL DEFAULT "",
					`is_active` TINYINT(4) NOT NULL DEFAULT "1",
					`comment` VARCHAR(128) NOT NULL DEFAULT "1",
					PRIMARY KEY (`mail_id`, `alias`)
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
	public function getAllActiveNotEmpty () {
		$sql = 'SELECT * FROM '.$this->tableName().' WHERE is_active = 1 AND value!=""';
		return $this->getDB()->get_results($sql, ARRAY_A);
	}
}
