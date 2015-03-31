<?php

	/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

	require_once "src/Store.php";

	$DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

	class StoreTest extends PHPUnit_Framework_TestCase
	{
		function test_getName()
		{
			//Arrange
			$name = "Foot Traffic";
			$id = 1;
			$test_store = new Store ($name, $id);

			//Act
			$result = $test_store->getName();

			//Assert
			$this->assertEquals($name, $result);
		}

		function test_getId()
		{
			//Arrange
			$name = "Foot Traffic";
			$id = 1;
			$test_store = new Store ($name, $id);

			//Act
			$result = $test_store->getId();

			//Assert
			$this->assertEquals($id, $result);
		}
	}

?>