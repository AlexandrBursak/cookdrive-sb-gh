<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Product;
use Yii;

class ProductController extends Controller {
	public function actionView($id){
		$id = Yii::$app->request->get('id');
		$category = Product::find()->select('category')->where(['id' => $id])->distinct()->one();
		$id_service = Product::find()->select('serv_id')->where(['category' => $category])->distinct()->one();
		$product = Product::findOne($id);
		return $this->render('view', compact('product', 'category', 'id_service'));
	}
}