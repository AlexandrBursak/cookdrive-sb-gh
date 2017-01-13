<?php
/**
 * Created by PhpStorm.
 * User: MyBe
 * Date: 12.01.2017
 * Time: 12:52
 */

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class HelloController extends Controller
{
    public function actionIndex()
    {
        echo 'Hi!';
    }

}