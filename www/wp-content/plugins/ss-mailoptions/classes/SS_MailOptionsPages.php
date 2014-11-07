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
	 * Функция получения имени файла шаблона
	 * @param $name
	 * @throws SS_MailerException
	 * @return string
	 */
	private function getTemplateFilename ($name) {
		$templateAddress = $this->templateFolder.$name.'.php';
		if (!file_exists($templateAddress)) {
			throw new SS_MailerException('Не удалось найти файл шаблона.'.$templateAddress);
		}
		return $templateAddress;
	}
}
