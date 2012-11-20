<?php
include_once	APP_PATH . '/lib/App.class.php';

// Models
foreach (glob(APP_PATH . '/models/*.class.php') as $model) {
    include_once	$model;
}

class API
{
	const OK 	 	= 0;
	const ERROR 	= 1;
	const DENIED 	= 2;

	protected $logger;
    protected $dbh;

    protected $callback;
    protected $action;

    protected $needAuth = true;

    public function __construct() {
        $this->logger = App::getLogger();
        $this->dbh = App::getDB();
    }

    public function call() {
        global $config;

        $this->callback	= Utils::userInput($_GET['callback']);
        $this->action	= Utils::userInput($_GET['action']);

        if ($config['CHECK_HOST']) {
            $this->hostCheck();
        }

        if (empty($this->action)) exit();

        if (method_exists($this, $this->action)) {

            if ($this->needAuth) {
                $this->auth();
            }

            call_user_func(array($this, $this->action));
        } else {
            $this->error('params missing');
        }
    }

    private function hostCheck() {
        global $config, $_SERVER;

        $domain = $config['COOKIE_DOMAIN'];
        $pattern = '/^'.$domain.'$/';

        if (!preg_match($pattern, $_SERVER['HTTP_HOST'])) {
            $this->denied();
        }
    }

    protected function auth() {
    	global $config;
        // TODO auth user
    }

    protected function success($output=array()) {
    	$output['status'] = self::OK;
    	$output['msg'] = 'ok';
    	$this->output($output);
    }

    protected function error($emsg='error') {
        $this->output(array(
        	'status' => self::ERROR,
            'msg' => $emsg
        ));
    }

    protected function denied() {
    	$this->output(array(
    		'status' => self::DENIED,
            'msg' => 'permission denied'
        ));
    }

    protected function output($output=array()) {
        header("Cache-Control: no-cache, must-revalidate, max-age=0");

        if ($this->callback) {
            header('Content-Type: text/javascript');
            echo $this->callback . '(' . json_encode($output) . ');';
        } else {
            header('Content-Type: application/x-json');
            echo json_encode($output);
        }
        exit();
    }

    protected function rawOutput($json) {
        header("Cache-Control: no-cache, must-revalidate, max-age=0");

        if ($this->callback) {
            header('Content-Type: text/javascript');
            echo $this->callback . '(' . $json . ');';
        } else {
            header('Content-Type: application/x-json');
            echo $json;
        }
        exit();
    }
}
?>