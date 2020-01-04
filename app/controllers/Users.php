<?php

	class Users extends Controller{
		public function __construct(){

			$this->userModel = $this->model('User');

		}

		public function register(){
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				//sanitize strings
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				//process the form
				$data = [
					'name' => trim($_POST['name']),
					'email' => trim($_POST['email']),
					'password' => trim($_POST['password']),
					'confirm_password' => trim($_POST['confirm_password']),
					'name_err' => '',
					'email_err' => '',
					'password_err' => '',
					'confirm_password_err' => ''
				];

				//EMAIL VALIDATION
				if (empty($_POST['email'])) {
					$data['email_err'] = 'Email field is required';
				}elseif ($this->userModel->getUserByEmail($data['email'])) {
					$data['email_err'] = 'Email is taken';
				}

				//NAME VALIDATION
				if (empty($_POST['name'])) {
					$data['name_err'] = 'Name field is required';
				}

				//PASSWORD VALIDATION
				if (empty($_POST['password'])) {
					$data['password_err'] = 'password field is required';
				}elseif (strlen($_POST['password']) < 6) {
					$data['password_err'] = 'password must be more than five characters';
				}

				//CONFIRM_PASSWORD VALIDATION
				if (empty($_POST['confirm_password'])) {
					$data['confirm_password_err'] = 'Please confirm password';
				}elseif ($_POST['password'] != $_POST['confirm_password']) {
					$data['confirm_password_err'] = 'Passwords do not match';
				}

				//making sure no errors ie error variables are empty
				if (empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) ) {
					//validated
					//hashing password

					$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

					//REGISTER USSER
					if ($this->userModel->register($data)) {
						flash('register_success', 'You are registered and can now login');
						redirect('users/login');
					}else{
						die("something went wrong");
					}

				}else{
					$this->view('users/register' , $data);
				}


			}else{
				//init data

				$data = [
					'name' => '',
					'email' => '',
					'password' => '',
					'confirm_password' => '',
					'name_err' => '',
					'email_err' => '',
					'password_err' => '',
					'confirm_password_err' => ''
				];				

				//load view
				$this->view('users/register', $data);
			}
		}
		public function login(){
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				//process the form

				//sanitize strings
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				//process the form
				$data = [
			
					'email' => trim($_POST['email']),
					'password' => trim($_POST['password']),
					'name_err' => '',
					'email_err' => '',
					'password_err' => ''
					
				];

				//EMAIL VALIDATION
				if (empty($data['email'])) {
					$data['email_err'] = 'Email field is required';
				}elseif ($this->userModel->getUserByEmail($data['email'])) {
					
				}else{
					$data['email_err'] = 'No user found';
				}

				

				//PASSWORD VALIDATION
				if (empty($data['password'])) {
					$data['password_err'] = 'password field is required';
				}elseif (strlen($data['password']) < 6) {
					$data['password_err'] = 'password must be more than five characters';
				}

				//checking for user email in the database


				//making sure no errors ie error variables are empty
				if ( empty($data['email_err']) && empty($data['password_err'])  ) {
					//validated
					//login user
					$isAuth = $this->userModel->login($data['email'] , $data['password']);

					if ($isAuth) {
						//creating session
						$this->createUserSession($isAuth);
					}else{
						$data['password_err'] = 'Incorrect password';
						$this->view('users/login', $data);
					}
				}else{
					$this->view('users/login' , $data);
				}
			}else{
				//init data

				$data = [
			
					'email' => '',
					'password' => '',
					'password_err' => '',
					'confirm_password_err' => ''
				];				

				//load view
				$this->view('users/login', $data);
			}
		}

		public function createUserSession($user){
			$_SESSION['user_id'] = $user->id;
			$_SESSION['user_email'] = $user->email;
			$_SESSION['user_name'] = $user->name;

			redirect('pages/index');
		}

		public function logout(){
			unset($_SESSION['user_id']);
			unset($_SESSION['user_email']);
			unset($_SESSION['user_name']);
			session_destroy();
			redirect('pages/index');
		}

		public function isLoggedIn(){
			if (isset($_SESSION['user_id'])) {
				return true;
			}else{
				return false;
			}
		}
		

	}