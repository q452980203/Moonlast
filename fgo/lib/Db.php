<?php

/**
* 数据库访问类
*/
class Db
{
	private $field = '*';
	private $order = '';
	private $limit = '';
	private $where = '';

	//构造PDO属性
	public function __construct(){
		$this->pdo = new PDO('mysql:host=127.0.0.1;dbname=blog_db','root','root');
	}

	//指定表名
	public function table($table){
		$this->table = $table;
		return $this;
	}

	//指定where条件
	public function where($where){
		$this->where = $where;
		return $this;
	}	

	//指定limit条件
	public function limit($limit){
		$this->limit = $limit;
		return $this;
	}

	//指定field条件
	public function field($field){
		$this->field = $field;
		return $this;
	}

	//指定order条件
	public function order($order){
		$this->order = $order;
		return $this;
	}

	//查询count数据
	public function count(){
		$sql = $this->_build_sql('count');
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$total = $stmt->fetchColumn(0);
		return $total;
	}

	//返回一条数据
	public function item(){
		$sql = $this->_build_sql('select');
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return isset($res[0]) ? $res[0] : false;
	}

	//返回多条数据
	public function lists(){
		$sql = $this->_build_sql('select');
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);	
	}

	//返回分页数据
	public function pages($page,$pageSize=10){
		$sql = "select * form {table} {where} {limit}";
		$count = 100;//$this->count();
		$this->limit =($page - 1) * $pageSize .','.$pageSize;
		$data = $this->lists();
		$html = $this->_build_html($page,$count,$pageSize);
		return array('total'=>$count,'data'=>$data,'html'=>$html);
	}

	//添加一条数据
	public function insert($data){
		$sql = $this->_build_sql('insert',$data);
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		return $this->pdo->lastInsertId();	
	}

	//删除数据
	public function delete(){
		$sql = $this->_build_sql('delete');
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();	
	}

	//更新数据
	public function updata($data){
		$sql = $this->_build_sql('update',$data);
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();	
	}

	//构造sql语句
	private function _build_sql($type,$data=null){
		$sql = '';
		//查询语句
		if($type=='select'){
			$where = $this->_build_sql_where();
			$sql = "select {$this->field} from {$this->table} {$where}";
			if($this->order){
				$sql .= " order by {$this->order}";
			}
			if ($this->limit) {
				$sql .= " limit {$this->limit}";
			}
		}

		//添加语句
		if($type=='insert'){
			$sql = "insert into {$this->table}";
			$field = $value = [];
			foreach ($data as $key => $val) {
				$field[] = "`".$key."`";
				$value[] = is_string($val) ? "'".$val."'" :$val;
			}
			$sql .= "(".implode(',', $field).")values(".implode(',', $value).")";
		}

		//删除语句
		if ($type=='delete') {
			$where = $this->_build_sql_where();
			$sql = "delete from {$this->table} {$where}";
		}

		//更新语句
		if ($type=='update') {
			$where = $this->_build_sql_where();
			$str = '';
			foreach ($data as $key => $val) {
				$val = is_string($val) ? "'".$val."'" : $val;
				$str .= "{$key}={$val},";
			}
			$str = rtrim($str,',');
			$sql = "update {$this->table} set {$str} {$where}";
		}
		//count语句
		if ($type=='count') {
			$where = $this->_build_sql_where();
			$field_array = explode(',', $this->field);
			$field = count($field_array)>1 ? '*' : $this->field;
			$sql = "select count({$field}) from {$this->table} {$where}";
		}

		return $sql;
	}

	//生成where条件语句
	private function _build_sql_where(){
		$where = '';
		if(is_array($this->where)){
			foreach ($this->where as $key => $value) {
				$value = is_string($value) ? "'".$value."'" : $value;
				$where .= "`{$key}`={$value} and";
			}
		}else{
			$where = $this->where;
		}
		$where = rtrim($where,'and ');
		$where = $where == '' ? '' : "where {$where}";
		return $where;
	}

	private function _build_html($cur_page,$count,$pageSize){
		$html = '';
		$pageCount = ceil($count/$pageSize);
		
		$html .= "<li><a href='/test.php?page=1'>Home</a></li>";
		$pagePre = ($cur_page - 1)<1 ? 1 : $cur_page - 1;
		$html .= "<li><a href='/test.php?page={$pagePre}'>&laquo;</a></li>";
	
		$start = ($cur_page - 3)<1 ? 1 : $cur_page - 3;
		$end = ($cur_page + 3)>$pageCount ? $pageCount : $cur_page + 3;
		if ($end-$start<6 && $start != 1) {
			$start = $start - (6-($end-$start)) ;
		}
		if ($end-$start<6 && $start < 4) {
			$end = $end + (6-($end-$start)) ;
		}
		for ($i=$start;$i<=$end;$i++) { 
			$html .= $i==$cur_page ? "<li class='active'><a>{$i}</a></li>" : "<li><a href='/test.php?page={$i}'>{$i}</a></li>";
		}

		$pageNext = ($cur_page +1)>$pageCount ? $pageCount : $cur_page +1;
		$html .= "<li><a href='/test.php?page={$pageNext}'>&raquo;</a></li>";
		$html .= "<li><a href='/test.php?page={$pageCount}'>Tail</a></li>";

		$html = "<nav aria-label='Page navigation'><ul class='pagination'>".$html."</ul></nav>";

		return $html;
	}

	

}




















