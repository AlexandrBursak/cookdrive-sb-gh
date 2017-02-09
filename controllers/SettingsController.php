<?php
/**
 * Created by PhpStorm.
 * User: MyBe
 * Date: 02.02.2017
 * Time: 14:13
 */

namespace app\controllers;

use dektrium\user\controllers\SettingsController as BaseSettingsController;

class SettingsController extends BaseSettingsController
{

    public function behaviors() {

        $param = parent::behaviors();
        
        $param['access']['rules'][0]['actions'][] = 'orders';
        return $param;
    }

    public function actionOrders() {

    	return $this->render('orders');
    }

}