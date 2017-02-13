<?php

namespace app\controllers;

use app\models\Order;
use Yii;

use dektrium\user\controllers\SettingsController as BaseSettingsController;

class SettingsController extends BaseSettingsController
{

    public function behaviors() {

        $param = parent::behaviors();
        
        $param['access']['rules'][0]['actions'][] = 'orders';
        return $param;
    }

    public function actionOrders() {
    	$authorized_user_id = Yii::$app->user->id;
    	$product_user = Order::find()->asArray()->where(['user_id' => $authorized_user_id])->distinct()->all();
    	foreach ($product_user as $key => $value) {
			$product_user_in_date[$value['date']][]=$value;
		}
		// debug($product_user_in_date);
    	return $this->render('orders', compact('product_user_in_date'));
    }

}