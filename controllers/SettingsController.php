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
    	$product_user = Order::find()->select('date, user_id, product_name, product_price, product_serv_id, SUM(quantity) AS quantity')->groupBy(['date', 'user_id','product_name', 'product_price', 'product_serv_id' ])->asArray()->where(['user_id' => $authorized_user_id])->orderBy(['date' => SORT_DESC])->all();

    	foreach ($product_user as $key => $value) {
			$product_user_in_date[$value['date']][]=$value;
		}
        
    	return $this->render('orders', compact('product_user_in_date'));
    }

}