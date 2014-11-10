<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
 * на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется сценарием создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'wp');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'goU}^BOPe2$/#jOr ~&<s`WH6V]2xOK0p5YU#!ju<vMFN].k`xp@.*-%*vG-$pU,');
define('SECURE_AUTH_KEY',  'aA`Nr|-V.lT&/so?*AVoAgl0-WFGZ_)X`YL( Pf=n~-<wn X*~UxT?#m!j>f`g55');
define('LOGGED_IN_KEY',    '&A`-^F?A~j|$a+DL_yz3M,QX^H$Bk{Q-mk822R2OCW-eh&c&%-^;Lj,bhzI1We*+');
define('NONCE_KEY',        'o{[j/7 DuCjoX0[Sb6lW}3HPMo(,i;OXRwtzcjs%-@TZ1W+g`-3rMc5:t%tj|Z|~');
define('AUTH_SALT',        'T$7COERHe_TEo>1.)]-q]Df+-<G +|%#ja>#;Mmcy5[U}1N7T5 5:Z,6:DpRWwIi');
define('SECURE_AUTH_SALT', '^|[+.khKYi i3-(O[oMX6KFbI2UM^>FjM|#*`iz/gJK`S>W?_8B{CpGj|>Zzk[]o');
define('LOGGED_IN_SALT',   '&Rvvqx%gGS410.lk|R.0VYx?og={^R-!0Cv2t}F-?D.L~w=W-p.*YCE.QokETe@1');
define('NONCE_SALT',       'm?HmfumTv5$-6wAhs|~xeG?}Q@#^0U9+U+Cm7[-C]o^qJ:J6JFd83Jxx,mFHJ9MW');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько блогов в одну базу данных, если вы будете использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Настоятельно рекомендуется, чтобы разработчики плагинов и тем использовали WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
