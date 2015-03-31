<?php

	/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

	require_once "src/Store.php";

	$DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

	class StoreTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Store::deleteAll();
		}

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

		function test_setId()
		{
			//Arrange
			$name = "Foot Traffic";
			$id = null;
			$test_store = new Store($name, $id);

			//Act
			$test_store->setId(2);

			//Assert
			$result = $test_store->getId();
			$this->assertEquals(2, $result);
		}

		function test_save()
		{
			//Arrange
			$name = "Foot Traffic";
			$id = null;
			$test_store = new Store ($name, $id);

			//Act
			$test_store->save();
			$result = Store::getAll();

			//Assert
			$this->assertEquals([$test_store], $result);
		}

		function test_getAll()
		{
			//Arrange
			$name = "Foot Traffic";
			$id = null;
			$test_store = new Store($name, $id);

			$name2 = "Fit Right";
			$id2= null;
			$test_store2 = new Store($name2, $id2);

			//Act
			$test_store->save();
			$test_store2->save();
			$result = Store::getAll();

			//Assert
			$this->assertEquals([$test_store, $test_store2], $result);
		}

		function test_updateStore()
		{
			//Arrange
			$name = "Foot Traffic";
			$id = null;
			$test_store = new Store($name, $id);

			$test_store->save();
			$new_store = "Fit Right";

			//Act
			$test_store->updateStore($new_store);

			//Assert
			$this->assertEquals($test_store->getName(), $new_store);
		}
	}

?>