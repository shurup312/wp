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
define('AUTH_KEY',         '[rzCC#i(PgR|*Zp.eUt!dComfb4Imf=Zv~nx?_140rc9okJjqjuOt8JJ@K$!uwQ`');
define('SECURE_AUTH_KEY',  'E|J]I[OYrGYM5q-QHEE_6`{Zi?U4W>AOFX!S]-N, HKX+>@7jPW}I$m##-iH8{{f');
define('LOGGED_IN_KEY',    ']=_r3(IbLTP>k;Mhr4p74 6SCcG[ZlJ7tVCg-dBWx#c+7-Z]<XwmO1MDLAIQ>*5z');
define('NONCE_KEY',        '^#Y?Tr*ru(+g.PCJ n& Bm_DXvQ=ce]iF9+Y6@A;KBvQBZ1l7yvl:Pj}Eg%R8|m6');
define('AUTH_SALT',        'pb>xbf|+r!yA0|G1Ad*QO>C~Qa@8 ga7<?[*TPTZRO7z!Eu <g=?Qx4IAK5@|GB(');
define('SECURE_AUTH_SALT', '$-Te~sB[DPg8J7bxx/c]VI8(PM1VOxXr1*Cq y;*-BUd]a1rzqmJ|& E``j$E=Y1');
define('LOGGED_IN_SALT',   ',KEkU| 8[:_>.F]/0XgJf|O? E=k&*gk N3JakTMlr6EzY#+lr8_^Z8@ +$(@FNd');
define('NONCE_SALT',       '@<Tkc#,7htFk&*f1B.=h+&8jGrihkP$_u.bTE#in[6 H_DHF)SklGrvY+u`I^k|t');


define( 'WP_ALLOW_MULTISITE', true );

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

// Включаем логгирование
define('WP_DEBUG', true);
// Лог будет храниться в файле /wp-content/debug.log
define('WP_DEBUG_LOG', true);
// Отключаем вывод ошибок на экран
define('WP_DEBUG_DISPLAY', true);

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', 'wp');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
