<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Product;
use Yii;

class ProductController extends Controller {
	public function actionView($id){
		$id = Yii::$app->request->get('id');
		$product = Product::findOne($id);
		return $this->render('view', compact('product'));
	}
}