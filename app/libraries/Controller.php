<?php

	/* now the MVC structure, the Controller class is the one responsible for linking views and models
	 * this is the base controller
	 * Loads the model and the view
	 */

	class Controller{
		//loads model
		public function model($model){
			//require the mode from model folder
			require_once('../app/models/'.$model.'.php');

			//returning the instance the class from the required model file

			return new $model();
		}


		//loads view
		public function view($view, $data=[]){
			//checking if the file exixts in the view folder
			if (file_exists('../app/views/'.$view.'.php')) {
				//then requiring it
				require_once('../app/views/'.$view.'.php');
			}else{
				die('View does not exists');
			}
		}
	}