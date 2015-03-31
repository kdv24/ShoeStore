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

		static function deleteAll()
		{
			$GLOBALS['DB']->exec("DELETE FROM brands *;");
		}
	}

?>