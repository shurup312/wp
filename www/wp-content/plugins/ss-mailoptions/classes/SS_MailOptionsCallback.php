<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 06.11.14
 * Time: 20:45
 */
namespace SS_Mailoptions;
/**
 * Класс для методов-коллбэков, которые будут срабатывать по хукам.
 * Class SS_MailOptions_Callback
 */
class SS_MailOptionsCallback {
	private $params;

	/**
	 * @param array $params
	 */
	public function setParams ($params) {
		$this->params = $params;
		$this->prepareParams();
	}

	private function prepareParams () {
		$result = array();
		foreach($this->params as $item) {
			$result[$item['alias']] = $item['value'];
		}
		$this->params = $result;

	}

	/**
	 * @return string
	 */
	public function comment_moderation_headers () {
		return $this->params['comment_moderation_headers'];
	}
	/**
	 * @return string
	 */
	public function comment_moderation_subject () {
		return $this->params['comment_moderation_subject'];
	}
	/**
	 * @return string
	 */
	public function comment_moderation_text () {
		return $this->params['comment_moderation_text'];
	}

	/**
	 * @return string
	 */
	public function retrieve_password_message () {
		/**
		 * TODO: позможно тут сделать шорткоды
		 */
		return $this->params['retrieve_password_message'];
	}
	/**
	 * @return string
	 */
	public function retrieve_password_title () {
		return $this->params['retrieve_password_title'];
	}

	/**
	 * @return array
	 */
	public function woocommerce_email_style_inline_h1_tag () {
		$mail = new SS_MailOptionsAllWcMails();
		return $mail->parseH1Styles($this->params['woocommerce_email_style_inline_h1_tag']);
	}
	/**
	 * @return array
	 */
	public function woocommerce_email_style_inline_h2_tag () {
		$mail = new SS_MailOptionsAllWcMails();
		return $mail->parseH2Styles($this->params['woocommerce_email_style_inline_h2_tag']);
	}
	/**
	 * @return array
	 */
	public function woocommerce_email_style_inline_h3_tag () {
		$mail = new SS_MailOptionsAllWcMails();
		return $mail->parseH3Styles($this->params['woocommerce_email_style_inline_h3_tag']);
	}
	/**
	 * @return array
	 */
	public function woocommerce_email_style_inline_a_tag () {
		$mail = new SS_MailOptionsAllWcMails();
		return $mail->parseAStyles($this->params['woocommerce_email_style_inline_a_tag']);
	}
	/**
	 * @return array
	 */
	public function woocommerce_email_style_inline_img_tag () {
		$mail = new SS_MailOptionsAllWcMails();
		return $mail->parseImgStyles($this->params['woocommerce_email_style_inline_img_tag']);
	}

	/**
	 * @return string
	 */
	public function woocommerce_email_subject_customer_reset_password () {
		return $this->params['woocommerce_email_subject_customer_reset_password'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_style_inline_tags () {
		$mail = new SS_MailOptionsAllWcMails();
		return $mail->parseTags($this->params['woocommerce_email_style_inline_tags']);
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_heading_customer_reset_password () {
		return $this->params['woocommerce_email_heading_customer_reset_password'];
	}

	/**
	 * @return string
	 */
	public function wp_mail_from (){
		return $this->params['wp_mail_from'];
	}

	/**
	 * @return string
	 */
	public function wp_mail_from_name (){
		return $this->params['wp_mail_from_name'];
	}

	/**
	 * @return string
	 */
	public function woocommerce_email_enabled_customer_reset_password () {
		return $this->params['woocommerce_email_enabled_customer_reset_password'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_enabled_new_order () {
		return $this->params['woocommerce_email_enabled_new_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_recipient_new_order () {
		return $this->params['woocommerce_email_recipient_new_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_heading_new_order () {
		return $this->params['woocommerce_email_heading_new_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_subject_new_order () {
		return $this->params['woocommerce_email_subject_new_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_enabled_customer_processing_order () {
		return $this->params['woocommerce_email_enabled_customer_processing_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_recipient_customer_processing_order () {
		return $this->params['woocommerce_email_recipient_customer_processing_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_heading_customer_processing_order () {
		return $this->params['woocommerce_email_heading_customer_processing_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_subject_customer_processing_order () {
		return $this->params['woocommerce_email_subject_customer_processing_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_enabled_customer_completed_order () {
		return $this->params['woocommerce_email_enabled_customer_completed_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_recipient_customer_completed_order () {
		return $this->params['woocommerce_email_recipient_customer_completed_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_heading_customer_completed_order () {
		return $this->params['woocommerce_email_heading_customer_completed_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_subject_customer_completed_order () {
		return $this->params['woocommerce_email_subject_customer_completed_order'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_enabled_customer_invoice () {
		return $this->params['woocommerce_email_enabled_customer_invoice'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_recipient_customer_invoice () {
		return $this->params['woocommerce_email_recipient_customer_invoice'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_heading_customer_invoice () {
		return $this->params['woocommerce_email_heading_customer_invoice'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_subject_customer_invoice () {
		return $this->params['woocommerce_email_subject_customer_invoice'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_enabled_customer_new_account () {
		return $this->params['woocommerce_email_enabled_customer_new_account'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_recipient_customer_new_account () {
		return $this->params['woocommerce_email_recipient_customer_new_account'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_heading_customer_new_account () {
		return $this->params['woocommerce_email_heading_customer_new_account'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_subject_customer_new_account () {
		return $this->params['woocommerce_email_subject_customer_new_account'];
	}	
	
	/**
	 * @return string
	 */
	public function user_registration_email () {
		return $this->params['user_registration_email'];
	}

	/**
	 * @return string
	 */
	public function woocommerce_new_order_note_data () {
		return $this->params['woocommerce_new_order_note_data'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_enabled_customer_note () {
		return $this->params['woocommerce_email_enabled_customer_note'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_recipient_customer_note () {
		return $this->params['woocommerce_email_recipient_customer_note'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_heading_customer_note () {
		return $this->params['woocommerce_email_heading_customer_note'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_subject_customer_note () {
		return $this->params['woocommerce_email_subject_customer_note'];
	}

	/**
	 * @return string
	 */
	public function woocommerce_email_subject_customer_invoice_paid () {
		return $this->params['woocommerce_email_subject_customer_invoice_paid'];
	}
	/**
	 * @return string
	 */
	public function woocommerce_email_heading_customer_invoice_paid () {
		return $this->params['woocommerce_email_heading_customer_invoice_paid'];
	}

}
