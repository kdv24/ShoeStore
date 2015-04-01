<?php

	class Store {
		private $name;
		private $id;

		function __construct($name, $id = null)
		{
			$this->name = $name;
			$this->id = $id;
		}

	//GETTERS
		function getName()
		{
			return $this->name;
		}	

		function getId()
		{
			return $this->id;
		}

	//SETTERS
		function setName($new_name)
		{
			$this->name = (string) $new_name;
		}	

		function setId($new_id)
		{
			$this->id = (int) $new_id;
		}

	//DB FUNCTIONS
		function save()
		{
			$statement = $GLOBALS['DB']->query("INSERT INTO stores (store_name) VALUES ('{$this->getName()}') RETURNING id;");
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
				$name = $store['store_name'];
				$id = $store['id'];
				$new_store = new Store($name, $id);
				array_push($stores, $new_store);
			}
			return $stores;
		}

	//UPDATE
		function updateStore($new_store)
		{
			$GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$new_store} WHERE id = {$this->getId()};");
			$this->setName($new_store);
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

	//JOIN EVENTS TO STORES
		function addBrand($brand)
		{
			$GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
		}	

		function getBrands()
		{
			$query = $GLOBALS['DB']->query("SELECT brands.* FROM 
				stores 	JOIN brands_stores ON (stores.id = brands_stores.store_id)
						JOIN brands ON (brands_stores.brand_id = brand.id)
						WHERE stores.id = {$this->getId()};");
			var_dump($query);
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









