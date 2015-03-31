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
		static function deleteAll()
		{
			$GLOBALS['DB']->exec('DELETE FROM stores *;');
		}
	}


?>