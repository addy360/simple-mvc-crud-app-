<?php

	class Pages extends Controller{
		public function __construct(){
			
		}

		public function index(){
			
			$data = [
				
				'description'=> 'Simple social network built on the php MVC' ,
				'title'=> 'The mini framework'
			];
			$this->view('pages/welcome', $data);
		}

		public function about(){
			$data = [
				'description'=> 'website to share posts with other users' ,
				'title'=> 'About'
			];
			$this->view('pages/about',$data);
		}
	}