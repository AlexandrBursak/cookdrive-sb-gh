<?php

namespace app\controllers;
use app\models\Product;
use Yii;

use yii\web\Controller;

class CategoryController extends Controller {

	public function actionIndex($service_id) {
		$top = Product::find()->asArray()->select('category')->where(['serv_id' => $service_id, 'date_add' => date("Y-m-d")])->distinct()->all();
        if (!isset($top[0])) {
            return $this->render('message');
        }
		$category = $top[0]['category'];
		$products = Product::find()->asArray()->where(['category' => $category, 'date_add' => date("Y-m-d")])->all();

		foreach ($products as $key => $value) {
			$new_arr[$value['sub_category']][]=$value;
		}
		return $this->render('index', compact('new_arr', 'category', 'top'));
	}

	public function actionView() {
		$category = Yii::$app->request->get('category');
        $service_id = Yii::$app->request->get('service_id');
		//$id = Product::find()->select('serv_id')->where(['category' => $category])->distinct()->one();
		$products = Product::find()->asArray()->where(['category' => $category, 'date_add' => date("Y-m-d")])->all();
        $top = Product::find()->asArray()->select('category')->where(['serv_id' => $service_id, 'date_add' => date("Y-m-d")])->distinct()->all();
		foreach ($products as $key => $value) {
			$new_arr[$value['sub_category']][]=$value;
		}
		return $this->render('view', compact('new_arr', 'category', 'top'));
	}

	public function actionSearch($service_id){
        $params = trim(Yii::$app->request->get('query'));
        //$id_service = trim(Yii::$app->request->get('id'));
        $params=strip_tags($params);
        $service_id = strip_tags($service_id);
        if (Yii::$app->request->get('query') != $params){
            $this->redirect(\yii\helpers\Url::to(['category/search', ['service_id'=>$service_id, 'query'=>$params]]));
        }

        if ($params!='') {
            $products = Product::find()->asArray()->where(['like', 'sub_category', $params])
                ->orWhere(['like', 'product_name', $params])
                ->andWhere(['serv_id' => $service_id])
                ->all();
            foreach ($products as $key => $value) {
                $new_arr[$value['sub_category']][] = $value;
            }
            return $this->render('view', compact('new_arr', 'service_id'));
        }
        else $this->redirect(\yii\helpers\Url::to(['@web/index.php']));

    }
}