<?php
include_once	'../config.php';
include_once	APP_PATH . '/lib/Cookie.class.php';
include_once	APP_PATH . '/lib/Logger.class.php';
include_once	APP_PATH . '/lib/DAO.class.php';
include_once	APP_PATH . '/lib/Utils.class.php';

class App
{
	private static $instance;
    private static $logger;
    private static $dbh;

    public function __construct() {
        self::instance();
    }

    public static function instance() {
        global $config;

        if (!empty(self::$instance)) {
            return self::$instance;
        }

        // init Logger
        $default_log_path = '/tmp/' . $config['APP_NAME'];
        $log_path = empty($config['LOG_PATH']) ? 
                                        $default_log_path : 
                                        $config['LOG_PATH'];

        self::$logger = Logger::instance($log_path,
                                ($config['DEPLOY'] ? Logger::INFO : Logger::DEBUG));

        // init DBH
        if (empty($config['DB']) || empty($config['DB']['DSN'])) {
            self::$dbh = null;
            self::$logger->logWarn('DB not configed');
        } else {
            self::$dbh = DAO::instance(
                            $config['DB']['DSN'],
                            $config['DB']['USR'],
                            $config['DB']['PWD'], array(
                                    PDO::ATTR_PERSISTENT => true,
                                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
                            ));

            if ($config['DEPLOY']) {
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            } else {
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        }

        return self::$instance;
    }

    public static function getLogger() {
        return self::$logger;
    }

    public static function getDB() {
        return self::$dbh;
    }

}

App::instance();
?>