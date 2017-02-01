<?php

namespace app\controllers;
use app\models\Product;
use Yii;

use yii\web\Controller;

class CategoryController extends Controller {

	public function actionIndex() {
		$top = Product::find()->asArray()->select('category')->distinct()->all();
		$category = $top[0]['category'];
		$products = Product::find()->asArray()->where(['category' => $category])->all();
		foreach ($products as $key => $value) {
			$new_arr[$value['sub_category']][]=$value;
		}
		return $this->render('index', compact('new_arr', 'category'));
	}

	public function actionView($category) {
		$category = Yii::$app->request->get('category');
		$products = Product::find()->asArray()->where(['category' => $category])->all();
		foreach ($products as $key => $value) {
			$new_arr[$value['sub_category']][]=$value;
		}
		return $this->render('view', compact('new_arr', 'category'));
	}
	public function actionSearch(){
        $params = trim(Yii::$app->request->get('query'));
        $params=str_replace('+', '', $params);
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