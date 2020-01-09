<?php

	class User{
		private $db;
		function __construct(){
			$this->db = new Database;
		}



		//find user by email
		public function getUserByEmail($email){
			$this->db->query('SELECT * FROM users WHERE email = :email;');
			$this->db->bind(':email',$email);

			$row = $this->db->single();

			if ($this->db->rowCount() > 0) {
				return true;
				
			}else{
				return false;
			}
		}

		//find user by id
		public function getUserById($id){
			$this->db->query('SELECT * FROM users WHERE id = :id;');
			$this->db->bind(':id',$id);

			return $this->db->single();

			
		}

		//register user
		public function register($data){
			$this->db->query("INSERT INTO users( name , email , password) VALUES (:name , :email , :password)");
			//binding params

			$this->db->bind(':name', $data['name']);
			$this->db->bind(':email', $data['email']);
			$this->db->bind(':password', $data['password']);

			//execute
			//die(print_r($this->db->execute()));
			 if ($this->db->execute()) {
			 	return true;
			 }else{
			 	return false;
			 }
		}

		public function login($email, $password){
			$this->db->query('SELECT * FROM users WHERE email = :email');
			$this->db->bind(':email', $email);

			$row = $this->db->single();

			$hashedPwd = $row->password;
			if (password_verify($password, $hashedPwd)) {
				return $row;
			}else{
				return false;
			}
		}
		
	}