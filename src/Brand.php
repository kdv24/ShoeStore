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
	}

?>