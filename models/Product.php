<?php


namespace app\models;


use yii\db\ActiveRecord;

use app\models\Service;


class Product extends ActiveRecord{

    public function getService()
    {

        return $this->hasOne(Service::className(), ['id' => 'serv_id']);
    }
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_name', 'photo_url'], 'required'],
            [['description', 'ingredients'], 'string'],
            [['price'], 'number'],
            [['date_add'], 'safe'],
            [['serv_id'], 'integer'],
            [['product_name', 'weight', 'photo_url', 'category', 'sub_category'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_name' => 'Product Name',
            'description' => 'Description',
            'weight' => 'Weight',
            'ingredients' => 'Ingredients',
            'price' => 'Price',
            'photo_url' => 'Photo Url',
            'date_add' => 'Date Add',
            'category' => 'Category',
            'sub_category' => 'Sub Category',
            'serv_id' => 'Serv ID',
        ];
    }

}