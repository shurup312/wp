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

	const TYPE_INPUT_TEXT = 0;
	const TYPE_CHECKBOX = 1;
	const TYPE_TEXTAREA = 2;

	private static $_instance;

	private function __construct() {}

	private function __clone() {}

	private function __wakeup() {}

	/**
	 * get instance
	 * @return SS_MailOptions_Mails
	 */
	public static function i () {
		if(!self::$_instance) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	/**
	 * Получеине имени таблицы
	 * @return string
	 */
	public function tableName () {
		return $this->getPrefix().'mailoptions_mails';
	}

	/**
	 * Создание таблицы для плагина, если ее еще не существует.
	 * @throws SS_MailerException
	 */
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
	 * Запись данных в таблицу пи активации
	 */
	public function insertDataForActivate () {
		$sql = 'INSERT INTO `'.$this->tableName().'` (`id`, `name`, `sender_id`) VALUES
					(1, "Повторная отправка пароля", 1),
					(2, "Модерация комментария", 1),
					(3, "Все письма WooCommerce", 2),
					(4, "Восстановление пароля", 2),
					(5, "Все письма", 1),
					(6, "Новый заказ, письмо админу", 2),
					(7, "Новый заказ, письмо клиенту", 2),
					(8, "Письмо клиенту об обработанном заказе", 2),
					(9, "Счет-фактура клиенту", 2),
					(10, "Новый аккаунт", 2),
					(11, "Регистрация пользователя, письма админу и зарегистрировавшемуся", 1),
					(13, "Другое", 3),
					(14, "Новая заметка к товару", 2)';
		$this->getDB()->query($sql);
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
		$sql = 'SELECT *
				FROM '.$this->tableName().'
				ORDER BY `sender_id`';
		$mails = $this->getDB()->get_results($sql, ARRAY_A);
		if(!$mails) {
			return array();
		}
		foreach($mails as $item) {
			$mailID[] = $item['id'];
			$result[$item['id']] = $item;
		}
		$sql = 'SELECT *
				FROM '.SS_MailOptions_Options::i()->tableName().'
				WHERE mail_id IN ('.implode(',', $mailID).') AND is_active=1';
		$options = $this->getDB()->get_results($sql, ARRAY_A);
		foreach($options as $item) {
			if($item['type'] == self::TYPE_CHECKBOX) {
				$item['value'] = (int)$item['value'];
			}
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
