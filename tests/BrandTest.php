<?php

	/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

    class BrandTest extends PHPUnit_Framework_TestCase
    {
    	protected function tearDown()
    	{
    		Brand::deleteAll();
    	}

    	function test_getBrandName()
    	{
    		//Arrange
    		$brand_name = "Nike";
    		$id = 1;
    		$test_brand_name = new Brand ($brand_name, $id);

    		//Act 
    		$result = $test_brand_name->getBrandName();

    		//Assert
    		$this->assertEquals($brand_name, $result);
    	}

    	function test_getId()
    	{
    		//Arrange
    		$brand_name = "Nike";
    		$id = 1;
    		$test_brand_name = new Brand ($brand_name, $id);

    		//Act
    		$result = $test_brand_name->getId();

    		//Assert
    		$this->assertEquals($id, $result);
    	}

    	function test_setId()
    	{
    		//Arrange
    		$brand_name = "Nike";
    		$id = null;
    		$test_brand_name = new Brand ($brand_name, $id);

    		//Act
    		$test_brand_name->setId(2);

    		//Assert
    		$result = $test_brand_name->getId();
    		$this->assertEquals(2, $result);
    	}

    	function test_save()
    	{
    		//Arrange
    		$brand_name = "Nike";
    		$id = null;
    		$test_brand_name = new Brand ($brand_name, $id);

    		//Act
    		$test_brand_name->save();
    		$result = Brand::getAll();

    		//Assert
    		$this->assertEquals([$test_brand_name], $result);
    	}

    	function test_getAll()
    	{
    		//Arrange
    		$brand_name = "Nike";
    		$id = null;
    		$test_brand_name = new Brand ($brand_name, $id);

    		$brand_name2 = "Adidas";
    		$id2 = null;
    		$test_brand_name2 = new Brand ($brand_name2, $id2);

    		//Act
    		$test_brand_name->save();
    		$test_brand_name2->save();
    		$result = Brand::getAll();

    		//Assert
    		$this->assertEquals([$test_brand_name, $test_brand_name2], $result);
    	}
    }
?>