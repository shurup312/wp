<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 06.11.14
 * Time: 20:45
 */
namespace SS_Mailoptions;

/**
 * Класс для обработки хука по отроавке всех писем из Wc
 * Class SS_MailOptions_AllWcMails
 */
class SS_MailOptionsAllWcMails {

	/**
	 * Парсинг стилей из строки в массив для H1 тэга
	 * @param string $css
	 * @return array
	 */
	public function parseH1Styles ($css) {
		return $this->parseStyles($css);
	}
	/**
	 * Парсинг стилей из строки в массив для H2 тэга
	 * @param string $css
	 * @return array
	 */
	public function parseH2Styles ($css) {
		return $this->parseStyles($css);
	}
	/**
	 * Парсинг стилей из строки в массив для H3 тэга
	 * @param string $css
	 * @return array
	 */
	public function parseH3Styles ($css) {
		return $this->parseStyles($css);
	}
	/**
	 * Парсинг стилей из строки в массив для A тэга
	 * @param string $css
	 * @return array
	 */
	public function parseAStyles ($css) {
		return $this->parseStyles($css);
	}
	/**
	 * Парсинг стилей из строки в массив для IMG тэга
	 * @param string $css
	 * @return array
	 */
	public function parseImgStyles ($css) {
		return $this->parseStyles($css);
	}
	/**
	 * Парсинг стилей из строки в массив
	 * @param string $css
	 * @return array
	 */
	private function parseStyles ($css) {
		$result = array();
		$css = explode(';', $css);
		if(!is_array($css)) {
			return $result;
		}
		foreach($css as $item) {
			$item = explode(':', $item);
			if(!is_array($item)) {
				continue;
			}
			$result[$item[0]] = $item[1];
		}
		return $result;
	}

	/**
	 * @param string $tags
	 * @return array
	 */
	public function parseTags ($tags) {
		$result = array();
		$tags = explode(',', $tags);
		if(!is_array($tags)) {
			return $result;
		}
		foreach($tags as $item) {
			$result[] = trim($item);
		}
		return $result;
	}
}
