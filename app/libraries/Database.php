<?php

	/* PDO class
	 *connect to database
	 *create prepared statement
	 *bind values
	 *return row and results	
	 */

	class Database{
		private $dbh;
		private $error;
		private $stmt;

		public function __construct(){
			$dns = 'mysql:host='.DB_HOST.';dbname='.DB_NAME;
			$options = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE=> PDO:: ERRMODE_EXCEPTION 
			);

			try {
				$this->dbh = new PDO($dns, DB_USER, DB_PASS, $options);
			} catch (PDOException $e) {
				$this->error = $e->getMessage();
				echo $this->error;
			}
		}

		//preparing queries

		public function query($sql){
			$this->stmt = $this->dbh->prepare($sql);
		}

		public function bind($param, $value, $type=null){
			if (is_null($type)) {
				switch (true) {
					case is_int($value):
						$type = PDO::PARAM_INT;
						break;
					case is_bool($value):
						$type = PDO::PARAM_BOOL;
						break;
					case is_null($value):
						$type = PDO::PARAM_NULL;
						break;
					
					default:
						$type = PDO::PARAM_STR;
						
				}
			}

			$this->stmt->bindValue($param, $value, $type);
		}


		//execute the prepaared statemets
		public function execute(){
			return $this->stmt->execute();
		}

		//getting result sets as array of objects
		public function resultSet(){
			$this->execute();
			return $this->stmt->fetchAll(PDO::FETCH_OBJ);
		}

		//Get single record
		public function single(){
			$this->execute();
			return $this->stmt->fetch(PDO::FETCH_OBJ);
		}

		public function rowCount(){
			return $this->stmt->rowCount();
		}
	}