<?php
namespace Any\Db;

class Db {
	public $tableName;
	public $ignore = '';
	public $prefix = '';
	/**
	 * @var wpdb 
	 */
	protected $wpdb;
	protected function __construct($table_name) {
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->prefix = $this->wpdb->prefix;
		$this->tableName = $this->wpdb->prefix . $table_name;
	}
	
	/**
	 * 初期化する.コンストラクタを宣言するとアクセス修飾子を付与出来ないので宣言しない
	 */
	final protected function init($table_name){
		$this->tableName = $this->wpdb->prefix . $table_name;
	}


	public function insert($array){
		$keys = '';
		$value = '';
		$values = '';
		$value_array = array();

		foreach($array as $key => $value){
			$keys .= $key . ',';
			if(is_float($value)){
				$values .= '%f,';
			}
			else if(is_numeric($value)){
				$values .= '%d,';
			}else{
				$values .= '%s,';
			}
			$value_array[] = $value;
		}
		$keys = rtrim($keys, ',');
		$values = rtrim($values, ',');
		$sql = 'insert into ' . $this->tableName . '
                   (' . $keys . ')
            values (' . $values . ')
           ';
//		echo "sql:$sql<br>" . PHP_EOL;
//		exit;
//		return $this->wpdb->query($sql);
		return $this->wpdb->query( $this->wpdb->prepare($sql, $value_array) );
	}
	/**
	 * 汎用update
	 * @param array $update_array updateしたいフィールド名を連想配列で渡す。例：array('name' => 'taro', 'email' => 'hoge@com.com')
	 * @param array $target_array update対象としたいフィールド名を連想配列で渡す。複数の場合は間にorかandを入れる。例 array('id' => 10 , 'and', 'title' => 'kikikaikai')
	 * @return boolean 成功/可否
	 */
	public function update($update_array, $target_array){
		//■update対象となっているフィールドの処理
		$value = '';
		$values = '';
		$value_array = array();
		foreach($update_array as $key => $value){
			if(is_float($value)){
				$values .= $key . ' = %f,';
			}
			elseif(is_numeric($value)){
				$values .= $key . ' = %d,';
			}
			else{
				$values .= $key . ' = %s,';
			}
			$value_array[] = $value;
		}
		$values = rtrim($values, ',');

		//■WHERE 以降の処理
		$where_after = '';
		$value_array2 = array();
		foreach($target_array as $key => $value){
			if(is_array($value) && count($value) === 3){
					$where_after .= $k1 . ' = %d';
					$value_array[] = $v1;
			}
			else if(is_array($value)){
				foreach($value as $k1 => $v1){
					if(is_float($v1)){
						$where_after .= $k1 . ' = %f';
					}
					else if(is_numeric($v1)){
						$where_after .= $k1 . ' = %d';
					}
					else{
						$where_after .= $k1 . ' = %s';
					}
					$value_array[] = $v1;
					//一回しかループしない(入力値の特性上)
					break;
				}
			}
			else if(strtolower($value) == 'and' && is_int($key)){
				$where_after .= ' AND ';
			}else if(strtolower($value) == 'or' && is_int($key)){
				$where_after .= ' OR ';
			}
			else{
				if(is_float($value)){
					$where_after .= $key . ' = %f';
				}
				else if(is_numeric($value)){
					$where_after .= $key . ' = %d';
				}
				else{
					$where_after .= $key . ' = %s';
				}
				$value_array2[] = $value;
			}
		}

		$sql = "update {$this->tableName} set $values WHERE " . $where_after;
		return $this->wpdb->query( $this->wpdb->prepare($sql, array_merge($value_array, $value_array2)) );
	}
	public function fetches($target_array, $after_query='', $results=true){
	//■WHERE 以降の処理
		$where_after = '';
		$value_array = array();
		foreach($target_array as $key => $value){
			if(is_array($value) && count($value) === 3){
					if(is_float($value[2])){
						$where_after .= $value[0] . ' ' . $value[1] . ' ' . '%f';
					}
					else if(is_numeric($value[2])){
						$where_after .= $value[0] . ' ' . $value[1] . ' ' . '%d';
					}else{
						$where_after .= $value[0] . ' ' . $value[1] . ' ' . '%s';
					}
					$value_array[] = $value[2];
			}
			else if(is_array($value)){
				foreach($value as $k1 => $v1){
					if(is_numeric($v1)){
						$where_after .= $k1 . ' = %d';
					}else{
						$where_after .= $k1 . ' = %s';
					}
					$value_array[] = $v1;
					//一回しかループしない(入力値の特性上)
					break;
				}
			}
			else if(strtolower($value) == 'and' && is_int($key)){
				$where_after .= ' AND ';
			}
			else if(strtolower($value) == 'or' && is_int($key)){
				$where_after .= ' OR ';
			}
			else{
				if(is_float($value)){
					$where_after .= $key . ' = %f';
					$value_array[] = $value;
				}
				else if(is_numeric($value)){
					$where_after .= $key . ' = %d';
					$value_array[] = $value;
				}
				else{
					$where_after .= $key . ' = %s';
					$value_array[] = $value;
				}
			}
		}
		if(!$inAfterQuery)$inAfterQuery = ' ' . $inAfterQuery;
		if($where_after === ''){
			$where_after = 1;
		}
		$sql = "SELECT * from {$this->tableName} WHERE " . $where_after . $inAfterQuery;
		if($results){
			return $this->wpdb->get_results($this->wpdb->prepare($sql, $value_array));
		}
		else{
			return $this->wpdb->get_row($this->wpdb->prepare($sql, $value_array));
		}
	}
	public function fetch($target_array, $after_query=''){
		$data = $this->fetches($target_array, $after_query, false);
		if(!$data)return false;
		return $data;
	}
//	public function getBindParam($inValue){
//		switch(true){
//			case is_bool($inValue) :
//				return PDO::PARAM_BOOL;
//			case is_null($inValue) :
//				return PDO::PARAM_NULL;
//			case is_int($inValue) :
//				return PDO::PARAM_INT;
//			case is_float($inValue) :
//			case is_numeric($inValue) :
//			case is_string($inValue) :
//			default:
//				return PDO::PARAM_STR;
//		}
//	}
//	public function errorInfo(){
//		return var_export(ReafDB::getPDO()->errorInfo(), true);
//	}
//	public function lock(){
//		$this->pdo->query("LOCK TABLES {$this->tableName} READ;");
//	}
//	public function unlock(){
//		$this->pdo->query('UNLOCK TABLES;');
//	}
//	final public function __clone(){
//		throw new Exception("you can't clone this object");
//	}
//	public function setIgnore(){
//		$this->ignore = ' ignore ';
//	}
//	public function unsetIgnore(){
//		$this->ignore = '';
//	}
	public function delete($param, $value) {
		$sql = "delete from {$this->tableName} WHERE {$param} = %d";
		return $this->wpdb->query( $this->wpdb->prepare($sql, array($value)) );		
	}
	public function is($param, $value){
		$tmp = $this->get(array($param => $value));
		return $tmp !== false;
	}
	public function getTableItemDefinitions(){
		return $this->wpdb->prefix . 'item_definition';
	}
	public function getTableItemRelation(){
		return $this->wpdb->prefix . 'item_relation';
	}
	public function getTableSearchItems(){
		return $this->wpdb->prefix . 'search_items';
	}
}

