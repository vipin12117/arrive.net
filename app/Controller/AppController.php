<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array('Session','Cookie','RequestHandler');

	public $hashType;

	public $helpers = array('Session','Html','Form','Paginator','Js' => array('Jquery'));

	public $uses = array('Admin');

	/**
	 * (non-PHPdoc)
	 * @see lib/Cake/Controller/Controller#beforeFilter()
	 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->ext = '.phtml';
		$this->hashType = 'md5';

		if(!$this->RequestHandler->isAjax()){
			if($this->name == 'Pages'){
				$this->redirect(array('controller'=>'Home','action'=>'index'));
			}

			$this->disableCache();
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see lib/Cake/Controller/Controller#beforeRender()
	 */
	public function beforeRender(){
		parent::beforeRender();
		$this->_setErrorLayout();
		$this->set('page_limit',$this->page_limit);
	}

	/**
	 * This method will handle cakephp error and show user to defined error page
	 */
	public function _setErrorLayout() {
		if($this->name == 'CakeError') {
			$this->ext = '.phtml';
			$this->layout = 'error';
		}
	}

	/**
	 * This method will check admin is logged in or not
	 */
	public function checkSession(){
		$type = "admin_id";
		if(!$this->Session->read($type)){
			$this->Session->destroy();
			$this->redirect(array('controller'=>'Admin','action'=>'login'));
		}
	}

	/**
	 * Return unique code of passed digits
	 * @param Int $size
	 */
	public function uniqueCode($size=6){
		$validchars = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
		@mt_srand ((double) microtime() * 1000000);
		$code = '';
		for ($i = 0; $i < $size; $i++){
			@$index = @mt_rand(0, count($validchars));
			if(!$index){
				$index=0;
			}
			$code .= @$validchars[$index];
		}
		return $code;
	}

	/**
	 * This method will use to parse post or get variables
	 * @param $keyword
	 */
	public function filterKeyword($keyword){
		$keyword = utf8_decode($keyword);
		$keyword = mysql_escape_string($keyword);
		$keyword = trim($keyword);
		return $keyword;
	}
}