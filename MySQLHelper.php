<?php

class MySQLHelper {

	public static function makeCreateSQL($schema) {
		$resultArray = array();
		$phraseArray = array();
		array_push($resultArray, 'CREATE TABLE IF NOT EXISTS ');
		array_push($resultArray, $schema['table']);
		array_push($resultArray, ' (id INT UNSIGNED NOT NULL AUTO_INCREMENT, ');
		foreach($schema as $key => $value) {
			if($key !== 'table') {
				$str = $key . ' ' . strtoupper($value) . ' NOT NULL';
				array_push($phraseArray, $str);
			}
		}
		$phrase = implode(', ', $phraseArray);
		array_push($resultArray, $phrase);
		array_push($resultArray, ', PRIMARY KEY (id)) CHARACTER SET=utf8');
		return implode('', $resultArray);
	}

	public static function makeInsertSQL($dataSet) {
		$keyArray = array();
		$valueArray = array();
		foreach($dataSet as $key => $value) {
			if($key !== 'table') {
				array_push($keyArray, $key);
				if(is_string($value)) {
					array_push($valueArray, "'" . $value . "'");
				} else {
					array_push($valueArray, $value);
				}
			}
		}
		$keyString = '(id, ' . implode(', ', $keyArray) . ')';
		$valueString = '(NULL, ' . implode(', ', $valueArray) . ')';
		return 'INSERT INTO ' . $dataSet['table'] . ' ' . $keyString . ' VALUES ' . $valueString;
	}

	public static function makeDeleteSQL($dataSet) {
		$equalArray = array();
		foreach($dataSet as $key => $value) {
			if($key !== 'table') {
				if(is_string($value)) {
					array_push($equalArray, $key . '=' . "'" . $value . "'");
				} else {
					array_push($equalArray, $key . '=' . $value);
				}
			}
		}
		$andString = implode(' AND ', $equalArray);
		return 'DELETE FROM ' . $dataSet['table'] . ' WHERE ' . $andString;
	}

	private static function createWhere($fragment) {
		$whereFragment = array();
		foreach($fragment as $key => $value) {
			if(is_string($value)) {
				array_push($whereFragment, $key . '=' . "'" . $value . "'");
			} else {
				array_push($whereFragment, $key . '=' . $value);
			}
		}
		$whereResult = implode(' AND ', $whereFragment);
		return $whereResult;
	}

	public static function makeSelectSQL($fragment) {
		$table = $fragment['table'];
		if(isset($fragment['where']) && !isset($fragment['select'])) {
			$whereResult = self::createWhere($fragment['where']);
			return 'SELECT * FROM ' . $table . ' WHERE ' . $whereResult;
		} else if(isset($fragment['where']) && isset($fragment['select'])) {
			$whereResult = self::createWhere($fragment['where']);
			$andPart = implode(', ', $fragment['select']);
			return 'SELECT ' . $andPart . ' FROM ' . $table . ' WHERE ' . $whereResult;
		} else {
			return 'SELECT * FROM ' . $table;
		}
	}

	public static function makeUpdateSQL($update) {
		$setArray = array();
		$whereArray = array();
		foreach($update['set'] as $key => $value) {
			if(is_string($value)) {
                                array_push($setArray, $key . '=' . "'" . $value . "'");
                        } else {
                                array_push($setArray, $key . '=' . $value);
                        }
		}
		foreach($update['where'] as $key => $value) {
                        if(is_string($value)) {
                                array_push($whereArray, $key . '=' . "'" . $value . "'");
                        } else {
                                array_push($whereArray, $key . '=' . $value);
                        }
                }
		return 'UPDATE ' . $update['table'] . ' SET ' . implode(', ', $setArray) . ' WHERE ' . implode(', ', $whereArray);
	}

}

?>
