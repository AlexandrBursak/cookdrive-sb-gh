<?php

namespace app\controllers;
use app\models\Service;
use Yii;

use yii\web\Controller;

class ServiceController extends Controller {

	public function actionIndex() {
		$service = Service::find()->asArray()->all();
		return $this->render('index', compact('service'));
	}

}