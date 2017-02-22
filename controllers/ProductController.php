<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Product;
use Yii;

class ProductController extends Controller {
	public function actionView($id){
		$id = Yii::$app->request->get('id');
        $service_id = Yii::$app->request->get('service_id');
		$category = Product::find()->select('category')->where(['id' => $id])->distinct()->one();
		$id_service = Product::find()->select('serv_id')->where(['category' => $category])->distinct()->one();
        $top = Product::find()->asArray()->select('category')->where(['serv_id' => $service_id, 'date_add' => date("Y-m-d")])->distinct()->all();
		$product = Product::findOne($id);
		return $this->render('view', compact('product', 'category', 'id_service','top'));
	}
}