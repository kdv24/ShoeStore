<?php

	/**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";

    $DB = new PDO('pgsql:host=localhost;dbname=shoes_test');

    class BrandTest extends PHPUnit_Framework_TestCase
    {
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
    }
?>