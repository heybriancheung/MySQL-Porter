<?php

interface Entity {

	public function persist($data);

	public function update($data);

	public function fetch($criterion);

	public function fetchAll();

	public function delete($criterion);

}

?>
