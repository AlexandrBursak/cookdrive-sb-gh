<?php

namespace app\models;
use yii\db\ActiveRecord;

class Service extends ActiveRecord {

	public static function tableName() {
		return 'service';
	}

	public function getProduct() {
		return $this->hasMany(Product::className(), ['serv_id' => 'id']);
	}
}