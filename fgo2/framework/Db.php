<?php

/**
* 数据库基本类
*/

class Db{
	
	private $dbConfig=[
		'db'=>'mysql',
		'host'=>'localhost',
		'port'=>'3306',
		'username'=>'root',
		'password'=>'root',
		'charset'=>'utf8',
		'dbname'=>'blog_db',
	];
	
	private static $_instance = null;

	private $conn = null;

	public $insertId = null;

	public $num = null ;

	private function __construct($params){
		$this->dbConfig = array_merge($this->dbConfig,$params);
		$this->connect();
	}

	private function __clone(){

	}

	public static function getInstance($params=[]){
		if (!self::$_instance instanceof self) {
			self::$_instance = new self($params);
		}
		return self::$_instance;
	}

	private function connect(){
		try{
			$dsn = "{$this->dbConfig['db']}:host={$this->dbConfig['host']};port={$this->dbConfig['port']};dbname={$this->dbConfig['dbname']};charset={$this->dbConfig['charset']}";
			$this->conn = new PDO($dsn,$this->dbConfig['username'],$this->dbConfig['password']);
			$this->conn->query("SET NAMES {$this->dbConfig['charset']}");
		}catch (PDOException $e){
			die('数据连接失败'.$e->getMessage());
		}
	}

	public function exec($sql){
		$num = $this->conn->exec($sql);
		if ($num > 0) {
			if (null !== $this->conn->lastInsertId()) {
				$this->insertId = $this->conn->lastInsertId();
				return $this->insertId;
			}
			$this->num = $num;
			return $num;
		}else{
			$error = $this->conn->errorInfo();
		}
	}

	public function fetch($sql){
		return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC);
	}

	public function fetchAll($sql){
		return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}
	
}