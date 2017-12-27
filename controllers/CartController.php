<?php
namespace app\controllers;
use app\models\History;
use yii\web\Controller;
use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\SkypeBot;
use Yii;
class CartController extends Controller {
	public function actionIndex() {
		$session = Yii::$app->session;
		$session->open();
		return $this->render('index', compact('session'));
	}
	public function actionAdd() {
		if (Yii::$app->request->isAjax){
			$id = Yii::$app->request->get('id');
			if (Product::findOne($id)) {
				$qty = (int)Yii::$app->request->get('qty');
				if (($qty = intval($qty)) && ($qty > 0)) {
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
						'cart_count'=> $qty,
						'cart_html'=> $this->render('index', compact('session'))
					));
				}
			}
		}
		else{
			return $this->redirect(['site/error']);
		}
	}
	public function actionClear() {
		if (Yii::$app->request->isAjax){
			$session = Yii::$app->session;
			$session->open();
			$session->remove('cart');
			$session->remove('cart.qty');
			$session->remove('cart.sum');
			$this->layout = false;
			$qty = empty($session['cart.qty']) ? 0 : $session['cart.qty'];
			return json_encode(array(
				'cart_count'=> $qty,
				'cart_html'=> $this->render('index', compact('session'))
			));
		}
		else{
			return $this->redirect(['site/error']);
		}
	}
	public function actionDel(){
		if (Yii::$app->request->isAjax){
			$id = Yii::$app->request->get('id');
			if (Product::findOne($id)) {
				$session = Yii::$app->session;
				$session->open();
				$cart = new Cart();
				$cart->recalc($id);
				$this->layout = false;
				$qty = empty($session['cart.qty']) ? 0 : $session['cart.qty'];
				return json_encode(array(
					'cart_count'=> $qty,
					'cart_html'=> $this->render('index', compact('session'))
				));
			}
		}
		else{
			return $this->redirect(['site/error']);
		}
	}
	public function actionChange(){
		if (Yii::$app->request->isAjax){
			$id = Yii::$app->request->get('id');
			if (Product::findOne($id)) {
				$qty = (int)Yii::$app->request->get('qty');
				if ((($qty = intval($qty)) && ($qty > 0))) {
					$qty = $qty;
				}
				else{
					$qty = 1;
				}
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
					'cart_count'=> $qty,
					'cart_html'=> $this->render('index', compact('session'))
				));
			}		
		}
		else{
			return $this->redirect(['site/error']);
		}
	}
	public function actionConfirm() {
  		if (Yii::$app->request->isAjax) {
   			$session = Yii::$app->session;
   			if (!(\Yii::$app->user->isGuest)) {
				if ((History::myBalance(\Yii::$app->user->id))>-3000) {
	    			if (isset($session['cart'])) {
						
	     				foreach ($session['cart'] as $key => $value) {
	     					
	     					$order = new Order();
						    $order->date = date("Y:m:d");
						    $order->user_id = \Yii::$app->user->id;
						    $order->product_id = $key;
						    $order->quantity = $value['qty'];
						    $order->product_name = $value['name'];
						    $order->product_price = $value['price'];
						    $order->product_serv_id = $value['service_id'];
						    $order->save();
							
							$orders[$key]['product_name'] = $value['name'];
							$orders[$key]['quantity'] = $value['qty'];
							$orders[$key]['sum'] = $value['qty'] * $value['price'];
	                        $history = new History();
	                        $history->orders_id = $order->id;
	                        $history->summa = -($order->quantity * $value['price']);
	                        $history->operation = 1;
	                        $history->users_id = $order->user_id;
	                        $history->date = date("Y:m:d");
	                        $history->save();
	    
	     				}

						\Yii::$app->user->identity->sendOrderMail($orders);

						
						$skype = new SkypeBot();
						$skype->init();
						$skype->sendOrder($orders);

						
						$session->open();
						$session->remove('cart');
						$session->remove('cart.qty');
						$session->remove('cart.sum');
						$this->layout = false;
						$qty = empty($session['cart.qty']) ? 0 : $session['cart.qty'];
						return json_encode(array(
							'cart_count'=> $qty,
							'cart_html'=> $this->render('index', compact('session'))
						));
	    			} 
	    			
	    			else {
	    			}
	    		}
	    		else {
	    			return json_encode(array(
	    				'balance' => History::myBalance(\Yii::$app->user->id)
					));
	    		}
    		}
   			else { 	
			}
   		}
		else $this->redirect(['site/error']);
	}
}

	     		