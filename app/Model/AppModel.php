<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

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
	 * Unbind the all model mapping
	 */
	public function unbindModelAll(){
		$unbind = array();
		foreach ($this->belongsTo as $model=>$info){
			$unbind['belongsTo'][] = $model;
		}

		foreach ($this->hasOne as $model=>$info){
			$unbind['hasOne'][] = $model;
		}

		foreach ($this->hasMany as $model=>$info){
			$unbind['hasMany'][] = $model;
		}

		foreach ($this->hasAndBelongsToMany as $model=>$info){
			$unbind['hasAndBelongsToMany'][] = $model;
		}

		parent::unbindModel($unbind);
	}
}