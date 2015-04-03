<?php

	class Store {
		private $store_name;
		private $id;

		function __construct($store_name, $id = null)
		{
			$this->store_name = $store_name;
			$this->id = $id;
		}

	//GETTERS
		function getStoreName()
		{
			return $this->store_name;
		}	

		function getId()
		{
			return $this->id;
		}

	//SETTERS
		function setStoreName($new_store_name)
		{
			$this->store_name = (string) $new_store_name;
		}	

		function setId($new_id)
		{
			$this->id = (int) $new_id;
		}

	//DB FUNCTIONS
		function save()
		{
			$statement = $GLOBALS['DB']->query("INSERT INTO stores (store_name) VALUES ('{$this->getStoreName()}') RETURNING id;");
			$result = $statement->fetch(PDO::FETCH_ASSOC);
			$this->setId($result['id']);
		}	

		static function find($search_id)
		{
			$found_store = null;
			$stores = Store::getAll();
			foreach($stores as $store){
				$store_id = $store->getId();
				if ($store_id == $search_id) {
					$found_store = $store;
				}	
			}	
			return $found_store;
		}

		static function getAll()
		{
			$returned_stores = $GLOBALS['DB']->query ('SELECT * FROM stores');
			$stores = array();

			foreach ($returned_stores as $store) {
				$store_name = $store['store_name'];
				$id = $store['id'];
				$new_store = new Store($store_name, $id);
				array_push($stores, $new_store);
			}
			return $stores;
		}

	//UPDATE
		function updateStore($new_store)
		{
			$GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$new_store}' WHERE id = {$this->getId()};");
			$this->setStoreName($new_store);
		}

	//DELETE
		function deleteStore()
		{
			$GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
		}

		static function deleteAll()
		{
			$GLOBALS['DB']->exec('DELETE FROM stores *;');
		}

		function test_find()
		{
			//Assert
			$brand_name = "nike";
			$id = null;
			$test_brand_name = new Brand($brand_name, $id);
			$test_brand_name->save();

			$brand_name2 = "adidas";
			$id2= null;
			$test_brand_name2 = new Brand($brand_name2, $id2);
			$test_brand_name2->save();

			//Act
			$result = Brand::find($test_brand_name->getId());

			//Assert
			$this->assertEquals($test_brand_name, $result);
		}

	//JOIN BRANDS TO STORES
		function addBrand($brand)
		{
			$GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
		}	

		function getBrands()
		{
			$query = $GLOBALS['DB']->query("SELECT brands.* FROM 
				stores 	JOIN brands_stores ON (brands_stores.store_id = stores.id)
						JOIN brands ON (brands_stores.brand_id = brands.id)
						WHERE stores.id = {$this->getId()};");

			$brand_ids = $query->fetchAll(PDO::FETCH_ASSOC);

			$brands = array();
			foreach ($brand_ids as $brand) {
				$id = $brand['id'];
				$brand_name = $brand['brand_name'];
				$new_brand = new Brand ($brand_name, $id);
				array_push($brands, $new_brand);
			}
			return $brands;
		}
	}


?>









