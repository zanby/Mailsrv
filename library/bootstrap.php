<?php
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/* Error mode init */
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

/* Set paths to include files */
if (!defined('PATH_SEPARATOR')) define('PATH_SEPARATOR', getenv('COMSPEC') ? ';' : ':');
set_include_path( 
	get_include_path().PATH_SEPARATOR. 
	ENGINE_DIR.PATH_SEPARATOR.
	ENGINE_DIR.'/WsdlWriter'.PATH_SEPARATOR
);

/* Load configuration */
require_once ENGINE_DIR . '/Zend/Exception.php';
require_once ENGINE_DIR . '/Zend/Config/Exception.php';
require_once ENGINE_DIR . '/Zend/Config.php';
require_once ENGINE_DIR . '/Zend/Config/Xml.php';
$cfg = new Zend_Config_Xml(ENGINE_DIR.'/../config/cfg.server.xml', APPLICATION_ENV);

define('PDO_DSN', 'mysql:host='.$cfg->db->host.';port='.$cfg->db->port.';dbname='.$cfg->db->name.'');
define('PDO_USER', $cfg->db->username);
define('PDO_PASSWORD', $cfg->db->password);
define('SERVER_URL', $cfg->server_url);
//define('SERVER_URL', isset($_SERVER['HTTP_HOST']) ? 'http://'.$_SERVER['HTTP_HOST'] : $cfg->server_url);

define('SMTP', $cfg->smtp->use && ( $cfg->smtp->use == 1 || $cfg->smtp->use == 'true' ) ? true : false);
define('SMTP_HOST', $cfg->smtp->host);
define('SMTP_PORT', (int)$cfg->smtp->port);

define('MEMCACHE', $cfg->memcache->use && ( $cfg->memcache->use == 1 || $cfg->memcache->use == 'true' ) ? true : false);
define('MEMCACHE_HOST', $cfg->memcache->host);
define('MEMCACHE_PORT', (int)$cfg->memcache->port);
define('MEMCACHE_CACHE_TIME', (int)$cfg->memcache->life_time);

define('LOG_RAW_MESSAGES', $cfg->log->log_raw_messages == 1 || $cfg->log->log_raw_messages == 'true' ? true : false);

define('BUILDER_MAX_THREADS', (int)$cfg->bootstrap->builder->threads->max);
define('BUILDER_MAX_ITERATIONS', (int)$cfg->bootstrap->builder->iterations->max);
define('BUILDER_MAX_EXECUTION_TIME', (int)$cfg->bootstrap->builder->execution_time->max);
define('DELIVER_MAX_THREADS', (int)$cfg->bootstrap->deliver->threads->max);
define('DELIVER_MAX_ITERATIONS', (int)$cfg->bootstrap->deliver->iterations->max);
define('DELIVER_MAX_EXECUTION_TIME', (int)$cfg->bootstrap->deliver->execution_time->max);

define('BUILDER_THREADS', (int)$cfg->bootstrap->builder->threads->default);
define('BUILDER_ITERATIONS', (int)$cfg->bootstrap->builder->iterations->default);
define('BUILDER_EXECUTION_TIME', (int)$cfg->bootstrap->builder->execution_time->default);
define('DELIVER_THREADS', (int)$cfg->bootstrap->deliver->threads->default);
define('DELIVER_ITERATIONS', (int)$cfg->bootstrap->deliver->iterations->default);
define('DELIVER_EXECUTION_TIME', (int)$cfg->bootstrap->deliver->execution_time->default);

define('BUILDER_VERIFY_TIME', (int)$cfg->bootstrap->builder_verifier->verify_time);
define('DELIVER_VERIFY_TIME', (int)$cfg->bootstrap->deliver_verifier->verify_time);

define('LOCALIZATION_DEFAULT_LOCALE', $cfg->localization->default_locale);

ini_set("soap.wsdl_cache_enabled", $cfg->wsdl_cache_enabled);