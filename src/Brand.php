<?php

	class Brand {
		private $brand_name;
		private $id;

		function __construct($brand_name, $id = null)
		{
			$this->brand_name = $brand_name;
			$this->id = $id;
		}

	//GETTERS
		function getBrandName()
		{
			return $this->brand_name;
		}

		function getId()
		{
			return $this->id;
		}
	
	//SETTERS
		function setBrandName($new_brand_name)
		{
			$this->brand_name = (string) $new_brand_name;
		}

		function setId($new_id)
		{
			$this->id = (int) $new_id;
		}

	//DB FUNCTIONS	
		function save()
		{
			$statement = $GLOBALS['DB']->query("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}') RETURNING id;");
			$result = $statement->fetch(PDO::FETCH_ASSOC);
			$this->setId($result['id']);
		}

		static function find($search_id)
		{
			$found_brand = null;
			$brands = Brand::getAll();
			foreach($brands as $brand){
				$brand_id = $brand->getId();
				if ($brand_id == $search_id) {
					$found_brand = $brand;
				}
			}
			return $found_brand;
		}

		static function getAll()
		{
			$returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands");
			$brands = array();

			foreach ($returned_brands as $brand) {
				$brand_name = $brand ["brand_name"];
				$id = $brand ['id'];
				$new_brand_name = new Brand ($brand_name, $id);
				array_push($brands, $new_brand_name);
			}
			return $brands;
		}

	//DELETE FUNCTIONS
		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM brands *;");
		}

		function deleteBrand()
		{
			$GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
		}

	//JOIN STORES TO BRANDS
		function addStore($store)
		{
			$GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
		}

		function getStores()
		{
			$query = $GLOBALS['DB']->query("SELECT stores.* FROM
				brands	JOIN brands_stores ON (brands_stores.brand_id = brands.id)
						JOIN stores ON (brands_stores.store_id = stores.id)
						WHERE brands.id = {$this->getId()};");
			$store_ids = $query->fetchAll(PDO::FETCH_ASSOC);

			$stores = array();
			foreach ($store_ids as $store) {
				$store_name = $store['store_name'];
				$id = $store['id'];
				$new_store = new Store ($store_name, $id);
				array_push($stores, $new_store);
			}
			return $stores;
		}
	}

?>







