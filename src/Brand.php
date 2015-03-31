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

	//DB FUNCTIONS	
	}

?>