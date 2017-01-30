<?php

namespace app\models;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord {

	public static function tableName() {
		return 'cart';
	}

	public function addToCart($product, $qty) {
		if (isset($_SESSION['cart'][$product->id])) {
			$_SESSION['cart'][$product->id]['qty'] += $qty;
		}
		else{
			$_SESSION['cart'][$product->id] = [
				'qty' => $qty,
				'name' => $product->product_name,
				'price' => $product->price,
				'img' => $product->photo_url,
				'description' => $product->description,
                'service_id' => $product->serv_id
			];
		}
		$_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;

		$_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $product->price : $qty * $product->price;
	}

	public function recalc($id){
		if (!isset($_SESSION['cart'][$id])) return false;
		$qtyMinus = $_SESSION['cart'][$id]['qty'];
		$sumMinus = $_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price'];
		$_SESSION['cart.qty'] -= $qtyMinus;
		$_SESSION['cart.sum'] -= $sumMinus;
		unset($_SESSION['cart'][$id]);
	}

	public function changeToCart($product, $qty){
		
		$_SESSION['cart'][$product->id]['qty'] = $qty;

		$qty_all = 0;
		$sum_all = 0;

		foreach ($_SESSION['cart'] as $id => $item){
			$qty_all += $item['qty'];
			$sum_all += $item['qty'] * $item['price'];	
		}
		$_SESSION['cart.qty'] = $qty_all;
		$_SESSION['cart.sum'] = $sum_all;
	}
}	