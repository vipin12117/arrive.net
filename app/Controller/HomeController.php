<?php

class HomeController extends AppController{

	public $name = "Home";

	public function beforeFilter(){
		parent::beforeFilter();
	}

	public function index(){

	}

	public function booking(){
		$this->layout = 'booking';
	}
}