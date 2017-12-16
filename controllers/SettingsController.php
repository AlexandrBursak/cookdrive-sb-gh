<?php

namespace app\controllers;

use app\models\Order;
use app\models\History;
use Yii;

use dektrium\user\controllers\SettingsController as BaseSettingsController;

class SettingsController extends BaseSettingsController
{

    public function behaviors() {

        $param = parent::behaviors();
        $param['access']['rules'][0]['actions'][] = 'orders';
        $param['access']['rules'][0]['actions'][] = 'balance';
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

    public function actionBalance() {
        $authorized_user_id = Yii::$app->user->id;
        $balance_user = History::find()->select('date, users_id, summa, orders_id, operation, id')->groupBy(['id'])->asArray()->where(['users_id' => $authorized_user_id])->orderBy(['date' => SORT_DESC])->all();

        foreach ($balance_user as $key => $value) {
            $balance_user_in_date[$value['date']][]=$value;
        }
        return $this->render('balance', compact('balance_user_in_date'));
    }

}