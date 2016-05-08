<?php

require_once '../MySQLHelper.php';

class TestMySQLHelper extends PHPUnit_Framework_TestCase {

	public function testCreateMySQL() {
		$schema = array(
			'table' => 'testTable',
			'field1' => 'int',
			'field2' => 'text'
		);
		$expected = 'CREATE TABLE IF NOT EXISTS testTable (id INT UNSIGNED NOT NULL AUTO_INCREMENT, field1 INT NOT NULL, field2 TEXT NOT NULL, PRIMARY KEY (id)) CHARACTER SET=utf8';
		$actual = MySQLHelper::makeCreateSQL($schema);
		$this->assertEquals($expected, $actual);
	}

	public function testCreateMySQL1() {
		$schema = array(
			'table' => 'testTable',
			'field1' => 'varchar(50)',
			'field2' => 'timestamp'
		);
		$expected = 'CREATE TABLE IF NOT EXISTS testTable (id INT UNSIGNED NOT NULL AUTO_INCREMENT, field1 VARCHAR(50) NOT NULL, field2 TIMESTAMP NOT NULL, PRIMARY KEY (id)) CHARACTER SET=utf8';
		$actual = MySQLHelper::makeCreateSQL($schema);
		$this->assertEquals($expected, $actual);
	}

	public function testInsertSQL() {
		$dataSet = array(
			'table' => 'testTable',
			'field1' => 100,
			'field2' => 'field2'
		);
		$expected = 'INSERT INTO testTable (id, field1, field2) VALUES (NULL, 100, \'field2\')';
		$actual = MySQLHelper::makeInsertSQL($dataSet);
		$this->assertEquals($expected, $actual);
	}

	public function testInsertSQL1() {
                $dataSet = array(
			'table' => 'testTable',
                        'field1' => 100
                );
                $expected = "INSERT INTO testTable (id, field1) VALUES (NULL, 100)";
		$actual = MySQLHelper::makeInsertSQL($dataSet);
                $this->assertEquals($expected, $actual);
        }

	public function testExpandDeleteSQL() {
		$dataSet = array(
			'table' => 'testTable',
			'field1' => 'field1'
		);
		$expected = 'DELETE FROM testTable WHERE field1=\'field1\'';
		$actual = MySQLHelper::makeDeleteSQL($dataSet);
		$this->assertEquals($expected, $actual);
	}

	public function testSelectSQL() {
		$fragment = array(
			'table' => 'testTable'
		);
		$expected = 'SELECT * FROM testTable';
		$actual = MySQLHelper::makeSelectSQL($fragment);
		$this->assertEquals($expected, $actual);
	}

	public function testSelectSQL1() {
		$fragment = array(
			'table' => 'testTable',
			'where' => array(
				'field' => 'field1'
			)
		);
		$expected = 'SELECT * FROM testTable WHERE field=\'field1\'';
		$actual = MySQLHelper::makeSelectSQL($fragment);
		$this->assertEquals($expected, $actual);
	}

	public function testSelectSQL2() {
		$fragment = array(
			'table' => 'testTable',
			'select' => array('field1', 'field2', 'field3'),
			'where' => array(
				'field1' => 'aField'
			)
		);
		$expected = 'SELECT field1, field2, field3 FROM testTable WHERE field1=\'aField\'';
		$actual = MySQLHelper::makeSelectSQL($fragment);
		$this->assertEquals($expected, $actual);
	}

	public function testUpdateSQL() {
		$fragment = array(
			'table' => 'testTable',
			'set' => array(
				'field1' => 'aField1'
			),
			'where' => array(
				'field2' => 'aField2'
			)
		);
		$expected = 'UPDATE testTable SET field1=\'aField1\' WHERE field2=\'aField2\'';
		$actual = MySQLHelper::makeUpdateSQL($fragment);
		$this->assertEquals($expected, $actual);
	}

	public function testUpdateSQL1() {
		$fragment = array(
			'table' => 'testTable',
			'set' => array(
				'field1' => 'aField1',
				'field2' => 'aField2'
			),
			'where' => array(
				'where1' => 'aWhere1',
				'where2' => 'aWhere2'
			)
		);
		$expected = 'UPDATE testTable SET field1=\'aField1\', field2=\'aField2\' WHERE where1=\'aWhere1\', where2=\'aWhere2\'';
		$actual = MySQLHelper::makeUpdateSQL($fragment);
		$this->assertEquals($expected, $actual);
	}

}

?>
