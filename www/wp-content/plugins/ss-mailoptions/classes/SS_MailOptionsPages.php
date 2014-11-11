<?php
/**
 * User: Oleg Prihodko
 * Mail: shuru@e-mind.ru
 * Date: 06.11.14
 * Time: 20:45
 */
namespace SS_Mailoptions;

/**
 * Класс для работа со страницами
 * Class SS_MailOptionsPages
 * @property string $menuID
 * @property string $templateFolder
 */
class SS_MailOptionsPages {

	const JSON_FORMAT = 'json';
	private $templateFolder;
	private $capability = 'manage_options';

	/**
	 * Конструктор класса
	 */
	function __construct () {
		$this->templateFolder = dirname(SS_MAILER_PATH).DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR;;
	}

	/**
	 * Добавление пунков меню для страниц плагина
	 * @return bool
	 */
	public function addMenuItem () {
		if (!is_admin()) {
			return true;
		}
		add_action(
			'wp_ajax_ssma_save',
			array (
				$this,
				'actionAjaxSave'
			)
		);
		add_action(
			'admin_menu',
			array (
				$this,
				'addMenuItemAction'
			)
		);
		return true;
	}

	/**
	 * Метод обработки запроса на сохренение
	 */
	public function actionAjaxSave () {
		$errors             = array ();
		$request            = $this->getRawRequest();
		$changedOptionsList = $this->getOnlyChangedOptions($request);
		foreach($changedOptionsList as $item) {
			if (!SS_MailOptions_Options::i()->saveValueByAlias($item)) {
				$errors[$item['alias']] = array (
					'name' => $item['name'],
				);
			}
		}
		$response = array (
			'ok'    => (int)empty($errors),
			'error' => $errors,
		);
		$this->jsonResponse($response);
		exit();
	}

	/**
	 * Страница плагина со списком сообщений
	 */
	public function actionIndex () {
		$mailsList = SS_MailOptions_Mails::i()->getAllWithOptions();
		$siteURL = site_url();
		$this->renderPage('index', array (
			'mailsList' => $mailsList,
			'siteURL' => $siteURL,
		));
	}

	/**
	 * Функция рендеринга страниц
	 * @param       $name
	 * @param array $params
	 * @param bool  $return
	 * @return string
	 */
	public function renderPage ($name, $params = array (), $return = false) {
		$templateAddress = $this->getTemplateFilename($name);
		ob_start();
		extract($params);
		require($templateAddress);
		$content = ob_get_contents();
		ob_end_clean();
		if ($return) {
			return $content;
		};
		echo $content;
	}

	/**
	 * Получение сырых данных (так отправляет ангуляр) и раскодирование
	 * @param string $type
	 * @return array|string
	 */
	public function getRawRequest ($type = self::JSON_FORMAT) {
		$content = trim(file_get_contents('php://input'));
		if ($type==self::JSON_FORMAT) {
			$content = json_decode($content, true);
		}
		return $content;
	}

	/**
	 * Функция получения имени файла шаблона
	 * @param $name
	 * @throws SS_MailerException
	 * @return string
	 */
	protected function getTemplateFilename ($name) {
		$templateAddress = $this->templateFolder.$name.'.php';
		if (!file_exists($templateAddress)) {
			throw new SS_MailerException('Не удалось найти файл шаблона.'.$templateAddress);
		}
		return $templateAddress;
	}

	/**
	 * @param array $optionsArray
	 * @return array
	 */
	protected function getOnlyChangedOptions ($optionsArray) {
		$result = array ();
		foreach($optionsArray as $mail) {
			foreach($mail['options'] as $type) {
				foreach($type as $option) {
					if (isset($option['isChanged'])) {
						$result[] = $option;
					}
				}
			}
		}
		return $result;
	}

	/**
	 * Отчаса на вывод присланных данных json форматом.
	 * @param $response
	 */
	protected function jsonResponse ($response) {
		echo json_encode($response);
	}

	public function addMenuItemAction () {
		add_options_page(
			'Шаблоны писем',
			'Шаблоны писем',
			$this->capability,
			'mailer',
			array (
				$this,
				'actionIndex'
			)
		);
	}
}
