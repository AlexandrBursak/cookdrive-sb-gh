<?php

namespace app\controllers;
use app\models\Product;
use Yii;

use yii\web\Controller;

class CategoryController extends Controller {

	public function actionIndex() {
		$top = Product::find()->where(['category' => '1'])->all();
		return $this->render('index', compact('top'));
	}

	public function actionView($category) {
		$category = Yii::$app->request->get('category');
		$products = Product::find()->where(['category' => $category])->all();
		return $this->render('view', compact('products'));
	}
	public function actionSearch(){
        $params = Yii::$app->request->get('params');
        $products=Product::find()->where(["sub_category"=>$params])->all();
        return $this->render('view', compact('products'));

    }
}