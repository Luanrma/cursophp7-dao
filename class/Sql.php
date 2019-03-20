<?php
	class Sql extends PDO {
		private $conn;
		
		public function __construct() {
			$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7","root","");
		}
		
		// setParams será instanciada quando houver um INSERT com mais que uma Coluna na Tabela.
		private function setParams($statement, $parameters = array()) {
			foreach ($parameters as $key => $value) {
				$this->setParam($statement, $key, $value);
			}
		}
		
		// setParams será instanciada quando houver um INSERT com apenas uma Coluna na Tabela.
		private function setParam($statement, $key, $value) {
			// $key = nome da coluna;
			$statement->bindParam($key, $value);
		}
		
		public function query($rawQuery, $params = array()) {
			$stmt = $this->conn->prepare($rawQuery);
			
			$this->setParams($stmt, $params);
			
			$stmt->execute();
			
			return $stmt;
		}
		
		public function select($rawQuery, $params = array()):array {
			$stmt = $this->query($rawQuery, $params);
			
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
	}
?>