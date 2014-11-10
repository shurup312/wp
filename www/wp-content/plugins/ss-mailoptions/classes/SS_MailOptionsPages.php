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
	private $menuID = 'manage_options';
	private $templateFolder;

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
	public function addMenuItems () {
		if (!is_admin()) {
			return true;
		}
		add_action( 'wp_ajax_ssma_save', array($this, 'actionAjaxSave') );
		add_action(
			'admin_menu',
			function () {
				add_menu_page(
					'Почтовик',
					'Почтовик',
					$this->menuID,
					'mailer/index',
					array (
						$this,
						'actionIndex'
					)
				);
			}
		);
		return true;
	}

	/**
	 * Метод обработки запроса на сохренение
	 */
	public function actionAjaxSave () {
		$errors = array();
		$request = $this->getRawRequest();
		$options = new SS_MailOptions_Options();
		$changedOptionsList = $this->getOnlyChangedOptions($request);
		foreach($changedOptionsList as $item) {
			if(!$options->saveValueByAlias($item)) {
				$errors[$item['alias']] = array(
					'name' => $item['name'],
				);
			}
		}
		$response = array(
			'ok' => (int)empty($errors),
			'error' => $errors,
		);
		$this->jsonResponse($response);
		exit();
	}
	/**
	 * Страница плагина со списком сообщений
	 */
	public function actionIndex () {
		$mails     = new SS_MailOptions_Mails();
		$mailsList = $mails->getAllWithOptions();
		$this->renderPage('index', array ('mailsList' => $mailsList));
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
		if($type == self::JSON_FORMAT){
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
		$result = array();
		foreach($optionsArray as $mail) {
			foreach($mail['options'] as $type) {
				foreach($type as $option) {
					if(isset($option['isChanged'])) {
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
}
