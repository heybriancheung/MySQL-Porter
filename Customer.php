<?php
require_once('MySQLHelper.php');
require_once('AbstractEntity.php');
require_once('Entity.php');

class Customer extends AbstractEntity implements Entity {

	private $table = NULL;

	public function __construct() {
		parent::__construct();
		$this->table = 'customers';
		$strQuery = array(
			'table' => $this->table,
			'username' => 'varchar(50)',
			'name' => 'text',
			'address' => 'text',
			'password' => 'text',
			'phone' => 'text',
			'email' => 'varchar(50)',
			'getUpdate' => 'varchar(10)',
			'verified' => 'varchar(10)'
		);
		$this->executeMySQL(MySQLHelper::makeCreateSQL($strQuery));
	}

	public function persist($data) {
		$insertQuery = array(
			'table' => $this->table
		);
		foreach($data as $key => $value) {
			if($key == 'password') {
				$insertQuery[$key] = md5($value);
			} else {
				$insertQuery[$key] = $value;
			}
		}
		$this->executeMySQL(MySQLHelper::makeInsertSQL($insertQuery));
	}

	public function update($data) {
		$id = $data['id'];
		$setArr = array();
		foreach($data as $key => $value) {
			if($key !== 'id') {
				$setArr[$key] = $value;
			}
		}
		$updateQuery = array(
			'table' => $this->table,
			'set' => $setArr,
			'where' => array(
				'id' => $id
			)
		);
		$this->executeMySQL(MySQLHelper::makeUpdateSQL($updateQuery));
	}

	public function fetch($id) {
		$strQuery = array(
			'table' => $this->table,
			'where' => array('id' => $id)
		);
		return $this->doFetch(MySQLHelper::makeSelectSQL($strQuery));
	}

	public function fetchAll() {
		$strQuery = array(
			'table' => $this->table
		);
		return $this->doFetchAll(MySQLHelper::makeSelectSQL($strQuery));
	}

	public function delete($id) {
		$strQuery = array(
			'table' => $this->table,
			'id' => $id
		);
		$this->executeMySQL(MySQLHelper::makeDeleteSQL($strQuery));
	}
			
}

?>
