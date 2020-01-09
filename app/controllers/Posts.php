<?php

	/**
	 * post controller class extending controller for accessing view and model methods
	 */
	class Posts extends Controller{
		function __construct(){
			if (!isAuth()) {
				redirect('users/login');
			}

			$this->postModel = $this->model('Post');
			$this->userModel = $this->model('User');
		}
	

		public function index(){
			$posts  = $this->postModel->getPosts();
			$data=[
				'posts'=>$posts
			];

			$this->view('posts/index', $data);
		}

		public function add(){
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				$_POST= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$data = [
					'title'=>trim($_POST['title']),
					'body'=>trim($_POST['body']),
					'user_id' => $_SESSION['user_id'],
					'title_err' => '',
					'body_err' => ''
					];

			if (empty($data['title'])) {
						$data['title_err'] = 'Please enter title of your post';
					}		

			if (empty($data['body'])) {
						$data['body_err'] = 'You can not post an empty Post';
					}		
		


			if (!empty($data['title_err']) || !empty($data['body_err'])){
					$this->view('posts/add', $data);
				}else{
					if ($this->postModel->addPost($data)) {
						flash('post_message', 'Post added');
						redirect('posts');
					}else{
						die('Something went wrong');
					}
				}		

			}else{
				$data = [
					'title'=>'',
					'body'=>''
					];

			$this->view('posts/add',$data);
			}
			
		}

		public function edit($id){
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				$_POST= filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$data = [
					'id'=>$id,
					'title'=>trim($_POST['title']),
					'body'=>trim($_POST['body']),
					'user_id' => $_SESSION['user_id'],
					'title_err' => '',
					'body_err' => ''
					];

			if (empty($data['title'])) {
						$data['title_err'] = 'Please enter title of your post';
					}		

			if (empty($data['body'])) {
						$data['body_err'] = 'You can not post an empty Post';
					}		
		


			if (!empty($data['title_err']) || !empty($data['body_err'])){
					$this->view('posts/edit', $data);
				}else{
					if ($this->postModel->updatePost($data)) {
						flash('post_message', 'Post updated');
						redirect('posts');
					}else{
						die('Something went wrong');
					}
				}		

			}else{
				$post = $this->postModel->getPost($id);

				if ($post->user_id != $_SESSION['user_id']) {
					redirect('posts');
				}
				$data = [
					'id'=>$post->id,
					'title'=>$post->title,
					'body'=>$post->body
					];

			$this->view('posts/edit',$data);
			}
			
		}

		public function show($id){
			$post = $this->postModel->getPost($id);
			$user = $this->userModel->getUserById($post->user_id);
			$data = [
				'post'=> $post,
				'user' => $user
			];

		
			$this->view('posts/show',$data);
		}

		public function delete($id){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				if ($this->postModel->deletePost($id)) {
					flash('post_message', 'Post removed successfully');
					redirect('posts');
				}else{
					die('Something went wrong');
				}
			}else{
				redirect('posts');
			}
		}
	}