<?php

	/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

	require_once "src/Store.php";
	require_once "src/Brand.php";

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
			$store_name = "Foot Traffic";
			$id = 1;
			$test_store = new Store ($store_name, $id);

			//Act
			$result = $test_store->getStoreName();

			//Assert
			$this->assertEquals($store_name, $result);
		}

		function test_getId()
		{
			//Arrange
			$store_name = "Foot Traffic";
			$id = 1;
			$test_store = new Store ($store_name, $id);

			//Act
			$result = $test_store->getId();

			//Assert
			$this->assertEquals($id, $result);
		}

		function test_setId()
		{
			//Arrange
			$store_name = "Foot Traffic";
			$id = null;
			$test_store = new Store($store_name, $id);

			//Act
			$test_store->setId(2);

			//Assert
			$result = $test_store->getId();
			$this->assertEquals(2, $result);
		}

		function test_save()
		{
			//Arrange
			$store_name = "Foot Traffic";
			$id = null;
			$test_store = new Store ($store_name, $id);

			//Act
			$test_store->save();
			$result = Store::getAll();

			//Assert
			$this->assertEquals([$test_store], $result);
		}

		function test_getAll()
		{
			//Arrange
			$store_name = "Foot Traffic";
			$id = null;
			$test_store = new Store($store_name, $id);

			$store_name2 = "Fit Right";
			$id2= null;
			$test_store2 = new Store($store_name2, $id2);

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
			$store_name = "Foot Traffic";
			$id = null;
			$test_store = new Store($store_name, $id);

			$test_store->save();
			$new_store = "Fit Right";

			//Act
			$test_store->updateStore($new_store);

			//Assert
			$this->assertEquals($test_store->getStoreName(), $new_store);
		}

		function test_deleteStore()
		{
			//Arrange
			$store_name = "Foot Traffic";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$store_name2 = "Fit Right";
			$id2 = null;
			$test_store2 = new Store($store_name2, $id2);
			$test_store2->save();

			//Act
			$test_store->deleteStore();
			$result = Store::getAll();

			//Assert
			$this->assertEquals($test_store2, $result);
		}

		function test_find()
		{
			//Assert
			$store_name = "Foot Traffic";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$store_name2 = "Fit Right";
			$id2 = null;
			$test_store2 = new Store($store_name2, $id2);
			$test_store2->save();

			//Act
			$result = Store::find($test_store->getId());

			//Assert
			$this->assertEquals($test_store, $result);
		}

		function test_getBrands()
		{
			//Assert
			$store_name = "Foot Traffic";
			$id = null;
			$test_store = new Store($store_name, $id);
			$test_store->save();

			$brand_name = "Nike";
			$id2 = null;
			$test_brand_name = new Brand($brand_name, $id2);
			$test_brand_name->save();

			$brand_name2 = "Adidas";
			$id3 = null;
			$test_brand_name2 = new Brand($brand_name2, $id3);
			$test_brand_name2->save();			

			//Act
			$test_store->addBrand($test_brand_name);
			$test_store->addBrand($test_brand_name2);

			//Assert
			$result = $test_store->getBrands();
			$this->assertEquals([$test_store, $test_store2], $result);	
		}
	}

?>