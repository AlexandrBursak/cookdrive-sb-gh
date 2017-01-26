<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Product;
use app\models\Cart;
use Yii;

class CartController extends Controller {

	public function actionIndex() {
		$session = Yii::$app->session;
		$session->open();
		return $this->render('index', compact('session'));
	}

	public function actionAdd() {
		$id = Yii::$app->request->get('id');
		$qty = (int)Yii::$app->request->get('qty');
		$qty = !$qty ? 1 : $qty;
		$product = Product::findOne($id);
		$session = Yii::$app->session;
		$session->open();
		$cart = new Cart();
		if(!empty($product)) {
			$cart->addToCart($product, $qty);
		}
		$this->layout = false;
		$qty = empty($session['cart.qty']) ? 0 : $session['cart.qty'];
		return json_encode(array(
			cart_count=> $qty,
			cart_html=> $this->render('index', compact('session'))
			));
	}

	public function actionClear() {
		$session = Yii::$app->session;
		$session->open();
		$session->remove('cart');
		$session->remove('cart.qty');
		$session->remove('cart.sum');
		$this->layout = false;
		$qty = empty($session['cart.qty']) ? 0 : $session['cart.qty'];
		return json_encode(array(
			cart_count=> $qty,
			cart_html=> $this->render('index', compact('session'))
			));
	}

	public function actionDel(){
		$id = Yii::$app->request->get('id');
		$session = Yii::$app->session;
		$session->open();
		$cart = new Cart();
		$cart->recalc($id);
		$this->layout = false;
		$qty = empty($session['cart.qty']) ? 0 : $session['cart.qty'];
		return json_encode(array(
			cart_count=> $qty,
			cart_html=> $this->render('index', compact('session'))
			));
	}

	public function actionChange(){
		$id = Yii::$app->request->get('id');
		$qty = (int)Yii::$app->request->get('qty');
		$qty = !$qty ? 1 : $qty;
		$product = Product::findOne($id);
		$session = Yii::$app->session;
		$session->open();
		$cart = new Cart();
		if(!empty($product)) {
			$cart->changeToCart($product, $qty);
		}
		$this->layout = false;
		$qty = empty($session['cart.qty']) ? 0 : $session['cart.qty'];
		return json_encode(array(
			cart_count=> $qty,
			cart_html=> $this->render('index', compact('session'))
			));
	}

	public function actionConfirmOrder() {

	}


}