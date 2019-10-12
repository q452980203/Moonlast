<?php

/**
* 
*/
class Base
{
	
	public function run(){
		$this->loadConfig();
		$this->registerAutoLoad();
		$this->getRequestParams();
		$this->dispatch();
	}

	private function loadConfig(){
		$GLOBALS['config'] = require './application/config/config.php';
	}

	public function userAutoLoad($className){
		$baseClass = [
			'Model'=>'./framework/Model.php',
			'Db'=>'./framework/Db.php',
		];
		
		if (isset($baseClass[$className])) {
			require $baseClass[$className];
		}elseif (substr($className, -5) == 'Model') {
			require './application/home/model/'.$className.'.php';
		}elseif (substr($className, -10) == 'Controller') {
			require './application/home/controller/'.$className.'.php';
		}
	}

	private function registerAutoLoad(){
		spl_autoload_register([$this,'userAutoLoad']);
	}

	private function getRequestParams(){
		$defPalte = $GLOBALS['config']['app']['default_platform'];
		$p = isset($_GET['p']) ? $_GET['p'] : $defPalte;
		define('PLATFORM',$p);

		$defController = $GLOBALS['config'][PLATFORM]['default_controller'];
		$c = isset($_GET['c']) ? $_GET['c'] : $defController;
		define('CONTROLLER',$c);

		$defAction = $GLOBALS['config'][PLATFORM]['default_action'];
		$a = isset($_GET['a']) ? $_GET['a'] : $defAction;
		define('ACTION',$a);
	}

	private function dispatch(){
		$controllerName = CONTROLLER;
		$controller = new $controllerName;

		$actionName = ACTION.'Action';
		$controller -> $actionName();
	}

}