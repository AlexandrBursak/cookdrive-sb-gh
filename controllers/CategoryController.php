<?php

namespace app\controllers;
use app\models\Product;
use Yii;

use yii\web\Controller;

class CategoryController extends Controller {

	public function actionIndex($id) {
		$top = Product::find()->asArray()->select('category')->where(['serv_id' => $id, 'date_add' => date("Y-m-d")])->distinct()->all();
		$category = $top[0]['category'];
		$products = Product::find()->asArray()->where(['category' => $category, 'date_add' => date("Y-m-d")])->all();
		if (!isset($products[0])) {
			return $this->render('message');
		}
		foreach ($products as $key => $value) {
			$new_arr[$value['sub_category']][]=$value;
		}
		return $this->render('index', compact('new_arr', 'category', 'top'));
	}

	public function actionView($category) {
		$category = Yii::$app->request->get('category');
		$id_service = Product::find()->select('serv_id')->where(['category' => $category])->distinct()->one();
		$products = Product::find()->asArray()->where(['category' => $category, 'date_add' => date("Y-m-d")])->all();
		foreach ($products as $key => $value) {
			$new_arr[$value['sub_category']][]=$value;
		}
		return $this->render('view', compact('new_arr', 'category', 'id_service'));
	}

	public function actionSearch(){
        $params = trim(Yii::$app->request->get('query'));
        $params=strip_tags($params);
        if (Yii::$app->request->get('query') != $params){
            $this->redirect(\yii\helpers\Url::to(['category/search', 'query'=>$params]));
        }

        if (!$params=='') {
            $products = Product::find()->asArray()->where(['like', 'sub_category', $params])
                ->orWhere(['like', 'product_name', $params])
                ->all();
            foreach ($products as $key => $value) {
                $new_arr[$value['sub_category']][] = $value;
            }
            return $this->render('view', compact('new_arr'));
        }
        else $this->redirect(\yii\helpers\Url::to(['@web/index.php']));

    }
}