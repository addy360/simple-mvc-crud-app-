<?php

	/**
	 * post model class which will be required in controller class thru Controller library class
	 */
	class Post{
		private $db;
		function __construct(){
			$this->db = new Database();
		}

		public function getPosts(){
			$this->db->query('SELECT *, posts.id AS postId, users.id AS userId, posts.created_at AS postDate  FROM posts INNER JOIN users ON posts.user_id = users.id ORDER BY postDate DESC');

			return $this->db->resultSet();
		}

		public function getPost($id){
			$this->db->query('SELECT * FROM posts WHERE posts.id = :id');
			$this->db->bind(':id' , $id);
			return $this->db->single();
		}
		
		public function addPost($data){
			$this->db->query("INSERT INTO posts( title , body , user_id) VALUES (:title , :body , :user_id)");
			//binding params

			$this->db->bind(':title', $data['title']);
			$this->db->bind(':body', $data['body']);
			$this->db->bind(':user_id', $data['user_id']);

			//execute
			//die(print_r($this->db->execute()));
			 if ($this->db->execute()) {
			 	return true;
			 }else{
			 	return false;
			 }
		}

		public function updatePost($data){
			$this->db->query("UPDATE posts SET title = :title, body = :body WHERE id = :id");
			//binding params

			$this->db->bind(':title', $data['title']);
			$this->db->bind(':body', $data['body']);
			$this->db->bind(':id', $data['id']);

			//execute
			//die(print_r($this->db->execute()));
			 if ($this->db->execute()) {
			 	return true;
			 }else{
			 	return false;
			 }
		}

		public function deletePost($id){
			$this->db->query("DELETE FROM posts WHERE id = :id");
			//binding params

			$this->db->bind(':id', $id);

			//execute
			//die(print_r($this->db->execute()));
			 if ($this->db->execute()) {
			 	return true;
			 }else{
			 	return false;
			 }
		}
	}