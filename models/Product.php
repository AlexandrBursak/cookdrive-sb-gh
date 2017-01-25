<?php

namespace app\models;
use yii\db\ActiveRecord;

class Product extends ActiveRecord {

	public static function tableName() {
		return 'product';
	}

	public function getService() {
		return $this->hasOne(Service::className(), ['id' => 'serv_id']);
	}
}