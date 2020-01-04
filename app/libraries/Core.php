<?php
	
	/* extract values from url in the format of
	 * controller/method/params
	 */

	 class Core{
	 	protected $currentController = 'Pages';
	 	protected $currentMethod = 'index';
	 	protected $params = [];


	 	public function __construct(){
	 		$url = $this->getUrl();

	 		//checking for the first part of the url
	 		//looking in the controllers' folder to find if the controller passed in url exists

	 		if (file_exists('../app/controllers/'.ucwords($url[0]).'.php')) {
	 			//If exists , set currentController to that new upercased controller
	 			$this->currentController = ucwords($url[0]);
	 			//after unset the 0 index

	 			unset($url[0]);
	 		}

	 		//require the controller

	 		require_once('../app/controllers/'.$this->currentController.'.php');

	 		//instantiate the controller class in the contoller file imported

	 		$this->currentController = new $this->currentController;

	 		//checking for the second part of the url
	 		// which may or may not contain the method which may or may not be used in that loaded controller

	 		if (isset($url[1])) {
	 			//then we check to see if the method exists in that loaded controller
	 			if (method_exists($this->currentController, $url[1])) {
	 				$this->currentMethod = $url[1];

	 			}
	 			unset($url[1]);
	 		}

	 		//now finding params (other values which were passed in the url)
	 		$this->params = $url ? array_values($url) : [];

	 		// call a callback with array of params
	 		// this function calls a method in a class and excute it,, if there are variables, it passes them in methods to be excuted
	 		call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

	 	}

	 	public function getUrl(){
	 		if (isset($_GET['url'])) {
	 			$url = rtrim($_GET['url']);
	 			$url = filter_var($url, FILTER_SANITIZE_URL);
	 			$url = explode('/', $url);
	 			return $url;
	 		}
	 	}
	 }	