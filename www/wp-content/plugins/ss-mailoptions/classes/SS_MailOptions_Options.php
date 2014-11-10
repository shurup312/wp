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

	/**
	 * Создание таблицы при активации, если она не существует.
	 * @throws SS_MailerException
	 */
	public function createTableIfNotExists () {
		$sql = 'CREATE TABLE IF NOT EXISTS `'.$this->tableName().'` (
					`mail_id` INT(11) NOT NULL DEFAULT "0",
					`alias` VARCHAR(64) NOT NULL DEFAULT "",
					`type` INT(11) NOT NULL DEFAULT "0",
					`name` VARCHAR(64) NOT NULL DEFAULT "",
					`value` VARCHAR(64) NOT NULL DEFAULT "",
					`is_active` TINYINT(4) NOT NULL DEFAULT "1",
					`comment` VARCHAR(128) NULL DEFAULT "",
					PRIMARY KEY (`mail_id`, `alias`)
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
		$sql = "INSERT INTO `wp_mailoptions_options` (`mail_id`, `alias`, `type`, `name`, `value`, `is_active`, `comment`) VALUES
					(1, 'retrieve_password_message', 0, 'Текст письма', '', 0, 'Текст письма для восстановления пароля'),
					(1, 'retrieve_password_title', 0, 'Заголовок письма', '', 0, 'Заголовок письма для восстановления пароли'),
					(2, 'comment_moderation_headers', 0, 'Заголовки кода письма', '', 0, NULL),
					(2, 'comment_moderation_subject', 0, 'Заголовок письма', '', 1, ''),
					(2, 'comment_moderation_text', 2, 'Текст письма', '', 1, ''),
					(3, 'woocommerce_email_attachments', 0, '???????????????', '', 0, NULL),
					(3, 'woocommerce_email_style_inline_a_tag', 0, 'Стили тэга a', '', 0, 'Стили для тэга a, указывать в css формате (назван'),
					(3, 'woocommerce_email_style_inline_h1_tag', 0, 'Стили тэга h1', '', 0, 'Стили для тэга h1, указывать в css формате (назван'),
					(3, 'woocommerce_email_style_inline_h2_tag', 0, 'Стили тэга h2', '', 0, 'Стили для тэга h2, указывать в css формате (назван'),
					(3, 'woocommerce_email_style_inline_h3_tag', 0, 'Стили тэга h3', '', 0, 'Стили для тэга h3, указывать в css формате (назван'),
					(3, 'woocommerce_email_style_inline_img_tag', 0, 'Стили тэга img', '', 0, 'Стили для тэга img, указывать в css формате (назва'),
					(3, 'woocommerce_email_style_inline_tags', 0, 'Тэги', '', 0, 'Список тэгов через запятую, к которым в письме буд'),
					(4, 'woocommerce_email_enabled_customer_reset_password', 1, 'Отправлять ли письмо', '1', 1, 'Отправлять-ли письмо восстановления пароля.'),
					(4, 'woocommerce_email_heading_customer_reset_password', 0, 'Заголовок пимьма', '', 1, 'Заголовок письма'),
					(4, 'woocommerce_email_recipient_customer_reset_password', 0, 'Кому отправляем письмо', '', 0, ''),
					(4, 'woocommerce_email_subject_customer_reset_password', 0, 'Тема письма', '', 1, ''),
					(5, 'woocommerce_locate_core_template', 0, '???????????????', '', 0, NULL),
					(5, 'wp_mail_content_type', 0, 'Тип контента', '', 0, NULL),
					(5, 'wp_mail_from', 0, 'Email отправителя', '', 1, NULL),
					(5, 'wp_mail_from_name', 0, 'Имя отправителя', '', 1, NULL),
					(6, 'woocommerce_email_enabled_new_order', 1, 'Отправлять ли письмо', '1', 1, 'Отправлять-ли письмо о полученном заказе'),
					(6, 'woocommerce_email_heading_new_order', 0, 'Заголовок пиcьма', '', 1, 'Заголовок письма'),
					(6, 'woocommerce_email_recipient_new_order', 0, 'Кому отправляем письмо', '', 1, 'Введите получателей (разделитель запятая) для этого email. '),
					(6, 'woocommerce_email_subject_new_order', 0, 'Тема письма', '', 1, 'Тема письма с деталями заказа'),
					(7, 'woocommerce_email_enabled_customer_processing_order', 1, 'Отправлять ли письмо', '1', 1, 'Отправлять-ли письмо о полученном заказе'),
					(7, 'woocommerce_email_heading_customer_processing_order', 0, 'Заголовок пиcьма', '', 1, 'Заголовок письма'),
					(7, 'woocommerce_email_recipient_customer_processing_order', 0, 'Кому отправляем письмо', '', 0, ''),
					(7, 'woocommerce_email_subject_customer_processing_order', 0, 'Тема письма', '', 1, 'Тема письма с деталями заказа'),
					(8, 'woocommerce_email_enabled_customer_completed_order', 1, 'Отправлять ли письмо', '1', 1, 'Отправлять-ли письмо восстановления пароля.'),
					(8, 'woocommerce_email_heading_customer_completed_order', 0, 'Заголовок пиcьма', '', 1, 'Заголовок письма'),
					(8, 'woocommerce_email_recipient_customer_completed_order', 0, 'Кому отправляем письмо', '', 0, ''),
					(8, 'woocommerce_email_subject_customer_completed_order', 0, 'Тема письма', '', 1, 'Тема письма с восстановлением пароля.'),
					(9, 'woocommerce_email_enabled_customer_invoice', 1, 'Отправлять ли письмо', '1', 0, 'Отправлять-ли письмо со счетом фактурой'),
					(9, 'woocommerce_email_heading_customer_invoice', 0, 'Заголовок пиcьма', '', 1, 'Для заказов со статусом \"в ожидании оплаты\", \"на удержании\", \"отменен\", \"возмещен\", \"неудавшийся\"'),
					(9, 'woocommerce_email_heading_customer_invoice_paid', 0, 'Заголовок письма', '', 1, 'Для заказов со статусом \"обработка\" или \"выполнен\"'),
					(9, 'woocommerce_email_recipient_customer_invoice', 0, 'Кому отправляем письмо', '', 0, ''),
					(9, 'woocommerce_email_subject_customer_invoice', 0, 'Тема письма', '', 1, 'Для заказов со статусом \"в ожидании оплаты\", \"на удержании\", \"отменен\", \"возмещен\", \"неудавшийся\"'),
					(9, 'woocommerce_email_subject_customer_invoice_paid', 0, 'Тема письма', '', 1, 'Для заказов со статусом \"обработка\" или \"выполнен\"'),
					(10, 'woocommerce_email_enabled_customer_new_account', 1, 'Отправлять ли письмо', '1', 1, 'Отправлять-ли письмо восстановления пароля.'),
					(10, 'woocommerce_email_heading_customer_new_account', 0, 'Заголовок пиcьма', '', 1, 'Заголовок письма'),
					(10, 'woocommerce_email_recipient_customer_new_account', 0, 'Кому отправляем письмо', '', 0, ''),
					(10, 'woocommerce_email_subject_customer_new_account', 0, 'Тема письма', '', 1, 'Тема письма с восстановлением пароля.'),
					(11, 'registration_errors', 0, 'Ошибки регистрации', '', 0, NULL),
					(11, 'user_registration_email', 0, 'E-mail пользователя', '', 0, 'E-mail пользователя, будем записан как его e-mail в свойствах. если пользователь с таким e-mail уже есть, то завершится ошибкой.'),
					(13, 'registration_redirect', 0, 'Куда редиректить после регистрации', '', 0, NULL),
					(14, 'woocommerce_email_enabled_customer_note', 1, 'Отправлять ли письмо', '1', 1, 'Отправлять-ли письмо восстановления пароля.'),
					(14, 'woocommerce_email_heading_customer_note', 0, 'Заголовок пиcьма', '', 1, ''),
					(14, 'woocommerce_email_recipient_customer_note', 0, 'Кому отправляем письмо', '', 0, ''),
					(14, 'woocommerce_email_subject_customer_note', 0, 'Тема письма', '', 1, ''),
					(14, 'woocommerce_new_order_note_data', 0, 'Данные комментария', '', 0, 'Array\r\n(\r\n    [comment_post_ID] => 40\r\n    [comment_author] => admin\r\n    [comment_author_email] => shurup@e-mind.ru\r\n    [comme');
		";
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
	public function getAllActiveNotEmpty () {
		$sql = 'SELECT * FROM '.$this->tableName().' WHERE is_active = 1 AND value!=""';
		return $this->getDB()->get_results($sql, ARRAY_A);
	}

	/**
	 * @param array $item
	 * @return bool
	 */
	public function saveValueByAlias ($item) {
		$sql = 'UPDATE '.$this->tableName().'
				SET `value` = "'.$item['value'].'"
				WHERE `alias` ="'.$item['alias'].'"';
		/**
		 * TODO:  разобраться, чего ха ерунда! Не сохраняет средствами wpdb
		 */
		if(!mysql_query($sql)){
			return false;
		}
		return true;
	}
}
